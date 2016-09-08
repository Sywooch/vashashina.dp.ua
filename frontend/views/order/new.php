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
$this->params['breadcrumbs'][]= 'Шаг 1. Оформление';       


 $this->registerJs('jQuery(".minus").click(function(){' 
         . 'var qty = jQuery(this).next("input").val();'
         . 'jQuery(this).next("input").val(qty-1);});'
         . 'jQuery(".plus").click(function(){'
         . 'var qty = jQuery(this).prev("input").val();'
         . '++qty;'
         . 'jQuery(this).prev("input").val(qty);});',  \yii\web\View::POS_READY,'changeQty');

 ?>
    
<div id="model">
     <h5 class="menu_title" style="margin-top: 10px;">Оформление заказа</h5>
     <div class="news">
             <div id="breadcrumbs" style="margin-left: 50px; background-color: white;">
    <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
</div>
    <?php if (count($this->context->items)>0):?>
        <div class="form">
        <?php $form=ActiveForm::begin(['action'=>['/order/done']]) ?>
    <table class="table table-striped vmiddle">
        <thead style="background-color: #D7D7D7;">
            <tr>
        <th>Товар</th>
         <th>Цена</th>
          <th>Количество</th>
           <th>Сумма</th>
            </tr>
    </thead>
        <tbody>

    <?php $total = $this->context->items['total'];unset($this->context->items['total']);
                foreach ($this->context->items as $cat_id => $items):?>
   <?php          foreach ($items as $id => $item):?>
            <tr class="line_bottom">
                <td><?=Html::img($item['image'],['title'=>$item['name'],'alt'=>$item['name'],'width'=>42,'height'=>42]);?> 
            <?php echo $item['name']; ?>
			<?php if ($item['gift']):?>
			<p>К данному Товару Вы получаете подарок:<br/>
			<?php $gift = Product::model()->findByPk($item['gift'],array('select'=>'id,title,url,manufacturer_id'));?>
			<image src="<?php echo $gift->imageUrl; ?>" style="width:62px;height:auto;"/>
			<?php echo $gift->title;?>
			</p>
			<?php endif; ?>
                </td>
                <td class="vmiddle"><?=$item['price']; ?> грн.</td>
                <td align="center" class="vmiddle">
                <div class="input-group input-group-sm col-sm-6">
  <span class="input-group-addon minus" id="sizing-addon1">-</span>
  <input type="text" class="form-control qty_input" value="<?= $item['qty'];?>" 
  name="qty[<?=$cat_id?>][<?=$id?>]" aria-describedby="sizing-addon1">
  <span class="input-group-addon plus" id="sizing-addon2">+</span>
</div>
          
                   </td>
                <td class="vmiddle"><?=$item['subtotal']; ?> грн.</td>
            </tr>
<?php endforeach;?>
<?php endforeach;?>
            <tr><td colspan="4" style="text-align:right"><strong>ВСЕГО: <?=$total; ?> грн.</strong></td></tr>
        </tbody>
        
    </table>
    <?php if (Yii::$app->user->isGuest):?>
    <div class="col-md-4">
     <?= $form->field($userModel, 'name')->textInput(['maxlength' => 255]) ?>
   <?= $form->field($userModel, 'email')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($userModel, 'phone')->textInput(['maxlength' => 15]) ?>
 </div>
 <?php endif;?>
 <div class="col-md-4">
      <?= $form->field($model, 'sposob_oplati')->dropDownList(
    		ArrayHelper::map(\common\models\SposobOplati::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control','prompt'=>'Выберите']) ?> 
    	    <?= $form->field($model, 'sposob_dostavki')->dropDownList(
    		ArrayHelper::map(\common\models\SposobDostavki::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control','prompt'=>'Выберите']) ?> 
 </div>
 <?php Html::Label('memo'); ?>
 <div class="col-md-7">
  <?= $form->field($model, 'memo')->textarea(['rows' => 3]) ?> 
  </div>
 <div class="clear"></div>
 <div style="text-align:center"> 
   <?php echo Button::widget([
    'label'=>'Оформить заказ',
   
   // 'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
   // 'size'=>'large',// null, 'large', 'small' or 'mini'
    'options'=>['id'=>'orderSubmit','class'=>'btn btn-primary','type'=>'submit']
]); ?>
   </div>  
   <?php ActiveForm::end();?>
     
    </div>
 <?php else:?>
 <p>Вы ничего не заказали</p>
 <?php endif;   ?>
 </div>  
</div>
