<?php

namespace app\frontend\modules\models;

use Yii;

/**
 * This is the model class for table "{{%tires}}".
 *
 * @property integer $id
 * @property string $full_title
 * @property integer $model_id
 * @property integer $width_id
 * @property integer $profile_id
 * @property integer $diameter_id
 * @property integer $max_load_id
 * @property integer $max_speed_id
 * @property string $ship
 * @property string $usilennaya
 * @property integer $quantity
 * @property double $price
 * @property double $discount
 * @property integer $status
 */
class Tires extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'width_id', 'profile_id', 'diameter_id', 'max_load_id', 'max_speed_id', 'quantity', 'status'], 'integer'],
            [['price', 'discount'], 'number'],
            [['full_title'], 'string', 'max' => 255],
            [['ship'], 'string', 'max' => 7],
            [['usilennaya'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_title' => Yii::t('app', 'Полное название'),
            'model_id' => Yii::t('app', 'ID модели'),
            'width_id' => Yii::t('app', 'Ширина'),
            'profile_id' => Yii::t('app', 'Профиль'),
            'diameter_id' => Yii::t('app', 'Диаметр'),
            'max_load_id' => Yii::t('app', 'Макс. нагрузка'),
            'max_speed_id' => Yii::t('app', 'Макс скорость'),
            'ship' => Yii::t('app', 'Шипованная'),
            'usilennaya' => Yii::t('app', 'Усиленная'),
            'quantity' => Yii::t('app', 'Количество'),
            'price' => Yii::t('app', 'Цена'),
            'discount' => Yii::t('app', 'Скидка'),
            'status' => Yii::t('app', 'Статус'),
        ];
    }/**/
    
    
}/*end of class*/
