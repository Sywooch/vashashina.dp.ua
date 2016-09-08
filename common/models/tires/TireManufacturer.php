<?php

namespace common\models\tires;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tires_manufactures}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $status
 */
class TireManufacturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_manufactures}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['title'],'required'],
        	[['title'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],     		
        	[['title'],'unique'],
            [['status','created','updated','created_by','updated_by'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255]
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
            'status' => Yii::t('app', 'Status'),
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
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created',
            'updatedAtAttribute' => 'updated',
        //    'value' => new Expression('NOW()'),
        ],
	];
}/**/

public function beforeSave($insert){
	$this->title = mb_convert_case($this->title,MB_CASE_TITLE,'UTF-8');
	return parent::beforeSave($insert);
}/**/

public function getTitle(){
    return mb_convert_case($this->title,MB_CASE_TITLE,'UTF-8');
}

}