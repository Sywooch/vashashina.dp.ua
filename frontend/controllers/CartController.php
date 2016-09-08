<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use frontend\widgets\price\Price;



/**
 * Site controller
 */
class CartController extends Controller
{
	public $layout = 'default';
        public $items = [];
    /**
     * @inheritdoc
     */


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionAdd($category_id,$id,$qty = 1)
    {
    	$data = [];  
    	if (!Yii::$app->session->get('cart')){
           
            Yii::$app->session->set('cart',[]);
        
        }
        $gift = FALSE;
        $quantity = $qty;
         $session = Yii::$app->session->get('cart');
         $title = '';
        // var_dump($session);die;
         switch ($category_id){
             case "1":
                 $product = \common\models\tires\Tire::findOne($id);
                 $title = 'Шины ';
            //     $product->title = 'Шины '.$product->title;
                 break;
             case "13":
                 $product = \common\models\disks\Disk::findOne($id);
                  $title = 'Диски ';
            //      $product->title = 'Диски '.$product->title;
                 break;
             default :
                 $product = \common\models\Product::find()
                     ->select('id,title,alias,category_id,quantity,price,
                     		discount,discount_begin,discount_end,image, thumbnail')
                     ->where('id = :id',[':id'=>$id])->one();
         }
         $price = $product->getPrice();
         $image = $product->thumbnailUrl;
         if (!$price) $price = 0;
         $session[$category_id][$id] = [
             'name' =>$title.$product->title,
                'price'=>$price,
                'image'=>$image,
                'subtotal'=> $price * $quantity,
            	'gift'=>(int)$gift,
                'qty' => $quantity,
                'options'=>[]
         ];
         $session['total'] = $this->getTotal($session);
         Yii::$app->session['cart'] = $session;
         $this->items = Yii::$app->session['cart'];
       //  var_dump($session);
       
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
             $data = ['dataProvider'=>$dataProvider,'total'=>$total];
               if (Yii::$app->request->isAjax){
         return $this->renderPartial('view',$data);
         } else{
             return $this->render('view',$data);
         }
    }/**/
    
    public function actionUpdate(){
                   $id = (int)Yii::$app->request->Post('item_id');
            $cat_id = (int)Yii::$app->request->Post('category_id');
            $qty = (int)Yii::$app->request->Post('qty');
             $session = Yii::$app->session['cart'];
             if ($qty == 0)unset($session[$cat_id][$id]);
             if (isset($session[$cat_id][$id])){
             $session[$cat_id][$id]['qty'] = $qty;
             $session[$cat_id][$id]['subtotal'] = $qty *  $session[$cat_id][$id]['price'];
             $data['subtotal'] = Price::widget(['amount'=>$session[$cat_id][$id]['subtotal']]);
             }
              $session['total'] = $this->getTotal($session);
              $this->items = Yii::$app->session['cart'] = $session;
              $data['total'] = Price::widget(['amount'=>$session['total']]);
              $data['count'] = $this->getTotalCount($session);
		return \yii\helpers\Json::encode($data);
    }/**/
    
    public function actionShow(){
        
        return \frontend\widgets\topCart\TopCart::widget(['view'=>'topCartItems']);
    
        
    }/**/
    
        public function actionRemove()
	{
            $id = (int)Yii::$app->request->Post('item_id');
            $cat_id = (int)Yii::$app->request->Post('category_id');
             $session = Yii::$app->session['cart'];
             if (isset($session[$cat_id][$id])){
                 unset($session[$cat_id][$id]);
             if (count ((array)$session[$cat_id])==0) unset($session[$cat_id]);
             }
              $session['total'] = $this->getTotal($session);
              $this->items = Yii::$app->session['cart'] = $session;
              $data['total'] = Price::widget(['amount'=>$session['total']]);
              $data['count'] = $this->getTotalCount($session);
		return \yii\helpers\Json::encode($data);
	}/**/
    
     private function getTotal($items = array()){
        $total = 0;
        if (isset($items['total']))unset ($items['total']);
          if (count($items)> 0){
        foreach ($items as $cat){
        //	var_dump($cat);die;
            foreach($cat as $item){
         $total += isset($item['subtotal'])?$item['subtotal']:0; 
            }
        }
          }
        return $total;
    }/**/
    
        private function getTotalCount($items = array()){
        $total = 0;
        if (isset($items['total']))unset ($items['total']);
        if (count($items)> 0){
        foreach ($items as $cat){
        foreach($cat as $item){
         $total += isset($item['qty'])?$item['qty']:0; 
            }
        }
        }
        return $total;
    }/**/

   
    
}/**/
