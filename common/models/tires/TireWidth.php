<?php

namespace common\models\tires;

use Yii;

/**
 * This is the model class for table "{{%tires_width}}".
 *
 * @property integer $id
 * @property double $width
 * @property integer $status
 */
class TireWidth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_width}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['width'], 'number'],
        	[['width'], 'unique'],
        	[['width'], 'required'],
            [['status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'width' => Yii::t('app', 'Width'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
