<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $img
 * @property string $date_post
 * @property integer $section_id
 * @property integer $rating
 * @property integer $user_id
 */
class Articles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'date_post', 'section_id', 'rating', 'user_id'], 'required'],
            [['text'], 'string'],
            [['date_post'], 'safe'],
            [['section_id', 'rating', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'string', 'min' => 150],
            [['img'], 'image', 'extensions' => 'png, jpg', 'minWidth' => 300, 'minHeight' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'name' => 'Тема',
            'text' => 'Статья',
            'img' => 'Изображение',
            'date_post' => 'Дата поста',
            'section_id' => '№ раздела',
            'rating' => 'Рейтинг',
            'user_id' => '№ автора',
        ];
    }
}
