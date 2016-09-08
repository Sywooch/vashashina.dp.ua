<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_per_order}}".
 *
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $category_id
 * @property integer $quantity
 * @property double $price
 * @property double $subtotal
 * @property string $options
 * @property integer $gift_id
 */
class ProductsPerOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_per_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'required'],
            [['product_id', 'category_id', 'quantity', 'gift_id'], 'integer'],
            [['price', 'subtotal'], 'number'],
            [['options'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'subtotal' => Yii::t('app', 'Subtotal'),
            'options' => Yii::t('app', 'Options'),
            'gift_id' => Yii::t('app', 'Gift ID'),
        ];
    }/**/
    
    public function getProduct(){
     switch ($this->category_id){
             case "1":
               return $this->hasOne(\common\models\tires\Tire::className(),  ['id'  =>  'product_id']);
                 break;
              case "13":
               return $this->hasOne(\common\models\disks\Disk::className(),  ['id'  =>  'product_id']);
                 break;
             default :
              return $this->hasOne(Product::className(),  ['id'  =>  'product_id']);
              break;
         }
    	
    }/**/
    
    public function getCategory(){
    	
    			return $this->hasOne(\common\models\Category::className(),  ['id'  =>  'category_id']);
    	
    	 
    }/**/
   
    
}/**/
