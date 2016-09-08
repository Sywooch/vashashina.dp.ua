<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%brands}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $pageTitle
 * @property string $meta_d
 * @property string $meta_k
 * @property string $desc
 * @property string $logo
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brands}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['title', 'alias', 'pageTitle', 'meta_d', 'meta_k', 'logo'], 'string', 'max' => 255]
        ];
    }/**/

    
    public function behaviors() {
        return[
            [
    		'class' => 'Zelenin\yii\behaviors\Slug',
    		'attribute' => 'title',
    		'slugAttribute' => 'alias',
    		],
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
            'pageTitle' => Yii::t('app', 'Page Title'),
            'meta_d' => Yii::t('app', 'Meta D'),
            'meta_k' => Yii::t('app', 'Meta K'),
            'desc' => Yii::t('app', 'Desc'),
            'logo' => Yii::t('app', 'Logo'),
        ];
    }
}
