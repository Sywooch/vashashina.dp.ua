<?php

namespace common\models\tires;

use Yii;

/**
 * This is the model class for table "{{%tires_radius}}".
 *
 * @property integer $id
 * @property string $radius
 * @property integer $status
 */
class TireRadius extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_radius}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
        	[['radius'], 'unique'],
        	[['radius'], 'required'],
            [['radius'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'radius' => Yii::t('app', 'Radius'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
