<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $count_card
 */
class Category extends \yii\db\ActiveRecord
{
    public function getDropName()
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
            [['category_id', 'count_card'], 'integer'],
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
            'category_id' => 'Category ID',
            'name' => 'Name',
            'count_card' => 'Count Card',
        ];
    }
}
