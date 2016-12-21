<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $this_id
 * @property string $name
 * @property integer $count_card
 */
class Category extends \yii\db\ActiveRecord
{
    public static function getDropName()
    {
        $query = "SELECT id,name from category group by name";
        $result = Yii::$app->db
            ->createCommand($query)
            ->queryAll();
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['this_id', 'count_card'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'this_id' => 'Category ID',
            'name' => 'Name',
            'count_card' => 'Count Card',
        ];
    }


    public static function getListCategory(){
        $categories = self::find()->all();
        $list_categories = [];
        echo '<pre>';
        print_r($categories);
        echo '</pre>';
//        foreach ( $categories as $category ){
//            if( $category->this_id == NULL ){
//                if( isset($list_categories[$category->this_id]) ){
//                    $list_categories[$category->id]['name_category'] = $category->name;
//                }
//                else{
//                    $list_categories[$category->id] = [
//                        'name_category' => $category->name,
//                        'subcategories' => []
//                    ];
//                }
//            }
//            else{
//                if( isset($list_categories[$category->this_id]) ){
//                    $list_categories[$category->id]['subcategories'][$category->id] = $category->name;
//                }
//                else{
//                    $list_categories[$category->id] = [
//                        'name_category' => false,
//                        'subcategories' => [
//                            $category->id => $category->name
//                        ]
//                    ];
//                }
//            }
//        }
        return $list_categories;
    }
}
