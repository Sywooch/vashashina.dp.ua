<?php namespace frontend\widgets\yashare;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;




class YaShare extends Widget
{
    public $title;
    public $url;
    public $image;
    public $desc;
    public $view = 'index';
   // public $minPrice;
   //  public $maxPrice;

    public function init()
    {
      
        parent::init();
        
    }

    public function run()
    {
        $data = [];
      //  $data['items'] = count($this->cart);
       
        return $this->render($this->view,$data);
    }/**/
    
  
    
}/* end of Widget*/
