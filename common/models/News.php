<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $page_title
 * @property string $meta_d
 * @property string $meta_k
 * @property string $desc
 * @property string $text
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc', 'text'], 'string'],
            [['views','created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'page_title', 'meta_d', 'meta_k'], 'string', 'max' => 255]
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
            'page_title' => Yii::t('app', 'Page Title'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'meta_k' => Yii::t('app', 'Meta K'),
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
    	return \yii\helpers\Url::to(['/news/'.$this->alias]);
    }/**/
    
}/**/
