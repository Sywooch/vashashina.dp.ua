<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Order;
use common\models\ProductsPerOrder;
use common\models\User;
use frontend\widgets\price\Price;

/**
 * Description of OrderController
 *
 * @author AKulyk
 */
class OrderController extends Controller  {
    
    public $layout = 'default';
    public $order;
    public $items;
    
 public function actionNew(){
     $this->items = Yii::$app->session['cart'];
     $this->order = $model = new Order;
    
     if (Yii::$app->user->isGuest){
          $userModel = new User;
     $userModel->scenario = 'newOrder';
     }else{
         $userModel = User::findOne(Yii::$app->user->id);
     }
      $total = Price::widget(['amount'=>$this->items['total']]);
          unset($this->items['total']);
             $items = [];
             foreach ($this->items as $cat_id => $cat){
             foreach ($cat as $id => $item){
                 $item['id']=$id;
                 $item['category_id']=$cat_id;
                 $item['price'] = Price::widget(['amount'=>$item['price']]);
                 $item['subtotal'] = Price::widget(['amount'=>$item['subtotal']]);
                 $items[] = $item;
             }    
             }
             $dataProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $items,

]);
  
    return $this->render('view',['userModel'=>$userModel,
        'model'=>$model,'dataProvider'=>$dataProvider,'total'=>$total]);
 }/**/
 
 public function actionDone(){
 	$cart = Yii::$app->session['cart'];
 	if (isset($cart['total']) && count($cart)>0){
 
 	  if (!Yii::$app->user->isGuest){
 	  	$user_id = Yii::$app->user->id;
 	  }else{
 	  	$user = new User;
 	  	$user->load(Yii::$app->request->post());
 	  	if ($userModel = User::find()->where('email = :email',[':email'=>$user->email])->one()){
 	  		$userModel->load(Yii::$app->request->post());
 	  		$userModel->save();
 	  			$user_id = $userModel->id;
 	  		}else{
 	  			$user->save();
 	  			$user_id = $user->id;
 	  		}
 	  }
 	  $order = Order::find()->where('customer_id = :customer_id AND payment_status = "pending"',
 	  		[':customer_id'=>$user_id])->one();
 	  if (!$order){
 	  	$order = new Order;
 	  
 	  }
 	  $order->load(Yii::$app->request->post());
        //  $order->suma = $cart['total'];
 	  $order->customer_id = $user_id;
 	
 	//  var_dump($order);die;
 	//  $qties = Yii::$app->request->post('qty');
 	//  $cart['total'] = 0;
 	/*
 	  foreach ($qties as $cat_id =>$qty){
 	  	foreach ($qty as $id => $q){
 	  		$cart[$cat_id][$id]['qty'] = $q;
 	  		$cart[$cat_id][$id]['subtotal'] = $cart[$cat_id][$id]['price'] * $cart[$cat_id][$id]['qty'];
 	  		$cart['total'] += $cart[$cat_id][$id]['subtotal'];
 	  	}
 	  }
 	*/
      
 	  $order->suma += $cart['total'];
         
    //       var_dump($cart);die;
 	  unset($cart['total']);
 	
 	  if($order->save()){
 	  	foreach($cart as $cat_id =>$items){
 	  //		var_dump($cart);
 	  		foreach ($items as $id => $item){
 	  			
 	  	$productPO = ProductsPerOrder::find()->where('product_id = :product_id AND category_id = :cat_id AND order_id = :order_id',
 	  			[':product_id'=>$id,':cat_id'=>$cat_id,':order_id'=>$order->id])->one();
 	  	if (!$productPO) {
 	  	$productPO = new ProductsPerOrder;
 	  	$productPO->product_id = $id;
 	  	$productPO->category_id = $cat_id;
 	  	$productPO->order_id = $order->id;
 	  
 	  	}
 	  //die;
 	  	
 	 	$productPO->subtotal = $item['subtotal'];
 	 	$productPO->quantity = $item['qty'];
 	  	$productPO->price = $item['price'];
 	  	$productPO->gift_id = $item['gift'];
 	  
 	  	$productPO->save();
 	 
 	  		}// end  $items
 	  		}//end $cart
 	  	}
 	  	
 	  
 	  	$this->sendMailCustomer($order);
 	  	$this->sendMailStaff($order);
 	  	Yii::$app->session->setFlash('success','Ваш заказ успешно оформлен');
 	  	unset (Yii::$app->session['cart']);
                  return $this->render('done',['order'=>$order]);
        }else{
            $this->redirect(['/']);
        }
 	
 	
 }/**/
 
  private function sendMailCustomer($order){
  	Yii::$app->mailer->compose('@frontend/views/mail/newOrderMail', ['order'=>$order])
  	->setFrom(Yii::$app->params['orderEmail'])
  	->setTo($order->user->email)
  	->setSubject('Новый заказ в интернет-магазине VashaShina.dp.ua')
  	->send();
  }/**/
  
  private function sendMailStaff($order){
  	Yii::$app->mailer->compose('@frontend/views/mail/newOrderStaff', ['order'=>$order])
  	->setFrom(Yii::$app->params['orderEmail'])
  	->setTo(Yii::$app->params['orderEmail'])
        ->setCc('areinion@gmail.com')
  	->setSubject('Новый заказ в интернет-магазине VashaShina.dp.ua')
  	->send();
  }/**/

 	  
    
    //put your code here
}/*end of Class*/
