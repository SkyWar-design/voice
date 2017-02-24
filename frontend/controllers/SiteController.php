<?php
namespace frontend\controllers;

use common\models\CardVoice;
use common\models\Page;
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
use frontend\models\Gate_sms;
use frontend\models\Calendar;
use \common\models\Category;
use yii\web\Response;


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
        $this->setCategories();
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

    public function actionCall()
    {
        $gate = new Gate_sms();

        $send = $gate->call_send("79040752185", "<file 1>", 0, 0, [
            "/var/www/voice_git/frontend/web/mp3/125689.mp3"
        ]);

//        $send = $gate->get_status(43,79040752185,0);
//        array(4) { [0]=> string(2) "44" [1]=> string(2) "14" [2]=> string(4) "3.36" [3]=> string(4) "85.9" }
//        array(4) { [0]=> string(1) "1" [1]=> string(10) "1486752562" [2]=> string(1) "0" [3]=> string(1) "1" }

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
        $categories =  Category::getListCategory();
        $css_style_categories = Yii::$app->params['css_style_categories'];
        return $this->render('catalog', [
            'categories' => $categories,
            'css_style_categories' => $css_style_categories
        ]);
    }
    public function actionCalendar($month = 0)
    {
        if ($month ==0)$month = date('m');
        $calendar = new Calendar();
        $month_ru_name = $calendar->month_now($month);
        $ru_month = $calendar->russian_date($month);
        $date_now = date('d');
        $calendar_build =  $calendar->build_calendar($month,date('y'));




        return $this->render('calendar',[
            'month_now' =>$month,
            'month_ru_name'=>$month_ru_name,
            'calendar_build'=>$calendar_build,
            'ru_month' => $ru_month,
            'date_now'=> $date_now
        ]);
    }
    public function actionCalendar_search($month)
    {

        $calendar = new Calendar();
        $month_ru_name = $calendar->month_now($month);
        $ru_month = $calendar->russian_date($month);
        $calendar_build =  $calendar->build_calendar($month,date('y'));




        return $this->render('calendar',[
            'month_now' =>$month,
            'month_ru_name'=>$month_ru_name,
            'calendar_build'=>$calendar_build,
            'ru_month' => $ru_month
        ]);
    }

    public function actionCategory($id)
    {
        $add_condition = ')';
        $categories = Category::getListCategory();
        $css_style_categories = Yii::$app->params['css_style_categories'];

        $params = [
            'card_voice' => [
                'category' => false
            ]
        ];

        $current_category = Category::find()
            ->where(['=','id', $id])
            ->one();
        if( !is_null($current_category->this_id) ){
            $main_category = Category::find()
                ->where(['=','id', $current_category->this_id])
                ->one();
            $params['card_voice']['category'] = $current_category->id;
        }
        else{
            $params['card_voice']['category'] = explode(',',implode(',',array_keys($categories[$current_category->id]['subcategories'])));
            $main_category = $current_category;
        }

        $card_voice = new CardVoice(['scenario' => 'search']);

        $order = false;
        if( Yii::$app->request->isGet ){
            $request = Yii::$app->request->get();
            if( isset($request['sort']) ){
                $order = $request['sort'];
            }
            if( isset($request['card_voice']['sex']) ){
                $params['card_voice']['sex'] = $request['card_voice']['sex'];
            }
        }

        $dataProvider = $card_voice->searchCard_voice($params, $order);

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
    public function actionTag($name)
    {

        $dataProvider = CardVoice::searchTag($name);

        return $this->render('tag_search',[
            'dataProvider' => $dataProvider,
            'search' => $name
        ]);

    }
    public function actionName($name)
    {

        $dataProvider = CardVoice::searchName($name);

        return $this->render('tag_search',[
            'dataProvider' => $dataProvider,
            'search' => $name
        ]);

    }

    public function actionSearch($search){

        $dataProvider = CardVoice::searchGlobal($search);

        return $this->render('tag_search',[
            'dataProvider' => $dataProvider,
            'search' => $search
        ]);
    }

    //страница хиты
    public function actionHits(){

        $params = [];

        if( Yii::$app->request->isGet ){
            $request = Yii::$app->request->get();
            if( isset($request['card_voice']['sex']) ){
                $params['card_voice']['sex'] = $request['card_voice']['sex'];
            }
        }

        $card_voice = new CardVoice(['scenario' => 'search']);
        $dataProvider = $card_voice->searchCard_voice($params, 'popular');
        return $this->render('hits', [
            'dataProvider' => $dataProvider
        ]);
    }

    //страница новинки
    public function actionNew(){
        $params = [];
        $card_voice = new CardVoice(['scenario' => 'search']);
        $dataProvider = $card_voice->searchCard_voice($params, 'publish_date');
        return $this->render('new_card', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCard($id)
    {

        $model = Page::find()->where(['=','id',$id])->one();
        return $this->render('card',[
            'model' => $model
        ]);
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
