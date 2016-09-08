<?php

namespace common\models\tires;

use Yii;

/**
 * This is the model class for table "{{%tires_max_load}}".
 *
 * @property integer $id
 * @property string $index
 * @property double $max_load
 * @property string $status
 */
class TireMaxLoad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_max_load}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max_load'], 'number'],
            [['status'], 'string'],
            [['index'], 'string', 'max' => 10],
        	[['max_load','index'], 'unique'],
        	[['max_load','index'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'index' => Yii::t('app', 'Index'),
            'max_load' => Yii::t('app', 'Max Load'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
