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

    public function actionAbout()
    {
//        \moonland\phpexcel\Excel::export([
//            'models' => CardVoice::find()->all(),
//            'columns' => [
//                'id',
//                'url'
//            ],
//            'headers' => [
//                'voice_title' => 'Date Created Content',
//            ],
//        ]);
        $model1 =  CardVoice::find()
            ->select('card_voice.*,category.name')
            ->joinWith('category')
            ->orderBy('id')->all();
        echo '123';
        \moonland\phpexcel\Excel::export([
            'models' => $model1,
            'columns' => [
            'id','url','mp3_id','voice_description','voice_keywords','voice_title',
            'voice_text_h1','voice_text_description','voice_text_theme','voice_text_tags',
            'category.name','voice_date','sex','status'
            ],
        ]);
        echo '123';
    }

    public function actionEdit_card()
    {
        $this->enableCsrfValidation = false;
        $request = Yii::$app->request->post('card_array');
        $card_edit = Yii::$app->request->get('card_edit');

        //запись данных
        if($request)
        return json_encode(Db::save_card($request), JSON_FORCE_OBJECT);

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
