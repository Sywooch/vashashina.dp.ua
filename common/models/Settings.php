<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property string $name
 * @property string $value
 * @property string $memo
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['memo'], 'string'],
            [['name', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'memo' => Yii::t('app', 'Memo'),
        ];
    }
}
