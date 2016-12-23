<?php
namespace frontend\controllers;

use common\models\CardVoice;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Authorize;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use \common\models\Category;
use yii\web\Response;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $session;
    public $db;
    public $css_style; //css класс для главной категории
    public $main_category;//id главной категории

    public function init()
    {
        parent::init();
        $this->session = Yii::$app->session; //создаем сесию
        $this->session->open();
        $this->db = Yii::$app->db;
        $this->setCategories();//вызовем функцию для заполнения категорий
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionBlog()
    {
        return $this->render('blog');
    }

    public function actionCatalog()
    {
        $categories = $this->categories;
        $css_style_categories = Yii::$app->params['css_style_categories'];
        return $this->render('catalog', [
            'categories' => $categories,
            'css_style_categories' => $css_style_categories
        ]);
    }

    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    public function actionCategory($id)
    {
        $add_condition = '';
        $categories = $this->categories;
        $css_style_categories = Yii::$app->params['css_style_categories'];


        $current_category = Category::find()
            ->where(['=','id', $id])
            ->one();
        if( !is_null($current_category->this_id) ){
            $main_category = Category::find()
                ->where(['=','id', $current_category->this_id])
                ->one();
        }
        else{
            $add_condition .= ' AND category_id IN ('.implode(', ',array_keys($categories[$current_category->id]['subcategories'])).')';
            $main_category = $current_category;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => CardVoice::find()
                ->where('status=1'.$add_condition),
            'pagination' => [
                'pageSize' => 18,
            ],
        ]);



        $this->css_style = $css_style_categories[$main_category->id];
        $this->main_category = [
            'id' => $main_category->id,
            'name' => $main_category->name,
            'css_style' => $css_style_categories[$main_category->id]
        ];

        return $this->render('category',[
            'current_category' => $current_category,
            'categories' => $categories,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCard()
    {
        return $this->render('card');
    }

    //генерируем уникальный хэш для localstorage что бы запоминать пользователь на уровне браузера и в дальнейшем перенести пользователя со статистикой в личный кабинет
    public function actionHash(){
        if( Yii::$app->request->isAjax ){
            $hash = '';
            $random_letter = array_merge(range('A','Z'),range('a','z'),range('0','9'));
            $c = count($random_letter);
            for($i=0;$i<28;$i++) {
                $hash .= $random_letter[rand(0,$c)];
            }
            //создаем нового пользователя
            $this->db->createCommand('INSERT INTO users(local_storage_hash) VALUES (:hash)')
                ->bindValue(':hash', $hash)
                ->execute();
            $this->session['user_id'] = $this->db->getLastInsertID();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['result' => true, 'hash' => $hash];
        }
        else{
            return $this->redirect('/');
        }
    }
    //если hash у пользователя уже есть залогинем его
    public function actionSession(){
        if( Yii::$app->request->isAjax ){
            $hash = Yii::$app->request->post('hash', false);
            if( $hash ){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if( !isset($this->session['user_id']) ){
                    if(
                    $user_id = $this->db->createCommand('SELECT id FROM users WHERE local_storage_hash=:hash')
                        ->bindValue(':hash', $hash)
                        ->queryOne()
                    )
                    {
                        $this->session['user_id'] = $user_id['id'];
                        return ['result' => true];
                    }
                    else{
                        return ['result' => false];
                    }
                }
                else{
                    return ['result' => true];
                }
            }
            else{
                return $this->redirect('/');
            }
        }
        else{
            return $this->redirect('/');
        }
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Authorize();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
