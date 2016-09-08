<?php

namespace common\models\tires;

use Yii;

/**
 * This is the model class for table "{{%tires_seasons}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 */
class TireSeason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tires_seasons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 25],
        	[['title'], 'unique'],
        	[['title'], 'required'],
            [['alias'], 'string', 'max' => 20],
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
        ];
    }
}
