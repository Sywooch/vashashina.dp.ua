<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cat_params}}".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $title
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class CatParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cat_params}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','cat_id'], 'required'],
            [['cat_id', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_id' => Yii::t('app', 'Cat ID'),
        	'category' => Yii::t('app', 'Category'),
            'title' => Yii::t('app', 'Title'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }/**/
    
    public function getCategory(){
    	return  $this->hasOne(Category::className(),  ['id'  =>  'cat_id']);
    	 
    }/**/
    
    
}/**/
