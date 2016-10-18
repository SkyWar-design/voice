<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $card_id
 * @property string $url
 * @property string $voice_description
 * @property string $voice_keywords
 * @property string $voice_title
 * @property string $voice_text_h1
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
            [['voice_description', 'voice_keywords', 'voice_title', 'voice_text_h1'], 'string', 'max' => 3000],
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
            'voice_description' => 'Voice Description',
            'voice_keywords' => 'Voice Keywords',
            'voice_title' => 'Voice Title',
            'voice_text_h1' => 'Voice Text H1',
            'status' => 'Status',
        ];
    }
}
