<?php
namespace backend\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Authorize;
use yii\data\ActiveDataProvider;
use common\models\CardVoice;
use backend\models\Db;
use common\models\Page;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Authorize::isAdmin(Yii::$app->user->identity->username);
                        }
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionCards()
    {
        $this->enableCsrfValidation = false;

        $filter = Yii::$app->request->get('filter');
        $filter_category = Yii::$app->request->get('category');

        $query = Db::get_card_all($filter,$filter_category);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('cards',[
            'dataProvider' => $dataProvider,
            'filter' =>$filter,
            'filter_category'=>$filter_category
        ]);
    }
    public function actionPages()
    {
        $this->enableCsrfValidation = false;

        $filter = Yii::$app->request->get('filter');

        $query = Db::get_page_all($filter);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('pages',[
            'dataProvider' => $dataProvider,
            'filter' =>$filter
        ]);
    }
    public function actionAbout()
    {
    }

    public function actionDel_card()
    {
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('card_array');

        //удаление данных
        if($request)
            return json_encode(Db::del_card($request), JSON_FORCE_OBJECT);
        else{
            return false;
        }
        
    }
    public function actionDel_page()
    {
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('page_array');

        //удаление данных
        if($request)
            return json_encode(Db::del_page($request), JSON_FORCE_OBJECT);
        else{
            return false;
        }

    }


    public function actionAdd_card()
    {
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('card_array');

        //запись данных
        if($request)
            return json_encode(Db::save_card($request,2), JSON_FORCE_OBJECT);


        return $this->render('add_cards',[
        ]);
    }
    public function actionAdd_page()
    {
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('page_array');

        //добавление страницы
        if($request)
//            return true;
            return json_encode(Db::save_page($request,2), JSON_FORCE_OBJECT);


        return $this->render('add_page',[
        ]);
    }

    public function actionEdit_page(){
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('page_array');
        $card_edit = Yii::$app->request->get('page_edit');

        //запись данных
        if($request)
            return json_encode(Db::save_page($request,1), JSON_FORCE_OBJECT);

        //вывод данных
        if($card_edit)
            $result = Db::get_page_one($card_edit);
        else{
            $result = Db::get_random_page();
        }

        return $this->render('edit_page',[
            'card_array'=>$result
        ]);
    }


    public function actionEdit_card()
    {
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('card_array');
        $card_edit = Yii::$app->request->get('card_edit');

        //запись данных
        if($request)
        return json_encode(Db::save_card($request,1), JSON_FORCE_OBJECT);

        //вывод данных
        if($card_edit)
            $result = Db::get_card_one($card_edit);
        else{
            $result = Db::get_random_card();
        }

        return $this->render('edit_cards',[
            'card_array'=>$result
        ]);
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request->post('card_array');

        //сохранение
        if($request)
        return json_encode(Db::update_card($request), JSON_FORCE_OBJECT);
        else{
            return false;
        }
    }

    public function actionUpdate_page()
    {
        $request = Yii::$app->request->post('card_array');

        //сохранение
        if($request)
            return json_encode(Db::update_page($request), JSON_FORCE_OBJECT);
        else{
            return false;
        }

    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Authorize();
        if ($model->load(Yii::$app->request->post()) && $model->login_admin()) {
            $this->layout = 'main';
            return $this->render('index', [
                'model' => $model,
            ]);
        } else {
            $this->layout = 'alter';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

    }
}
