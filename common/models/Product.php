<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;
use backend\models\MetaTagTemplate;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $page_title
 * @property string $meta_d
 * @property string $meta_k
 * @property string $short_desc
 * @property string $long_desc
 * @property string $thumbnail
 * @property string $image
 * @property string $grouping
 * @property integer $status
 * @property integer $category_id
 * @property integer $featured
 * @property integer $price
 * @property integer $quantity
 * @property double $discount
 * @property integer $views
 * @property integer $discount_begin
 * @property integer $discount_end
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class Product extends \yii\db\ActiveRecord
{
	public $imageFile;
	public $thumbnailFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['title','required'],
        	['title','trim'],
            [['long_desc'], 'string'],
            [['status','brand_id', 'category_id', 'featured', 'price', 'quantity', 'views', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['discount'], 'number'],
            [['title', 'alias', 'pageTitle', 'meta_d', 'meta_k', 'short_desc', 'thumbnail', 'image'], 'string', 'max' => 255],
            [['imageFile', 'thumbnailFile'], 'file', 'extensions' => ['png', 'jpg','jpeg', 'gif'], 'maxSize' => 1024*1024],
            [['grouping'], 'string', 'max' => 16],
            [['discount_begin', 'discount_end',],'safe'],
            [['discount_begin', 'discount_end',], 'default', 'value' => null],
        ];
    }/**/
    
    public function behaviors()
    {
    	return [
    		[
    		'class' => SluggableBehavior::className(),
    		'attribute' => 'title',
    		'slugAttribute' => 'alias',
    		],
      /*       'MetaDataBehavior'=>[
            'class'=> \backend\behaviors\metaData\MetaDataBehavior::className(),
            'pageTitleTemplate'=>'Купить/Заказать/Выбрать %НАЗВАНИЕ ТОВАРА% в магазине/в интернет магазине/ с доставкой по Украине/в Киев/по Днепропетровску. Магазин/Интернет магазин/Туристический магазин/ Магазин для туристов Турляндия',
            'autoPageTitle'=>1,
        	'randomPTT'=>1,
            'randomPTTData'=>$this->getRandomPTTData(),
            'meta_dTemplate'=>'%НАЗВАНИЕ ТОВАРА%/купить %НАЗВАНИЕ ТОВАРА% в киеве,
//харькове, донецке, одессе, львове: цена, отзывы, продажа - интернет-магазин турляндия',
            'autoMeta_d'=>1,
        	'randomMDT'=>1,
            'randomMDTData'=>$this->getRandomMDTData(),
            'meta_kTemplate'=>'Купить %НАЗВАНИЕ ТОВАРА% %ПРОИЗВОДИТЕЛЬ%',
            'autoMeta_k'=>1,
        	'randomMKT'=>1,
            'randomMKTData'=>$this->getRandomMKTData(),
          //  'from'=>['/%НАЗВАНИЕ ТОВАРА%/iu','/%ПРОИЗВОДИТЕЛЬ%/iu','/%КАТЕГОРИЯ%/iu'],
          //  'to'=>[die(var_dump($this->getTitle())),],
	
            'replaceDescription'=>array('%НАЗВАНИЕ%','%КАТЕГОРИЯ%','%ПРОИЗВОДИТЕЛЬ%'),
            ],
       */     
    	];
    }/**/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'pageTitle' => Yii::t('app', 'Page Title'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'meta_k' => Yii::t('app', 'Meta K'),
            'short_desc' => Yii::t('app', 'Short Desc'),
            'long_desc' => Yii::t('app', 'Long Desc'),
            'thumbnail' => Yii::t('app', 'Thumbnail'),
            'image' => Yii::t('app', 'Image'),
            'imageFile' => Yii::t('app', 'Image File'),
            'grouping' => Yii::t('app', 'Grouping'),
            'status' => Yii::t('app', 'Status'),
            'brand_id' => Yii::t('app', 'Brand ID'),
            'brand'=>  Yii::t('app', 'Brand'),
            'category_id' => Yii::t('app', 'Category ID'),
            'category'=>  Yii::t('app', 'Category'),
            'featured' => Yii::t('app', 'Featured'),
            'price' => Yii::t('app', 'Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'discount' => Yii::t('app', 'Discount'),
            'views' => Yii::t('app', 'Views'),
            'discount_begin' => Yii::t('app', 'Discount Begin'),
            'discount_end' => Yii::t('app', 'Discount End'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }/**/
    
    public function getCategory(){
    	return  $this->hasOne(Category::className(),  ['id'  =>  'category_id']);
    	
    }/**/
    
    public function getBrand(){
    	return  $this->hasOne(Brand::className(),  ['id'  =>  'brand_id']);
    	
    }/**/
  
    public function getParams(){
    	return  $this->hasMany(ProductParam::className(),  ['product_id'  =>  'id']);
    	
    }/**/
    
    
        public function beforeValidate(){
    	if ($this->discount_begin)
    	$this->discount_begin = strtotime($this->discount_begin);
    	if ($this->discount_end)
    		$this->discount_end = strtotime($this->discount_end);
    		
    	return parent::beforeValidate();
    }/**/
       
    public function getUrl(){
    	return \yii\helpers\Url::to(['/products/'.$this->category->alias.'/'.$this->alias]);
    }/**/
    
    public function getImageUrl(){
    	return Url::to(['/images/products/'.$this->title.'/'.$this->image]);
    }/**/
    
    public function getThumbnailUrl(){
    	return Url::to(['/images/products/'.$this->title.'/'.$this->thumbnail]);
    }/**/
    
    public function getToCartUrl(){
    	return \yii\helpers\Url::to(['/cart/add/'.$this->category_id.'/'.$this->id]);
    }/**/
    
    public function getPrice(){
    	return $this->price;
    }/**/
    //получаем значения для генерация тега Title
    public function reciveRandomPTTData(){
        $metaData = MetaTagTemplate::find()->select('text')
                ->where('metaTag = "pageTitle" AND `table` = "vs_products"')->asArray()->all();
        $data = '';
        foreach ($metaData as $value){
            $data .= $value['text'].';';
            $data .= PHP_EOL;
        }
     //   var_dump($data);die;
        return $data;
    }/**/
    //получаем значения для генерация тега Meta D
    public function reciveRandomMDTData(){
    	$metaData = MetaTagTemplate::find()->select('text')
    	->where('metaTag = "meta_d" AND `table` = "vs_products"')->asArray()->all();
    	$data = '';
    	foreach ($metaData as $value){
    		$data .= $value['text'].';';
    		$data .= PHP_EOL;
    	}
    	//   var_dump($data);die;
    	return $data;
    }/**/
    
    //получаем значения для генерация тега Meta D
    public function reciveRandomMKTData(){
    	$metaData = MetaTagTemplate::find()->select('text')
    	->where('metaTag = "meta_k" AND `table` = "vs_products"')->asArray()->all();
    	$data = '';
    	foreach ($metaData as $value){
    		$data .= $value['text'].';';
    		$data .= PHP_EOL;
    	}
    	//   var_dump($data);die;
    	return $data;
    }/**/
    
    protected function getTitle(){
    	return $this->id;
    }/**/
    
    protected function getBrandTitle(){
    	return $this->brand->title;
    }
    
    protected function getCategoryTitle(){
    	return $this->category->title;
    }
    
}/**/
