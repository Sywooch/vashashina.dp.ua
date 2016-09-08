<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%services}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $page_title
 * @property string $meta_k
 * @property string $meta_d
 * @property string $text
 * @property integer $views
 * @property integer $created
 * @property integer $updated
 * @property integer $created_by
 * @property integer $updated_by
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%services}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['views', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'page_title', 'meta_k', 'meta_d'], 'string', 'max' => 255]
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
            'meta_k' => Yii::t('app', 'Meta K'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'text' => Yii::t('app', 'Text'),
            'views' => Yii::t('app', 'Views'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }/**/
    
    public function getUrl(){
        return \yii\helpers\Url::to(['/uslugi/'.$this->alias]);
    }/**/ 
    
}/**/
