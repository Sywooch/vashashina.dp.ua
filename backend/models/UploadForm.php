<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\models;

/**
 * Description of UploadForm
 *
 * @author AKulyk
 */
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    public $supplier;
     public $type; 
    
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['supplier','type'],'required'],
            [['file'],'file','maxFiles' => 10],
          //  ['file', 'files',['extensions' => ['csv', 'xml', 'xls']]],
        ];
    }/**/
    
    public function attributeLabels(){
    	return [
    			'supplier'=>Yii::t('app','Supplier')
    			
    	];
    }/**/
    
    public function files($attribute,$params)
{
        var_dump($params);die;
    $validator= yii\validators\Validator::createValidator('file', $this, $attribute, $params);
    foreach(UploadedFile::getInstances($this,$attribute) as $file)
    {
        $this->$attribute= $file;
        $validator->validate($this, $attribute);
    }
}
}/*end of Model*/
