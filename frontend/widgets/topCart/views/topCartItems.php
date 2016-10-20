<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;
use frontend\widgets\price\Price;
?>
<div id="popCartItems" class="popover popover-default bottom bottom-left in">
            <div class="arrow"></div>
            <div class="popover-title">
              <button class="close close-cart">×</button>Товары в корзине
            </div>
            <div class="popover-content">
               <?php if (count($this->context->cart)> 0):?>
            
              <table class="table">
                <tbody>
                <?php if (count($this->context->cart) > 0):?>
                    <?php foreach ($this->context->cart as $kid => $cat):?>
                    <?php foreach ($cat as $id => $item):?>
                 <?php if (isset($item['name'])):?>
                  <tr class="cartRow">
                       
                    <td class="textCartTd">
                      <h5 class="cartItem"><?=$item['name'];?></h5>
                  <?php  ActiveForm::begin(['method'=>'post','action'=>'',
                          'options'=>['class'=>'cartRowForm']]);?>   
                      <p><?=Price::widget(['amount'=>$item['price']]);?> X 
                       <input type="text" name="qty" value="<?=$item['qty'];?>" class="cartTdInput"> шт = 
                       <span class="subTotalCart orange"><?=Price::widget(['amount'=>$item['subtotal']]);?></span>
                      <?=Html::hiddenInput('category_id', $kid);?>
                       <?=Html::hiddenInput('item_id', $id);?>
                      </p>
                        <?php  ActiveForm::end();?>
                    </td>
                    <td class="removeButtonCartTd">
                      <button aria-hidden="true" type="button" class="close">×</button>
                       
                    </td>
                   
                  </tr>
                   <?php endif;?>
                   <?php endforeach;?>
                  <?php endforeach;?>
                  <?php endif;?>
                </tbody>
              </table>
              <div class="cartTotal">
                <div class="cTText">
                  <p class="color-silver"><?=Yii::t('app','Total Sum');?>:<br>
                      <span id="totalSum" class="orange"><?=$this->context->total;?></span>
                          </p>
                </div>
                <div class="cTButton">
                 <?php echo Button::widget(['label'=>yii::t('app', 'checkout'),
                     'tagName'=>'a',
                      'options'=>['class'=>'btn btn-muted',
                          'href'=>yii\helpers\Url::to(['/order/new']) ]]);?>
                </div>
                 
              </div>
                <?php else:?>
                <p>Ваша корзина пуста!</p>
                 <?php endif;?>
            </div>
          </div>
<script type="text/javascript">
$('button.close').not(':first').on('click',function(){
    if (window.confirm('Удалить этот товар из корзины?')){
    action = 'remove';
    tr = $(this).parents('tr');
    var form = tr.find('form.cartRowForm');
    var data =  form.serialize();
    sendAjax(data,action,'json');
    }
});

$('input.cartTdInput').on('change',function(){
    action = 'update';
    tr = $(this).parents('tr');
    var form = tr.find('form.cartRowForm');
    var data =  form.serialize();
    sendAjax(data,action,'json');
    
});

function sendAjax(data,action,dataType){
     $.ajax({
   type: "POST",
   url: baseUrl+"/cart/"+action,
   data: data,
   success: processData,
        dataType: dataType
  
});
}
function processData(data){
   var sum = data.total;
   var count = data.count;
    sum = parseFloat(sum);
   $('#totalSum,div.money > span.price').text(data.total);
    $('div.money > span.count').text(count);
    if (action == 'remove'){
     if (sum > 0){
         tr.remove();
    
     }else if (sum === 0){
         var div = tr.parents('div.popover-content');
         div.empty();
         div.html('<p>Ваша корзина пуста!</p>');
     }
     } else if (action == 'update'){
  
     var span = tr.find('span.subTotalCart');
     span.text(data.subtotal);
    
     }
}
</script>