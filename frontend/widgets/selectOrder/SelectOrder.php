<?php namespace frontend\widgets\selectOrder;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;



class SelectOrder extends Widget
{
  public $order = ['title ASC'=>'По названию А-Я',
                'title DESC'=>'По названию Я-А',
                'price ASC'=>'От дешевых к дорогим',
                'price DESC'=>'От дорогих к дешевым',
                'created DESC'=>'По новизне'];
  public $tip;
  public $sort = 'price ASC';
 

    public function init()
    {
      
   $this->setSort();
  
        parent::init();
        
    }

    public function run()
    {
        $data = [];
       
      
        $data['select'] = Html::dropDownList($this->tip.'[sort]',$this->sort, $this->order,
                ['class'=>'dropdown','id'=>'sortSelect']);
      //  $data['items'] = count($this->cart);
       
        return $this->render('index',$data);
    }/**/
    
    private function setSort(){
    
         if ($this->tip == 'Tire' && isset(Yii::$app->session['Tire']['sort'])){
          $this->sort = Yii::$app->session['Tire']['sort'];
         
         
      }
      if ($this->tip == 'Disk' && isset(Yii::$app->session['Disk']['sort'])){
          $this->sort = Yii::$app->session['Disk']['sort'];
      }
     
    }/**/
    
 
    
}/* end of Widget*/
