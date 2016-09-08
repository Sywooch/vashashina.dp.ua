<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%comments}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $text
 * @property string $author_email
 * @property string $author
 * @property integer $author_id
 * @property integer $category_id
 * @property integer $item_id
 * @property integer $created
 * @property integer $updated
 * @property double $rating
 * @property string $subscribe
 * @property string $status
 */
class Comment extends \yii\db\ActiveRecord
{
    public $captcha;
    public $reCaptcha;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'author_id', 'category_id', 'item_id', 'created', 'updated'], 'integer'],
            [['author','author_email','text', 'category_id', 'item_id'], 'required'],
            [['text'], 'string'],
            [['rating'], 'number'],
            [['author_email'], 'email'],
            [['author_email', 'author', 'status'], 'string', 'max' => 255],
            [['captcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
            [['subscribe'], 'string', 'max' => 4]
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'text' => Yii::t('app', 'Comment Text'),
            'author_email' => Yii::t('app', 'Email'),
            'author' => Yii::t('app', 'Name'),
            'author_id' => Yii::t('app', 'Author ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'rating' => Yii::t('app', 'Rating'),
            'subscribe' => Yii::t('app', 'Subscribe'),
            'status' => Yii::t('app', 'Status'),
        ];
    }/**/
   
    public function beforeValidate() {
        if ($this->text)
        $this->text = \yii\helpers\HtmlPurifier::process($this->text);
       return parent::beforeValidate();
    }/**/
   
}/*end of Model*/
