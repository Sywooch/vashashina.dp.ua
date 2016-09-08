<?php namespace frontend\widgets\analytics;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Settings;



class Analytics extends Widget
{
    public $yandex_id = 10625119;
    public $google_id = 'UA-5395905-4';
    public $view;
    public $site = 'vashashina.dp.ua';

   // public $minPrice;
   //  public $maxPrice;

    public function init()
    {
        if ($this->view){
            switch($this->view){
                case "google":
          $google = Settings::findOne(['name'=>'google_id']);
                    if (isset($google->value) && $google->value){
             $this->google_id =  $google->value;          
                    }
                    break;
                    
                     case "yandex":
          $yandex = Settings::findOne(['name'=>'yandex_id']);
                    if (isset($yandex->value) && $yandex->value){
             $this->yandex_id =  $yandex->value;          
                    }
                    break;
            }
        }
     
        parent::init();
        
    }

    public function run()
    {
        $data = [];
      //  $data['items'] = count($this->cart);
       
        return $this->render($this->view,$data);
    }/**/
    
   
    
}/* end of Widget*/