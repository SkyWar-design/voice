<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
/**
 * This is the model class for table "card_voice".
 *
 * @property integer $id
 * @property string $url
 * @property integer $mpr3_id
 * @property string $voice_description
 * @property string $voice_keywords
 * @property string $voice_title
 * @property string $voice_text_h1
 * @property string $voice_text_description
 * @property string $voice_text_theme
 * @property string $voice_text_tags
 * @property integer $category_id
 * @property string $voice_date
 * @property string $sex
 * @property integer $status
 */
class CardVoice extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function getDropStatus()
    {
        return array(
            0=>'Неактивна',
            1=>'Активна',
        );
    }
    public function getDropSex()
    {
        return array(
            2=>'Для женщины',
            1=>'Для мужчины',
            0=>'Неважно',
        );
    }
    public function getDropCategory()
    {
        $query = "SELECT id,name from category group by name";
        $result = Yii::$app->db
            ->createCommand($query)
            ->queryAll();
        $array=[];
        foreach ($result as $result_to) {
            $array [$result_to['id']] = $result_to['name'];
        }
        return $array;
    }
    public static function tableName()
    {
        return 'card_voice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mp3_id', 'category_id', 'status'], 'integer'],
            [['voice_date'], 'safe'],
            [['voice_text_description', 'voice_text_theme'], 'string', 'max' => 3000],
            [['voice_text_tags'], 'string', 'max' => 2000],
            [['sex'], 'string', 'max' => 50],
            [['sex','category_id'], 'safe', 'on' => 'search']
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getPage(){
        return $this->hasOne(Page::className(), ['card_id' => 'id']);
    }

    //получить id главной категории
    public function getMainCategory(){
        $card_category = $this->category->mainCategory->name;
        return $card_category;
//        if( !is_null($card_category->id) ){
//            $main_category_id = $card_category->this_id;
//            $main_category_name = $card_category->mainCategory;
//        }
//        else{
//            $main_category_id = $card_category->id;
//            $main_category_name = $card_category->name;
//        }
//        return [
//            'id' => $main_category_id,
//            'name' => $main_category_name
//        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mp3_id' => 'Mp3 ID',
            'voice_text_description' => 'Текст карточки',
            'voice_text_theme' => 'Тематика карточки',
            'voice_text_tags' => 'Тэги карточки',
            'category_id' => 'Категория',
            'voice_date' => 'Дата праздника',
            'sex' => 'Пол',
            'status' => 'Статус карточки',
            'category.name' => 'Категория'
        ];
    }

    //поиск по тегам
    public function searchTag($name){

        $count = Yii::$app->db->createCommand(
            'SELECT count(*) FROM card_voice join page on card_id=card_voice.id WHERE voice_text_tags like :name and card_voice.status=:status',
            [':status' => 1, ':name' => '%'.$name.'%'])->queryScalar();


        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM card_voice join page on card_id=card_voice.id  WHERE voice_text_tags like :name and card_voice.status=:status',
            'params' => [':status' => 1,':name' => '%'.$name.'%'],
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'age',
                    'name' => [
                        'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                        'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return $dataProvider;
    }

    public function searchName($name){

        $count = Yii::$app->db->createCommand(
            'SELECT count(*) FROM card_voice join page on card_id=card_voice.id WHERE voice_text_description like :name and voice_text_description like :name_2 and card_voice.status=:status',
            [':status' => 1, ':name' => '%'.$name.'%',':name_2'=>'%с именинами%'])->queryScalar();


        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM card_voice join page on card_id=card_voice.id  WHERE voice_text_description like :name and voice_text_description like :name_2 and card_voice.status=:status',
            'params' => [':status' => 1,':name' => '%'.$name.'%',':name_2'=>'%с именинами%'],
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'age',
                    'name' => [
                        'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                        'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return $dataProvider;
    }

    //условия поиска для вывода списка карточек
    public function searchCard_voice($params, $order = false){
        $query = self::find();
        if( $order ){
            if( $order == 'popular' ){
                $order = 'count_order';
            }
            else{
                $order = 'publish_date';
            }
            $query->addOrderBy([$order => SORT_DESC]);
        }

        if( isset($params['card_voice']['category']) ){
            $query->andFilterWhere(['IN','category_id',$params['card_voice']['category']]);
        }

        if( isset($params['card_voice']['sex']) ){
            $query->andFilterWhere(['=', 'sex',$params['card_voice']['sex']]);
        }

        $query->andFilterWhere(['=', 'status', 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                    'id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => 18,
            ],
        ]);

        return $dataProvider;
    }

}
