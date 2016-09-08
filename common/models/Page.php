<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $page_title
 * @property string $content
 * @property string $meta_k
 * @property string $meta_d
 * @property integer $views
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['views','status', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'page_title', 'meta_k', 'meta_d'], 'string', 'max' => 255]
        ];
    }/**/
    
    public function behaviors()
    {
    	return [
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
            'content' => Yii::t('app', 'Content'),
            'meta_k' => Yii::t('app', 'Meta K'),
            'meta_d' => Yii::t('app', 'Meta D'),
        	'views' => Yii::t('app', 'Views'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
