<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\events;
use Yii;
use yii\base\Event;
/**
 * Description of UpdatePriceEvent
 *
 * @author akulyk
 */
class UpdatePriceEvent extends Event {
    //put your code here
    public $supplier;
    public $price;
    public $message;
    public $status;
    protected $user;
    
    public function init() {
        
    
        $this->setUser();
        
       return parent::init();
    }/**/

        public function afterUpdateSupplierPrice(){
        $message = $this->prepareMessage();
        $subject = 'Обновление прайса поставщика в интернет-магазине VashaShina.dp.ua';
       
        $this->sendMessage($subject, $message);
    }/**/
    
    public function afterUpdatePrice(){
        $message = $this->prepareMessage();
        $message .= "Обновлен прайс: ".$this->price.PHP_EOL;   

        $subject = 'Обновление прайса в интернет-магазине VashaShina.dp.ua';
      
        $this->sendMessage($subject, $message);
    }/**/
    
    protected function prepareMessage(){
        $this->setSupplier();
        $message = '';
        $message .= "Менеджер: ".$this->user->name." (email: ".$this->user->email.")".PHP_EOL;
        $message .= "Поставщик: ".$this->supplier.PHP_EOL;
        $message .= "Статус: ".$this->status.PHP_EOL;
        $message .= "Сообщение: ".$this->message.PHP_EOL;
        $message = nl2br($message);
        return $message;
    }/**/
    
    protected function sendMessage($subject,$message){
         Yii::$app->mailer->compose()
  	->setFrom('daemon@vashashina.dp.ua')
  	->setTo('areinion@gmail.com')
  	->setSubject($subject)
        ->setHtmlBody($message)
  	->send();
    }/**/
    
    protected function setSupplier(){
   //     var_dump($this->supplier,strpos($this->supplier, '\\'));die;
        if (strpos($this->supplier, '\\')!== false){
            $tmp = explode('\\', $this->supplier);
            $this->supplier = $tmp[count($tmp)-1];
        }
    }/**/
    
    protected function setUser(){
        $this->user = \common\models\User::findOne(Yii::$app->user->id);
        
        
        
    }/**/
    
    
}/* end of Event */
