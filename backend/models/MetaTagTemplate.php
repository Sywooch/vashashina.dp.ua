<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%metaTag_templates}}".
 *
 * @property integer $id
 * @property string $text
 * @property string $metaTag
 * @property string $table
 */
class MetaTagTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%metaTag_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['metaTag','text', 'table'], 'required'],
            [['metaTag', 'table'], 'string'],
            [['text'], 'string', 'max' => 255],
            ['text','trim']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'metaTag' => Yii::t('app', 'Meta Tag'),
            'table' => Yii::t('app', 'Table'),
        ];
    }/**/
    
}/*end of Class*/
