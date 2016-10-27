<?php

namespace backend\models\suppliers;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%tire_trader}}".
 *
 * @property integer $id_tovara
 * @property integer $tire_id
 * @property string $brend
 * @property string $model
 * @property string $nazvanie
 * @property string $sezon
 * @property string $tip_transportnogo_sredstva
 * @property string $tip_shiny
 * @property string $shirina_profilya
 * @property string $vysota_profilya
 * @property string $diametr_kolesa
 * @property string $indeks_nagruzki
 * @property string $indeks_skorosti
 * @property string $uslilennaya_shina
 * @property string $ship_neship
 * @property integer $data_obnovleniya_sklada
 * @property integer $ostatok
 * @property double $optovaya_iskhodnaya_cena
 * @property double $roznichnaya_iskhodnaya_cena
 * @property double $vykhodnaya_optovaya_cena
 * @property double $vykhodnaya_roznichnaya_cena
 * @property double $skidka
 * @property string $postavshhik
 * @property string $gorod
 * @property string $fajjl_izobrazhenie
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $LastUpdatedBy
 */
class TireTraderTires extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tire_trader_tires}}';
    }
    public function behaviors(){
    return [
        [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
        //    'value' => new Expression('NOW()'),
        ],
        [
            'class' => BlameableBehavior::className(),
            'createdByAttribute' => 'created_by',
            'updatedByAttribute' => 'LastUpdatedBy',
        ],
    ];
}/**/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
     //       [['id', 'tire_id'], 'required'],
            [['id', 'tire_id', 'ostatok', 'status', 'created_at', 'updated_at', 'created_by', 'LastUpdatedBy'], 'number'],
            [['nazvanie'], 'string'],
            [['tire_id'],'unique','skipOnEmpty'=>true],
            [['data_obnovleniya_sklada'], 'safe'],
            [['optovaya_iskhodnaya_cena', 'roznichnaya_iskhodnaya_cena', 'vykhodnaya_optovaya_cena', 'vykhodnaya_roznichnaya_cena', 'skidka'], 'number'],
            [['brend', 'model'], 'string', 'max' => 150],
            [['sezon', 'tip_transportnogo_sredstva', 'tip_shiny', 'gorod'], 'string', 'max' => 50],
            [['shirina_profilya', 'vysota_profilya', 'diametr_kolesa', 'indeks_nagruzki', 'indeks_skorosti'], 'string', 'max' => 10],
            [['uslilennaya_shina', 'ship_neship'], 'string', 'max' => 20],
            [['postavshhik'], 'string', 'max' => 100],
            [['fajjl_izobrazhenie'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tires', 'ID'),
            'tire_id' => Yii::t('tires', 'Tire ID'),
            'brend' => Yii::t('tires', 'Brend'),
            'model' => Yii::t('tires', 'Model'),
            'nazvanie' => Yii::t('tires', 'Nazvanie'),
            'sezon' => Yii::t('tires', 'Sezon'),
            'tip_transportnogo_sredstva' => Yii::t('tires', 'Tip Transportnogo Sredstva'),
            'tip_shiny' => Yii::t('tires', 'Tip Shiny'),
            'shirina_profilya' => Yii::t('tires', 'Shirina Profilya'),
            'vysota_profilya' => Yii::t('tires', 'Vysota Profilya'),
            'diametr_kolesa' => Yii::t('tires', 'Diametr Kolesa'),
            'indeks_nagruzki' => Yii::t('tires', 'Indeks Nagruzki'),
            'indeks_skorosti' => Yii::t('tires', 'Indeks Skorosti'),
            'uslilennaya_shina' => Yii::t('tires', 'Uslilennaya Shina'),
            'ship_neship' => Yii::t('tires', 'Ship/neship'),
            'data_obnovleniya_sklada' => Yii::t('tires', 'Data Obnovleniya Sklada'),
            'ostatok' => Yii::t('tires', 'Ostatok'),
            'optovaya_iskhodnaya_cena' => Yii::t('tires', 'Optovaya Iskhodnaya Cena'),
            'roznichnaya_iskhodnaya_cena' => Yii::t('tires', 'Roznichnaya Iskhodnaya Cena'),
            'vykhodnaya_optovaya_cena' => Yii::t('tires', 'Vykhodnaya Optovaya Cena'),
            'vykhodnaya_roznichnaya_cena' => Yii::t('tires', 'Vykhodnaya Roznichnaya Cena'),
            'skidka' => Yii::t('tires', 'Skidka'),
            'postavshhik' => Yii::t('tires', 'Postavshhik'),
            'gorod' => Yii::t('tires', 'Gorod'),
            'fajjl_izobrazhenie' => Yii::t('tires', 'Fajjl Izobrazhenie'),
            'status' => Yii::t('tires', 'Status'),
            'created_at' => Yii::t('tires', 'Created At'),
            'updated_at' => Yii::t('tires', 'Updated At'),
            'created_by' => Yii::t('tires', 'Created By'),
            'LastUpdatedBy' => Yii::t('tires', 'Last Updated By'),
        ];
    }
    
    public function getTire(){
    	return $this->hasOne(\common\models\tires\Tire::className(),  ['id'  =>  'tire_id']);
    }
    
}/**/
