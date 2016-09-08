<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%articles}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $page_title
 * @property string $meta_d
 * @property string $meta_k
 * @property string $image
 * @property string $desc
 * @property string $text
 * @property integer $views
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class Article extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $thumbnailFile;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc', 'text'], 'string'],
            [['views', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'page_title', 'meta_d', 'meta_k', 'image','thumbnail'], 'string', 'max' => 255],
         //   [['image', 'thumbnail'], 'string', 'max' => 55],
            [['imageFile', 'thumbnailFile'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
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
            [
            		'class' => 'Zelenin\yii\behaviors\Slug',
            		'slugAttribute' => 'alias',
            		'attribute' => 'title',
            // optional params
            //		'ensureUnique' => true,
           	//	    'translit' => true,
            	//	'replacement' => '-',
            //		'lowercase' => true,
            	//	'immutable' => false,
            		// If intl extension is enabled, see http://userguide.icu-project.org/transforms/general. 
           			// 'transliterateOptions' => 'Russian-Latin/BGN;'
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
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'page_title' => Yii::t('app', 'Page Title'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'meta_k' => Yii::t('app', 'Meta K'),
            'image' => Yii::t('app', 'Image'),
            'desc' => Yii::t('app', 'Desc'),
            'text' => Yii::t('app', 'Text'),
            'views' => Yii::t('app', 'Views'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }/**/
    
        public function getUrl(){
    	return \yii\helpers\Url::to(['/articles/'.$this->alias]);
    }/**/
            public function getImageUrl(){
    	return \yii\helpers\Url::to(['/images/articles/'.$this->alias.'/'.$this->image]);
    }/**/
    
}/*end of Model*/
