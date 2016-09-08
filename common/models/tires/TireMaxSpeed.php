<?php

namespace common\models\tires;

use Yii;

/**
 * This is the model class for table "{{%tires_max_speed}}".
 *
 * @property integer $id
 * @property string $index
 * @property integer $speed
 * @property integer $status
 */
class TireMaxSpeed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_max_speed}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['speed', 'status'], 'integer'],
            [['index'], 'string', 'max' => 4],
        	[['speed','index'], 'unique'],
        	[['speed','index'], 'required'],
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
            'speed' => Yii::t('app', 'Speed'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
