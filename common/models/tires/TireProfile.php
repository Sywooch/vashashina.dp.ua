<?php

namespace common\models\tires;

use Yii;

/**
 * This is the model class for table "{{%tires_profiles}}".
 *
 * @property integer $id
 * @property string $profile
 * @property integer $status
 */
class TireProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_profiles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['profile'], 'string', 'max' => 10],
        	[['profile'], 'unique'],
        	[['profile'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile' => Yii::t('app', 'Profile'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
