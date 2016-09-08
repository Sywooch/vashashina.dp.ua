<?php
namespace backend\behaviors\metaData;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use backend\models\MetaData_Template;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetaData
 *
 * @author AKulyk
 */
class MetaDataBehavior extends Behavior {
    //описание замен
     public $replaceDescription = ['%НАЗВАНИЕ%','%ПРОИЗВОДИТЕЛЬ%','%КАТЕГОРИЯ%'];
    
   //автоматическая генерация тега <TITLE>
      public $autoPageTitle;
      // шаблон для генерации автоматической генерации тега <TITLE>
      public $pageTitleTemplate;
      // 
      public $randomPTT;
      
      public $randomPTTData;
      
            //автоматическая генерация тега <meta_d>
      public $autoMeta_d;
      // шаблон для генерации автоматической генерации тега <meta_d>
      public $meta_dTemplate;
      //
      public $randomMDT;
      
      public $randomMDTData;
      
            //автоматическая генерация тега <meta_k>
      public $autoMeta_k;
      // шаблон для генерации автоматической генерации тега <meta_k>
      public $meta_kTemplate;
      //
      public $randomMKT; 
      
      public $randomMKTData;
      //какие значения меняем
      public $from = ['/(%НАЗВАНИЕ%|%НАЗВАНИЕ ТОВАРА%)/iu','/%ПРОИЗВОДИТЕЛЬ%/iu','/%КАТЕГОРИЯ%/iu'];
      // на какие значения меняем
      public $to = [];//$this->owner->title,$this->owner->brand->title,$this->owner->category->title
      
          
public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'generate'
        ];
    }	
      
      public function generate(){
     // 	var_dump($this->owner->randomMKTData);die;
      //	var_dump($this->owner);die;
           // формирование тега <TITLE>
        if ($this->owner->autoPageTitle){
        	// если активирован переключатель "случайный порядок"
        	if ($this->owner->randomPTT){
        		// подсчитываем количество подстановок
        		if ($this->owner->randomPTTData){
        			$randomArray = explode(';',$this->owner->randomPTTData);
                                foreach($randomArray as $key => $value){
                                    $randomArray[$key] = trim ($value);
                                    if (! $randomArray[$key]) unset( $randomArray[$key]);
                                }
                      $count = count($randomArray);
                      $id = rand(0,$count-1);
                      $text =  $randomArray[$id];
        		
        		
        
        		$string = $this->getReplaces($text);
        		$this->owner->pageTitle =$string;
        	//var_dump($this->owner->pageTitle);die;
        		}
        	}else{
            $string = $this->getReplaces($this->owner->pageTitleTemplate);
           $this->owner->pageTitle =$string;
        	}
        }//end if auto page title
        
          // формирование тега <meta_d>
        if ($this->owner->autoMeta_d){
        	// если активирован переключатель "случайный порядок"
        	if ($this->owner->randomMDT){
        	
        		// подсчитываем количество подстановок
        		if ($this->owner->randomMDTData){
        			$randomArray = explode(';',$this->owner->randomMDTData);
                                foreach($randomArray as $key => $value){
                                    $randomArray[$key] = trim ($value);
                                    if (! $randomArray[$key]) unset( $randomArray[$key]);
                                }
                      $count = count($randomArray);
                      $id = rand(0,$count-1);
                      $text =  $randomArray[$id];
        		
        		
        	
        		$string = $this->getReplaces($text);
        		$this->owner->meta_d =$string;
        		}
        	}else{
            $string = $this->getReplaces($this->owner->meta_dTemplate);
           $this->owner->meta_d =$string;        	
        }// end if ramdom Meta_d
        }// end meta_d
        
            // формирование тега <meta_k>
        if ($this->owner->autoMeta_k){
        // если активирован переключатель "случайный порядок"
        	if ($this->owner->randomMKT){
        	
        		// подсчитываем количество подстановок
        		if ($this->owner->randomMKTData){
        			$randomArray = explode(';',$this->owner->randomMKTData);
                                foreach($randomArray as $key => $value){
                                    $randomArray[$key] = trim ($value);
                                    if (! $randomArray[$key]) unset( $randomArray[$key]);
                                }
                      $count = count($randomArray);
                      $id = rand(0,$count-1);
                      $text =  $randomArray[$id];
        		
        		$string = $this->getReplaces($text);
        		$this->owner->meta_k =$string;
        	//	var_dump($string);die;
        		}
        	}else{
            $string = $this->getReplaces($this->owner->meta_dTemplate);
           $this->owner->meta_k =$string;        	
        }// end if ramdom Meta_d
      }// end if auto meta_k
      
    
      }/**/
      
          /**
     * автозамена для генерации мета тегов
     * 
     **/
    public function getReplaces($template){
      return preg_replace($this->from,$this->getTo(),$template);
    }/**/
    
    public function getTo(){
    	return [$this->owner->title,mb_convert_case($this->owner->brand->title,MB_CASE_TITLE,'UTF-8'),$this->owner->category->title];
    }
      
}/*end of class*/
