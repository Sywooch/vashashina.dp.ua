<?php namespace frontend\widgets\topCart;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\widgets\price\Price;



class TopCart extends Widget
{
    public $cart;
    public $count;
    public $total;
    public $view = 'index';
   // public $minPrice;
   //  public $maxPrice;

    public function init()
    {
        if (!yii::$app->session->get('cart')) yii::$app->session->set('cart',[]);
        $this->cart = Yii::$app->session->get('cart');
        $this->count = $this->getTotalCount($this->cart);
        $this->total = $this->getTotal($this->cart);
        $this->total = Price::widget(['amount'=>$this->total]);
        if (isset($this->cart['total'])) unset($this->cart['total']);
        parent::init();
        
    }

    public function run()
    {
        $data = [];
      //  $data['items'] = count($this->cart);
       
        return $this->render($this->view,$data);
    }/**/
    
    private function getTotalCount($items = array()){
        $total = 0;
        if (isset($items['total']))unset ($items['total']);
        foreach ($items as $cat){
        foreach($cat as $item){
         $total += isset($item['qty'])?$item['qty']:0; 
            }
        }
        return $total;
    }/**/
    
    private function getTotal($items = array()){
        $total = 0;
        if (isset($items['total']))unset ($items['total']);
        foreach ($items as $cat){
        //	var_dump($cat);die;
            foreach($cat as $item){
         $total += isset($item['subtotal'])?$item['subtotal']:0; 
            }
        }
        return $total;
    }/**/
    
}/* end of Widget*/
