<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;
use yii\bootstrap\Tabs;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;

//$this->title = Yii::t('app', 'Order Confirm');

?>
<div class="main" id="korzina">
      <div class=" cart">
           <?php   $form = ActiveForm::begin(['action'=>['/order/new']]); ?>
          <div class="row">
              <div class="col-sm-12">
          <h3 class="text-center"><?=Yii::t('app', 'shopping cart');?></h3>
         
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>'{items}',
      //  'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'image', 'value'=>  function($cart){
        return Html::img($cart['image'],
    ['title'=>$cart['name'],'alt'=>$cart['name'],
        'width'=>'50px','height'=>'50px'
            ]);
            },'format'=>'raw', 'contentOptions'=>['class'=>'text-center']],
            ['attribute'=> 'name','label'=>mb_convert_case(Yii::t('app','title'), MB_CASE_TITLE, "UTF-8")],
             ['attribute'=> 'price','label'=>mb_convert_case(Yii::t('app','price'), MB_CASE_TITLE, "UTF-8")],
             ['attribute'=> 'qty','label'=>mb_convert_case(Yii::t('app','quantity'), MB_CASE_TITLE, "UTF-8"),
                 'value'=>  function($cart){
                          return Html::input('number', 'qty',$cart['qty'],
    ['class'=>'cartQty text-center','id'=>'qty_'.$cart['category_id'].'_'.$cart['id']] );},
                'format'=>'raw',
                 'contentOptions'=>['class'=>'text-center']],
             ['attribute'=> 'subtotal',
                 'label'=>mb_convert_case(Yii::t('app','subtotal'), MB_CASE_TITLE, "UTF-8"),
                'contentOptions'=>['class'=>'subtotal'] ],
            ['label'=>mb_convert_case(Yii::t('app','action'), MB_CASE_TITLE, "UTF-8"),'value'=>function($cart){
       return Html::a(Yii::t('app','delete'), ['/cart/delete'],
    ['class'=>'btn btn-xs btn-danger delete','id'=>'delete_'.$cart['category_id'].'_'.$cart['id']]);
            
            }, 'format'=>'raw']
        ]
        ]); ?>
          <div class="totalCart" >
               <?=Yii::t('app', 'total');?>:
        <span id="total"><?php echo $total; ?></span></div>
           </div>
        </div>
          <div class="row">
              <div class="col-sm-6 col-xs-12 mini-cart-btn">
                   <div class="cTButton">
                  <?php echo Button::widget(['label'=>Yii::t('app', 'continue').' '.Yii::t('app', 'shopping'),
                      'options'=>['class'=>'btn btn-lg btn-default','id'=>'close_cart']]);?>
                  </div>
              </div>
              <div class="col-sm-6 col-xs-12 mini-cart-btn">
                  <div class="cTButton pull-right">
                        <?php echo Button::widget(['label'=>yii::t('app', 'checkout'),
                      'options'=>['class'=>'btn btn-lg btn-muted','id'=>'make_order']]);?>
                
                  </div>
              </div>
          </div>
          <?php ActiveForm::end();?>
      </div>
    </div>
<script type="text/javascript" language="javascript">
  $(document).ready(function(){
$('#make_order').on('click',function(){
    $('#cart_form').submit();
});
$('#close_cart').on('click',function(e){
    e.preventDefault();
    showCartStatus();
     $.fancybox.close();
})
$('#continue_shopping').on('click',function(){
	showCartStatus();
    $.fancybox.close();
  
});
$("#korzina :input").on("change blur",function(){
    tr = $(this).parents('tr');
    if (tr){
    var quantity = this.value;
    var id = jQuery(this).attr('id').split("_");
     var category_id = id[1];
     var item_id = id[2];
   

 $.ajax({
   type: "POST",
   url:  " <?=Url::to(['/cart/update']);?>",
   data: {"qty":quantity,
         "item_id":item_id,
         "category_id":category_id
          },
   success: processJson,
        dataType: 'json'
  
});
   if(quantity == 0)tr.remove(); 
   }
});

function processJson(data) {

tr.find('td.subtotal').text(data.subtotal);
$('div.cart').find('#total').text(data.total);

	
showHideContinueButton();

}    

$("a.delete").click(function(){
if (window.confirm('Вы уверены, что хотите удалить этот товар из корзины?')){
     var id = jQuery(this).attr('id').split("_");
     var category_id = id[1];
     var item_id = id[2];


 $.ajax({
   type: "POST",
   url: "<?=Url::to(['/cart/remove']);?>",
   data: {"item_id":item_id,
          "category_id":category_id
         },
   success: processJsonDel,
        dataType: 'json'
  
});
var tr = $(this).parents('tr');
tr.remove();
}
return false;      
});

function processJsonDel(data) {
$('div.cart').find('#total').text(data.total);
//$('div#korzina').empty();

//var total =  $('span#cart').html();
//$('span#cart').html(total-1);
}  

function showHideContinueButton(){
	  var cartCount = countCartItems();
	    if (cartCount>0){
	    	
	    	$('#make_order').show();
	    	$('div.cartText').html('В корзине <span id="cartCount">'+cartCount+'</span> товаров<br />'
	    	+'на сумму <span id="cartTotal">'+ total  +'</span> грн.');
	    	        }else {
	       	$('#make_order').hide();
	       	$('div.cartText').html('Ваша корзина пуста');
	    	        }
     //   console.log(cartCount);
	    
}/**/

function countCartItems(){
var cartCount = 0;
	
	    jQuery('input.cartQty').each(function(){
	 //   	 console.log(jQuery(this));
	        cartCount += parseInt(jQuery(this).val());
	    })
            return cartCount;
}

function showCartStatus(){
	  var total = $('div.totalCart > #total').text();
          var count = countCartItems();
          $('div.show-cart > span.price').text(total);
          $('div.show-cart > span.count').text(count);
         $.ajax({
   type: "POST",
   url: "<?=Url::to(['/cart/show']);?>",
 
   success: function(data){
       $('#popCartItems').replaceWith(data);
   
   },
        dataType: 'html' 
});
     
}/**/

$("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });
  });
</script>