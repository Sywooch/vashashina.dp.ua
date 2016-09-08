<?php
/* @var $this View */
//use Yii;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][]= 'Заказ';
$this->params['breadcrumbs'][]= 'Шаг 2. Заказ оформлен';       


 ?>
<div class="container">  
<div id="model">
     <h5 class="menu_title" style="margin-top: 10px;">Заказ оформлен</h5>
     <div class="news">
     <?php if ($order):?>
          <?php echo $this->render('@frontend/views/mail/newOrderMail',['order'=>$order])?>
     <?php else:?>
     <p> Вы нечего не закзали </p>
     <?php endif;?>
 </div>  
</div>
</div>
