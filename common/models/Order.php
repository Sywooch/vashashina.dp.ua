<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property double $suma
 * @property string $payment_status
 * @property string $delivery_status
 * @property integer $sposob_oplati
 * @property integer $sposob_dostavki
 * @property integer $created
 * @property integer $updated
 * @property integer $manager_id
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'sposob_oplati', 'sposob_dostavki', 'created', 'updated', 'manager_id'], 'integer'],
            [['suma'], 'number'],
            [['payment_status', 'delivery_status'], 'string'],
        	[['payment_status', 'delivery_status'], 'default','value'=> 'pending'],
        	[['email'], 'default','value'=> 0],
        	[['memo'], 'string','max'=>255],
        	[['sposob_oplati', 'sposob_dostavki'],'required'],
        ];
    }/**/
    
    public function behaviors()
    {
    	return [
    			[
    					'class' => TimestampBehavior::className(),
    					'createdAtAttribute' => 'created',
    					'updatedAtAttribute' => 'updated',
    			],
    			/* [
    			 'class' => BlameableBehavior::className(),
    					'createdByAttribute' => 'created_by',
    					'updatedByAttribute' => 'LastUpdatedBy',
    			],*/
    	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'suma' => Yii::t('app', 'Sum'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'delivery_status' => Yii::t('app', 'Delivery Status'),
            'sposob_oplati' => Yii::t('app', 'Payment'),
            'sposob_dostavki' => Yii::t('app', 'Delivery'),
        	'memo'=>Yii::t('app','Memo'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'manager_id' => Yii::t('app', 'Manager ID'),
        ];
    }/**/
    
    public function cancel(){
    	$this->delivery_status = 'cancelled';
    	$this->payment_status = 'cancelled';
    	$this->save();
    }/**/
    
        public function complete(){
    	$this->delivery_status = 'delivered';
    	$this->payment_status = 'completed';
    	$this->save();
    }/**/
    
    public function getUser(){
    	return $this->hasOne(User::className(),  ['id'  =>  'customer_id']);
    }/**/
    
    public function getProductsPerOrder(){
    	return $this->hasMany(ProductsPerOrder::className(),  ['order_id'  =>  'id']);
    }/**/
    
    public function getSposobOplati(){
    	return $this->hasOne(SposobOplati::className(),  ['id'  =>  'sposob_oplati']);
    }/**/
    
    public function getSposobDostavki(){
    	return $this->hasOne(SposobDostavki::className(),  ['id'  =>  'sposob_dostavki']);
    }/**/
    
    public function afterDelete(){
    	 \common\models\ProductsPerOrder::deleteAll('order_id = :order_id',
    			[':orders_id'=>$this->id]);
    	 
    	return parent::afterDelete();
    }/**/
    
    
}/**/
