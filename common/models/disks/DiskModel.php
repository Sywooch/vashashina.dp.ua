<?php

namespace common\models\disks;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%disks_models}}".
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
 * @property integer $category_id
 * @property string $tip
 * @property string $image
 * @property string $thumbnail
 * @property integer $views
 * @property integer $created
 * @property integer $updated
 * @property integer $status
 * @property integer $featured
 * @property integer $created_by
 * @property integer $updated_by
 */
class DiskModel extends \yii\db\ActiveRecord
{
    public $imageFile;
	public $thumbnailFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%disks_models}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_k', 'meta_d', 'short_desc', 'long_desc'], 'string'],
            [['brand_id', 'category_id', 'views','kol_otverstiy', 'created', 'updated', 'status', 'featured', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'pageTitle','color'], 'string', 'max' => 255],
            [['tip'], 'string', 'max' => 40],
            [['image', 'thumbnail'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'brand' => Yii::t('app', 'Brand'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'tip' => Yii::t('app', 'Type'),
            'color' => Yii::t('app', 'Color'),
            'kol_otverstiy' => Yii::t('app', 'Holes Number'),
            'pageTitle' => Yii::t('app', 'Page Title'),
            'meta_k' => Yii::t('app', 'Meta K'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'short_desc' => Yii::t('disk', 'Short Desc'),
            'long_desc' => Yii::t('disk', 'Long Desc'),
            'brand_id' => Yii::t('disk', 'Brand ID'),
            'category_id' => Yii::t('disk', 'Category ID'),
            'tip' => Yii::t('disk', 'Type'),
            'image' => Yii::t('disk', 'Image'),
            'thumbnail' => Yii::t('disk', 'Thumbnail'),
            'views' => Yii::t('disk', 'Views'),
            'created' => Yii::t('disk', 'Created'),
            'updated' => Yii::t('disk', 'Updated'),
            'status' => Yii::t('disk', 'Status'),
            'featured' => Yii::t('disk', 'Featured'),
            'created_by' => Yii::t('disk', 'Created By'),
            'updated_by' => Yii::t('disk', 'Updated By'),
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
        public  function  getBrand()
{
return  $this->hasOne(DiskManufacturer::className(),  ['id'  =>  'brand_id']);
}/**/

	public function getCategory(){
		$this->hasOne(\common\models\Category::className(),  ['id'  =>  'category_id']);
	}/**/
public function getCountDisks(){		
		return Disk::find()->where(['model_id'=>$this->id])->count();		
	}/**/
public function getFullTitle(){
    return mb_convert_case($this->brand->title, MB_CASE_TITLE, 'UTF-8').' '.mb_convert_case($this->title, MB_CASE_TITLE, 'UTF-8'); 
} /**/        

public function beforeSave($insert){
	$this->title = mb_convert_case($this->title,MB_CASE_TITLE,'UTF-8');
	return parent::beforeSave($insert);
}/**/
        
public function afterDelete(){
	Disk::deleteAll('model_id='.$this->id);
}/**/


public function getUrl(){
	return Url::to(['/diski/'.$this->brand->alias.'/'.$this->alias]);
}/**/

public function getImageUrl(){
	if ($this->image){
        $url = '/images/disks/'.$this->brand->alias.'/'.$this->alias.'/'.$this->image;
    } else{
        $url = '/images/disk_icon.jpg'; 
    }
	return Url::to([$url]);
}/**/

public function getThumbnailUrl(){
	 if ($this->thumbnail){
        $url = '/images/disks/'.$this->brand->alias.'/'.$this->alias.'/'.$this->thumbnail;
    } else{
        $url = '/images/disk_icon_thumb.jpg'; 
    }
	return Url::to([$url]);
}/**/

//получаем значения для генерация тега Title
public function reciveRandomPTTData(){
	$metaData = \backend\models\MetaTagTemplate::find()->select('text')
	->where('metaTag = "pageTitle" AND `table` = "vs_disks_models"')->asArray()->all();
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
	$metaData =  \backend\models\MetaTagTemplate::find()->select('text')
	->where('metaTag = "meta_d" AND `table` = "vs_disks_models"')->asArray()->all();
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
	$metaData =  \backend\models\MetaTagTemplate::find()->select('text')
	->where('metaTag = "meta_k" AND `table` = "vs_disks_models"')->asArray()->all();
	$data = '';
	foreach ($metaData as $value){
		$data .= $value['text'].';';
		$data .= PHP_EOL;
	}
	//   var_dump($data);die;
	return $data;
}/**/


}/**/
