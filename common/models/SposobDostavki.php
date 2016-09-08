<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sposobi_dostavki}}".
 *
 * @property integer $id
 * @property string $title
 * @property double $price
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class SposobDostavki extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sposobi_dostavki}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255]
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
            'price' => Yii::t('app', 'Price'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
