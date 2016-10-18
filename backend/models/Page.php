<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $card_id
 * @property string $url
 * @property string $description
 * @property string $keywords
 * @property string $title
 * @property string $text_h1
 * @property integer $status
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'status'], 'integer'],
            [['url'], 'string', 'max' => 300],
            [['description', 'keywords', 'title', 'text_h1'], 'string', 'max' => 3000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'url' => 'Url',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'title' => 'Title',
            'text_h1' => 'Text H1',
            'status' => 'Status',
        ];
    }
}
