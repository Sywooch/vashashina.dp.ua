<?php

namespace common\models\disks;

use Yii;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%disks}}".
 *
 * @property integer $id
 * @property string $full_title
 * @property integer $model_id
 * @property string $width
 * @property string $diameter
 * @property string $pcd
 * @property string $pcd2
 * @property string $et
 * @property integer $quantity
 * @property double $price
 * @property integer $category_id
 * @property double $discount
 * @property integer $discount_begin
 * @property integer $discount_end
 * @property integer $views
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $update_by
 */
class Disk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%disks}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'quantity', 'category_id', 'discount_begin', 'discount_end', 'views', 'status', 'created', 'updated', 'created_by', 'update_by'], 'integer'],
            [['price', 'discount'], 'number'],
            [['full_title'], 'string', 'max' => 255],
            [['width', 'diameter', 'pcd','pcd2', 'et','stupitsa'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_title' => Yii::t('disk', 'Full Title'),
            'model_id' => Yii::t('disk', 'Model ID'),
            'width' => Yii::t('tires', 'Width'),
            'diameter' => Yii::t('tires', 'Diameter'),
            'pcd' => Yii::t('disk', 'PCD'),
            'et' => Yii::t('disk', 'ET'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'category_id' => Yii::t('disk', 'Category ID'),
            'discount' => Yii::t('app', 'Discount'),
            'discount_begin' => Yii::t('app', 'Discount Begin'),
            'discount_end' => Yii::t('app', 'Discount End'),
            'views' => Yii::t('app', 'Views'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'update_by' => Yii::t('app', 'Update By'),
        ];
    }/**/
        public function behaviors()
{
    return [
        [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created',
            'updatedAtAttribute' => 'updated',
        //    'value' => new Expression('NOW()'),
        ],
    ];
}/**/
    
    public function beforeValidate(){
        if ($this->width) $this->width = (string)  $this->width;
    	if ($this->discount_begin)
    	$this->discount_begin = strtotime($this->discount_begin);
    	if ($this->discount_end)
    		$this->discount_end = strtotime($this->discount_end);
    		
    	return parent::beforeValidate();
    }/**/
    
    public function getTitle(){
        $title = mb_convert_case($this->diskModel->brand->title,MB_CASE_TITLE,'UTF-8').' '
            .mb_convert_case($this->diskModel->title,MB_CASE_UPPER,'UTF-8').' '
            . ''.$this->width.'x'.(int)$this->diameter.' '.$this->diskModel->kol_otverstiy.'x'.$this->pcd.''
            . ' ET'.$this->et.' DIA'.$this->stupitsa;
        if ($this->diskModel->color)
            $title .= '('.$this->diskModel->color.')';
        return $title;
        
    }/**/
    
        public function getCategory(){
    	return  $this->hasOne(\common\models\Category::className(),  ['id'  =>  'category_id']);
    	 
    }/**/
    
    public function getDiskModel(){
        return  $this->hasOne(DiskModel::className(),  ['id'  =>  'model_id']);
    }/**/
    
    public function getPrice(){
        return $this->price;
    }/**/
  
    public function getFullUrl(){
        $url = 'diski/';
        $url .= $this->diskModel->brand->alias.'/'.$this->diskModel->alias;
        $url = \yii\helpers\Url::to([$url,'disk_id'=>  $this->id]);
        return $url;
    }
    
    public function getToCartUrl(){
    return \yii\helpers\Url::to(['/cart/add','category_id'=>$this->category_id,'id'=> $this->id]); 
}/**/

public function getImageUrl(){
	return $this->diskModel->imageUrl;
}/**/

public function getThumbnailUrl(){
	return $this->diskModel->thumbnailUrl;
}/**/ 
    
}/**/
