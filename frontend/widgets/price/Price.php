<?php namespace frontend\widgets\price;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use NumberFormatter;
use common\models\Settings;



class Price extends Widget
{
    public $amount;
    public $currency = 'UAH';
    public $currencySymbol;
    public $useCurrencySymbol = FALSE;
    public $currencies = ['UAH'=>['position'=>'after']];
    public $view = 'index';
    public $site = 'vashashina.dp.ua';
    public $result;

   // public $minPrice;
   //  public $maxPrice;

    public function init()
    {
           
    
     
        parent::init();
        
    }/**/

    public function run()
    {
        
           if ($this->useCurrencySymbol){
      
           $this->result = Yii::$app->formatter->asCurrency($this->amount, $this->currency);
       } 
       elseif ($this->currencies[$this->currency]['position'] == 'after'){
         $this->result = Yii::$app->formatter->asDecimal($this->amount,0);
          $this->result = $this->result.' '.Yii::t('app',$this->currency); 
          
       } elseif ($this->currencies[$this->currency]['position'] == 'after'){
            $this->result = Yii::$app->formatter->asDecimal($this->amount, 0,
                 ['thousandSeparator'=>' ']);
            $this->result == Yii::t('app',$this->currency).' '. $this->result;  
       }
        
     return $this->result;
    }/**/
    
   
    
}/* end of Widget*/