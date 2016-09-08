<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%podbor_shini_i_diski}}".
 *
 * @property integer $id
 * @property string $vendor
 * @property string $car
 * @property string $year
 * @property string $modification
 * @property string $pcd
 * @property string $diametr
 * @property string $gaika
 * @property string $zavod_shini
 * @property string $zamen_shini
 * @property string $tuning_shini
 * @property string $zavod_diskov
 * @property string $zamen_diskov
 * @property string $tuning_diski
 */
class PodborShiniDiski extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%podbor_shini_i_diski}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor', 'car', 'year', 'modification', 'pcd', 'diametr', 'gaika', 'zavod_shini', 'zamen_shini', 'tuning_shini', 'zavod_diskov', 'zamen_diskov', 'tuning_diski'], 'required'],
            [['vendor', 'car', 'year', 'modification', 'pcd', 'diametr', 'gaika', 'zavod_shini', 'zamen_shini', 'tuning_shini', 'zavod_diskov', 'zamen_diskov', 'tuning_diski'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vendor' => Yii::t('app', 'Vendor'),
            'car' => Yii::t('app', 'Car'),
            'year' => Yii::t('app', 'Year'),
            'modification' => Yii::t('app', 'Modification'),
            'pcd' => Yii::t('app', 'Pcd'),
            'diametr' => Yii::t('app', 'Diametr'),
            'gaika' => Yii::t('app', 'Gaika'),
            'zavod_shini' => Yii::t('app', 'Zavod Shini'),
            'zamen_shini' => Yii::t('app', 'Zamen Shini'),
            'tuning_shini' => Yii::t('app', 'Tuning Shini'),
            'zavod_diskov' => Yii::t('app', 'Zavod Diskov'),
            'zamen_diskov' => Yii::t('app', 'Zamen Diskov'),
            'tuning_diski' => Yii::t('app', 'Tuning Diski'),
        ];
    }/**/
    
   public static function getTireParam($param,$string){
   	$data = false;
   	$str = 0;
   	$string = trim($string);
   	$str = explode(' ',$string);
   
   	if (count($str) < 2) {
   	
   		return False;}
  
   	$str2 = explode('/',$str[0]);
   	
   	switch ($param){
   		case "width":
   			
   	$data = $str2[0];	
   			break;
   		
   		case "profile":
   			$data = $str2[1];
   				break;
   				
   		case "diameter":
   			$data = substr(trim($str[1]),1);
   					break;
   	}
   	return $data;
   } /**/
   
   public static function getDiskParam($param,$string){
   	$data = false;
   	$str = 0;
   	$string = trim($string);
   	$str = explode(' ',$string);
   	 
   	if (count($str) < 2) {
   
   		return False;}
   
   	
   
   		switch ($param){
   			case "width":
   			    $data = trim($str[0]);
   				
   				break;
   			
   			case "diameter":
   			    $data = trim($str[2]);
   					break;
   				 
   			case "et":
   				$data = substr(trim($str[3]),2);
   				break;
   					
   			
   		}
   		return $data;
   } /**/
   

    
    
}/*end of model*/
