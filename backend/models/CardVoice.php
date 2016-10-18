<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card_voice".
 *
 * @property integer $id
 * @property integer $mp3_id
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
    /**
     * @inheritdoc
     */
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
            [['voice_text_h1', 'voice_text_description', 'voice_text_theme', 'voice_text_tags'], 'string', 'max' => 3000],
            [['sex'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mp3_id' => 'Mp3 ID',
            'voice_text_h1' => 'Voice Text H1',
            'voice_text_description' => 'Voice Text Description',
            'voice_text_theme' => 'Voice Text Theme',
            'voice_text_tags' => 'Voice Text Tags',
            'category_id' => 'Category ID',
            'voice_date' => 'Voice Date',
            'sex' => 'Sex',
            'status' => 'Status',
        ];
    }
}
