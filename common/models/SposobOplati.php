<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sposobi_oplati}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $shop_data
 * @property integer $rekviziti_id
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class SposobOplati extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sposobi_oplati}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rekviziti_id', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'shop_data'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'shop_data' => Yii::t('app', 'Shop Data'),
            'rekviziti_id' => Yii::t('app', 'Rekviziti ID'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
