<?php

namespace common\models\tires;

use Yii;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%tires}}".
 *
 * @property integer $id
 * @property string $full_title
 * @property integer $model_id
 * @property string $width
 * @property string $profile
 * @property string $diameter
 * @property string $max_load
 * @property string $max_speed
 * @property string $ship
 * @property string $usilennaya
 * @property string $tip_shiny
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
class Tire extends \yii\db\ActiveRecord
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
            [['model_id', 'quantity', 'category_id','views', 'status', 'created', 'updated', 'created_by', 'update_by'], 'integer'],
            [['model_id'],'required'],
            [['price', 'discount'], 'number'],
            [['full_title'], 'string', 'max' => 255],
            [['width', 'profile', 'diameter', 'max_load', 'max_speed','tip_shiny'],'string', 'max' => 11],
            [['ship'], 'string', 'max' => 7],
            [['usilennaya'], 'string', 'max' => 5],
        //	[['discount_begin', ],'date','timestampAttribute'=>'discount_begin'],
        	[['discount_begin', 'discount_end',],'safe'],
        	[['discount_begin', 'discount_end',], 'default', 'value' => null],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_title' => Yii::t('app', 'Full Title'),
            'model_id' => Yii::t('tires', 'Model ID'),
            'width' => Yii::t('tires', 'Width ID'),
            'profile' => Yii::t('tires', 'Profile'),
            'diameter' => Yii::t('tires', 'Diameter'),
            'max_load' => Yii::t('tires', 'Max Load'),
            'max_speed' => Yii::t('tires', 'Max Speed'),
            'ship' => Yii::t('tires', 'Ship'),
            'usilennaya' => Yii::t('tires', 'Usilennaya'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'category_id' => Yii::t('app', 'Category ID'),
            'discount' => Yii::t('app', 'Discount'),
            'discount_begin' => Yii::t('app', 'Discount Begin'),
            'discount_end' => Yii::t('app', 'Discount End'),
        	'views' => Yii::t('app', 'Views'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'update_by' => Yii::t('app', 'Update By'),
        		'tireWidth' => Yii::t('tires', 'Width'),
        		'tireProfile' => Yii::t('tires', 'Profile'),
        		'tireRadius' => Yii::t('tires', 'Diameter'),
        		'tireMaxLoad' => Yii::t('tires', 'Max Load'),
        		'tireMaxSpeed' => Yii::t('tires', 'Max Speed'),
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
        if ($this->width === 0) $this->width = '';
        
    	if ($this->discount_begin)
    	$this->discount_begin = strtotime($this->discount_begin);
    	if ($this->discount_end)
    		$this->discount_end = strtotime($this->discount_end);
    		
    	return parent::beforeValidate();
    }/**/
    
    public function getCategory(){
    	return  $this->hasOne(\common\models\Category::className(),  ['id'  =>  'category_id']);
    	 
    }/**/
    
    public function getTitle(){
    return    mb_convert_case($this->tireModel->brand->title,MB_CASE_TITLE,'UTF-8').' '.$this->tireModel->title.' '.$this->width.'/'.(int)$this->profile.' '
        .'R'.$this->diameter.' '.$this->max_load.$this->max_speed;
    }/**/
    
    
    
    public function getTireModel(){
        return  $this->hasOne(TireModel::className(),  ['id'  =>  'model_id']);
    }
    
    public function getCarType(){
        return $this->tireModel->carType;
    }
    
        public function getTireSeason(){
        return $this->tireModel->tireSeason;
    }
    
    public function getBrandTitle(){
       return mb_convert_case($this->tireModel->brand->title,MB_CASE_TITLE);
    }/**/
     public function getModelTitle(){
       return mb_convert_case($this->tireModel->title,MB_CASE_TITLE);
    }/**/
    
    public function getParams(){
        return $this->width.'/'.(int)$this->profile.' '
        .'R'.$this->diameter.' '.$this->max_load.$this->max_speed;
    }/**/
    /**
*  get  profile  relationship
*


public  function  getTireProfile()
{
return  $this->hasOne(TireProfile::className(),  ['id'  =>  'profile_id']);
}/**/
/*
 * width relationship
 
public  function  getTireWidth()
{
return  $this->hasOne(TireWidth::className(),  ['id'  =>  'width_id']);
}/**/

/*
 * Radius relationship
 
public  function  getTireRadius()
{
return  $this->hasOne(TireRadius::className(),  ['id'  =>  'diameter_id']);
}/**/

/*
 * MaxSpeed relationship
 
public  function  getTireMaxSpeed()
{
return  $this->hasOne(TireMaxSpeed::className(),  ['id'  =>  'max_speed_id']);
}/**/

/*
 * MaxLoad relationship
 
public  function  getTireMaxLoad()
{
return  $this->hasOne(TireMaxLoad::className(),  ['id'  =>  'max_load_id']);
}/**/

/*    
public function getTireParams(){
    return (int)$this->tireWidth->width.'/'.(int)$this->tireProfile->profile.' '.$this->tireRadius->radius;
}/**/

    /*
public function getFullMaxSpeed(){
    return $this->tireMaxSpeed->index.' до '.$this->tireMaxSpeed->speed.' км/ч ';
}/**/
/*
public function getFullMaxLoad(){
    return $this->tireMaxLoad->index.' - '.(int)$this->tireMaxLoad->max_load.' кг ';
}/**/

    
public function getToCartUrl(){
    return \yii\helpers\Url::to(['/cart/add','category_id'=>$this->category_id,'id'=> $this->id]); 
}/**/

public function getFullUrl(){
    $url = $this->tireModel->url;
    $url .='/';
    $url .=$this->id;
    $url .='/';
    $url .=preg_replace('/\//','_',$this->diameter.'-'.$this->profile.'-R'.$this->width.'-'.$this->max_load.'-'.$this->max_speed);
    $url .='/';
    $url .=$this->tireModel->carType->alias.'-'.$this->tireModel->tireSeason->alias;
    
    return $url;
}

public function getImageUrl(){
	return $this->tireModel->imageUrl;
}/**/

public function getThumbnailUrl(){
	return $this->tireModel->thumbnailUrl;
}/**/ 

public function getPrice(){
    return $this->price;
}/**/

}/*end of Model*/
