<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use wbraganca\behaviors\NestedSetBehavior;
use wbraganca\behaviors\NestedSetQuery; 

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $page_title
 * @property string $meta_k
 * @property string $meta_d
 * @property string $short_desc
 * @property string $long_desc
 * @property integer $status
 * @property integer $parentid
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class Category extends \yii\db\ActiveRecord
{
	public $position;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', ], 'required'],
            [['long_desc'], 'string'],
            [['status', 'parent_id', 'lft', 'rgt', 'root','level', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'page_title', 'meta_k', 'meta_d', 'short_desc','position'], 'string', 'max' => 255]
        ];
    }/**/
    
    public function behaviors()
    {
    	return [
    			 'slug' => [
            		'class' => 'Zelenin\yii\behaviors\Slug',
            		'slugAttribute' => 'alias',
            		'attribute' => 'title',
            // optional params
            		'ensureUnique' => true,
           	//	    'translit' => true,
            		'replacement' => '-',
            		'lowercase' => true,
            		'immutable' => false,
            		// If intl extension is enabled, see http://userguide.icu-project.org/transforms/general. 
           			// 'transliterateOptions' => 'Russian-Latin/BGN;'
       			 ],
    			
    			 [
    					'class' => NestedSetBehavior::className(),
    					 'rootAttribute' => 'root',
               			 'levelAttribute' => 'level',
                		 'hasManyRoots' => true,
    					 'leftAttribute' => 'lft',
    					 'rightAttribute' => 'rgt',
    					
    			],
    	];
    }/**/

  /*  public function transactions()
    {
    	return [
    			self::SCENARIO_DEFAULT => self::OP_ALL,
    	];
    }/**/
    
    public static function find()
    {
    	 return new NestedSetQuery(get_called_class());
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
            'page_title' => Yii::t('app', 'Page Title'),
            'meta_k' => Yii::t('app', 'Meta K'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'short_desc' => Yii::t('app', 'Short Desc'),
            'long_desc' => Yii::t('app', 'Long Desc'),
            'status' => Yii::t('app', 'Status'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        	'position' => Yii::t('app', 'Position'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }/**/
    
    public function getUrl(){
    	return \yii\helpers\Url::to(['/products/'.$this->alias]);
    }/**/
    
    
    public function getPositions(){
    	if ($this->isNewRecord){
    		$data = array(
    				'appendTo' => 'Вставить в... последней',
    				'prependTo' => 'Вставить в ... первой',
    				'insertAfter' => 'Вставить после...',
    				'insertBefore' => 'Вставить перед...',
    		);
    	} else {
    		$data = array(
    				'moveAsFirst' => 'Сделать первой',
    				'moveBefore' => 'Поместить перед',
    				'moveAfter' => 'Поместить после',
    				'moveAsLast' => 'Сделать последней',
    		);
    	}
    	return $data;
    }/**/
    
    public static function getDropDownList(){
    
    	$data = array();
    	$levels = array(1=>'',2=>'-',3=>'--',4=>'---',5=>'----');
    
    	$items = Category::find()->select('id,title,level')->orderBy('root,lft')->all();
    	foreach ($items as $key => $item){
    		$data[$item['id']] = $levels[$item['level']].$item['title'];
    	}
    
    	return $data;
    }/**/
    
}/**/
