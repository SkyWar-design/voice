<?php

namespace common\models;

use Yii;

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
        );
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
            [['id', 'mp3_id', 'category_id', 'status'], 'integer'],
            [['voice_date'], 'safe'],
            [['url'], 'string', 'max' => 300],
            [['voice_description', 'voice_keywords', 'voice_title', 'voice_text_h1', 'voice_text_description', 'voice_text_theme', 'voice_text_tags'], 'string', 'max' => 3000],
            [['sex'], 'string', 'max' => 50],
        ];
    }

    public function Category_bind()
    {
        return $this->hasMany(Category::className(), ['category.id' => 'card_voice.id']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'mp3_id' => 'Mp3 ID',
            'voice_description' => 'Description страницы',
            'voice_keywords' => 'Keywords страницы',
            'voice_title' => 'Title страницы',
            'voice_text_h1' => 'H1 страницы',
            'voice_text_description' => 'Текст карточки',
            'voice_text_theme' => 'Тематика карточки',
            'voice_text_tags' => 'Тэги карточки',
            'category_id' => 'Категория',
            'voice_date' => 'Дата праздника',
            'sex' => 'Пол',
            'status' => 'Статус карточки',
        ];
    }
}
