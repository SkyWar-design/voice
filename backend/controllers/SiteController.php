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

        if (empty($filter) or $filter == 3 ) {
            $filter = 3;
            $query = CardVoice::find()
                ->where(['<>','status' , $filter])
                ->orderBy('id');
        }

        if (!empty($filter) and $filter==1){
            $query = CardVoice::find()
                ->where(['=','status', $filter])
                ->orderBy('id');
        }

        if (!empty($filter) and $filter==2){
            $query = CardVoice::find()
                ->andWhere(['=','status', 0])
                ->orderBy('id');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
        return $this->render('cards',[
            'dataProvider' => $dataProvider,
            'filter' =>$filter
        ]);
    }

    public function actionAbout()
    {

        return $this->render('index');
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
            $result = Db::get_card($card_edit);
        else{
            $result = Db::get_random_card();
        }

//        if ($request) {
//            $result = Db::Edit_card($request);
//            return json_encode($result, JSON_FORCE_OBJECT);
//        }
//        if(!empty($request)){
//            try{
//                $date = explode('/', $request[12]['value']);
//                $date = $date[2]."-".$date[0]."-".$date[1]." 00:00:00";
//                $model = CardVoice::findOne(['id' => $request[1]['value']]);
//                $model->url = $request[0]['value'];
//                $model->mp3_id = $request[2]['value'];
//                $model->voice_description = $request[3]['value'];
//                $model->voice_keywords = $request[4]['value'];
//                $model->voice_title = $request[5]['value'];
//                $model->voice_text_h1 = $request[6]['value'];
//                $model->voice_text_description = $request[7]['value'];
//                $model->voice_text_theme = $request[8]['value'];
//                $model->voice_text_tags = $request[9]['value'];
//                $model->sex = $request[10]['value'];
//                $model->category_id = $request[11]['value'];
//                $model->voice_date = $date;
//                $model->status = 1;
//                $model->save();
//                $result = [
//                    "id" => $request[1]['value'],
//                    "status" => "success",
//                ];
//                return json_encode($result, JSON_FORCE_OBJECT);
//            }
//            catch(Exception $e){
//                $result = [
//                    "id" => $request[1]['value'],
//                    "status" => "error",
//                    "message"=> $e
//                ];
//                return json_encode($result, JSON_FORCE_OBJECT);
//            }
//        }



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
