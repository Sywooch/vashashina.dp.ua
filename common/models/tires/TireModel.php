<?php

namespace common\models\tires;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use common\models\Category;

/**
 * This is the model class for table "{{%tires_models}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $pageTitle
 * @property string $meta_k
 * @property string $meta_d
 * @property string $short_desc
 * @property string $long_desc
 * @property integer $brand_id
 * @property integer $car_type
 * @property integer $season
 * @property string $image
 * @property string $thumbnail
 * @property integer $created
 * @property integer $updated
 * @property integer $views
 * @property string $status
 * @property string $featured
 * @property integer $created_by
 * @property integer $updated_by
 */
class TireModel extends \yii\db\ActiveRecord
{
	
	public $imageFile;
	public $thumbnailFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_models}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','alias'], 'required'],
            [[ 'short_desc', 'long_desc', 'status', 'featured'], 'string'],
            [['brand_id', 'car_type', 'season','views', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'meta_k', 'pageTitle', 'meta_d'], 'string', 'max' => 255],
        	[['image', 'thumbnail'], 'string', 'max' => 55],
            [['imageFile', 'thumbnailFile'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
        	[['brand'],'safe']
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
             [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created',
            'updatedAtAttribute' => 'updated',
        //    'value' => new Expression('NOW()'),
        ],
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
            'meta_k' => Yii::t('app', 'Meta K'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'short_desc' => Yii::t('app', 'Short Desc'),
            'long_desc' => Yii::t('app', 'Long Desc'),
            'brand_id' => Yii::t('tires', 'Brand ID'),
        	'brand' => Yii::t('tires', 'Brand'),
            'car_type' => Yii::t('tires', 'Car Type'),
            'season' => Yii::t('tires', 'Season'),
            'image' => Yii::t('app', 'Image'),
        	'imageFile' => Yii::t('app', 'Image File'),
            'thumbnail' => Yii::t('app', 'Thumbnail'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        	'views' => Yii::t('app', 'Views'),
            'status' => Yii::t('app', 'Status'),
            'featured' => Yii::t('app', 'Featured'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }/**/
    
    public  function  getBrand()
{
return  $this->hasOne(TireManufacturer::className(),  ['id'  =>  'brand_id']);
}/**/

	public function getCategory(){
		$this->hasOne(Category::className(),  ['id'  =>  'category_id']);
	}

public  function  getCarType()
{
	return  $this->hasOne(TireCarType::className(),  ['id'  =>  'car_type']);
}/**/


public  function  getTireSeason()
{
	return  $this->hasOne(TireSeason::className(),  ['id'  =>  'season']);
}/**/

public function getFullTitle(){
    return mb_convert_case($this->brand->title, MB_CASE_TITLE, 'UTF-8').' '.mb_convert_case($this->title, MB_CASE_TITLE, 'UTF-8'); 
} /**/

	public function getCountTires(){		
		return Tire::find()->where(['model_id'=>$this->id])->count();		
	}/**/
public function beforeSave($insert){
	$this->title = mb_convert_case($this->title,MB_CASE_TITLE,'UTF-8');
	return parent::beforeSave($insert);
}/**/
        
public function afterDelete(){
	Tire::deleteAll('model_id='.$this->id);
}/**/


public function getUrl(){
	return Url::to(['/shiny/'.$this->brand->alias.'/'.$this->alias]);
}/**/

public function getImageUrl(){
    if ($this->image){
        $url = '/images/tires/'.$this->brand->alias.'/'.$this->alias.'/'.$this->image;
    } else{
        $url = '/images/tire_icon.jpg'; 
    }
	return Url::to([$url]);
}/**/

public function getSeasonImageUrl(){
    switch ($this->tireSeason->title){
        case "летние":
            $icon = 'summer_icon.png';
            break;
        case "зимние":
             $icon = 'winter_icon.png';
            break;
        case "всесезонные":
             $icon = 'all_season_icon.png';
            break;
        default:
            $icon = '';
            break;
    }
	return Url::to(['/images/icons/'.$icon]);
}/**/

public function getThumbnailUrl(){
	 if ($this->thumbnail){
        $url = '/images/tires/'.$this->brand->alias.'/'.$this->alias.'/'.$this->thumbnail;
    } else{
        $url = '/images/tire_icon_thumb.jpg'; 
    }
	return Url::to([$url]);
}/**/

public function getComments(){
    $this->hasMany(\common\models\Comment::className(),  ['category_id'  =>  'category_id','item_id'=>$this->id]);
}/**/

//получаем значения для генерация тега Title
public function reciveRandomPTTData(){
	$metaData = \backend\models\MetaTagTemplate::find()->select('text')
	->where('metaTag = "pageTitle" AND `table` = "vs_tires_models"')->asArray()->all();
	$data = '';
	foreach ($metaData as $value){
		$data .= $value['text'].';';
		$data .= PHP_EOL;
	}
	//   var_dump($data);die;
	return $data;
}/**/
//получаем значения для генерация тега Meta D
protected function reciveRandomMDTData(){
	$metaData =  \backend\models\MetaTagTemplate::find()->select('text')
	->where('metaTag = "meta_d" AND `table` = "vs_tires_models"')->asArray()->all();
	$data = '';
	foreach ($metaData as $value){
		$data .= $value['text'].';';
		$data .= PHP_EOL;
	}
	//   var_dump($data);die;
	return $data;
}/**/



//получаем значения для генерация тега Meta D
protected function reciveRandomMKTData(){
	$metaData =  \backend\models\MetaTagTemplate::find()->select('text')
	->where('metaTag = "meta_k" AND `table` = "vs_tires_models"')->asArray()->all();
	$data = '';
	foreach ($metaData as $value){
		$data .= $value['text'].';';
		$data .= PHP_EOL;
	}
	//   var_dump($data);die;
	return $data;
}/**/
	

	
}/*end of Model*/
