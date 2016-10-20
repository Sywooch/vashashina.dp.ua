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
      if (!strpos($this->url, 'http')){
          $this->url = Yii::$app->request->hostinfo.$this->url;
      }
      if ($this->image && !strpos($this->image, 'http')){
          $this->image = Yii::$app->request->hostinfo.$this->image;
      }
      
	  $this->prepareDesc();
	  
        parent::init();
        
    }

    public function run()
    {
        $data = [];
      //  $data['items'] = count($this->cart);
       
        return $this->render($this->view,$data);
    }/**/
    
	private function prepareDesc(){
		$this->desc = substr($this->desc, 0, strrpos(substr($this->desc, 0, 150), ' '));
		$this->desc = strip_tags($this->desc);
	}/**/
  
    
}/* end of Widget*/
