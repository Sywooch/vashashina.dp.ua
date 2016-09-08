<?php  
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;
use yii\bootstrap\Tabs;
use yii\bootstrap\Nav;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('app', 'Order Confirm');

?>
  <?php $form = ActiveForm::begin(['action'=>['/order/done'],'options'=>['id'=>'confirmOrderForm']]);?>
   <div class="main">
      <div class="container basket">
         <?php echo Breadcrumbs::widget([
    'itemTemplate' => "<li class=\"path\">{link}</li>\n", // template for all links
    'homeLink'=>['label'=>  Yii::t('app', 'Home'),
        'template'=>"<li class=\"this-page\">Вы находитесь здесь: {link}</li>\n",
        'url'=>  yii\helpers\Url::home()],
        'links' => [
        [
            'label' => 'Заказ',
           // 'url' => ['shiny/find'],
            'template' => "<li><span class=\"path\">{link}</span></li>\n", // template for this link only
        ],
        
        [
            'label' => 'Подтверждение',
       //     'url' => ['shiny/find','Tire[manufacturer_id]'=>$model->brand->id],
            'template' => "<li><span class=\"path\">{link}</span></li>\n", // template for this link only
        ],    
         
    ],
]);?>
        <div class="row">
          <div class="col-lg-12"><h1>Оформление заказа</h1></div>
          
          <div class="col-sm-12">
              <?php echo Nav::widget([
    'options'=>['class'=>'menu-option',],
    'items' => [
     
        ['label' => Yii::t('app','your').' '.Yii::t('app','purchases'), 'options' => ['class'=>'items active']],
        ['label' => Yii::t('app','delivery'), 'options' => ['class'=>'delivery']],
        ['label' => Yii::t('app','payment'), 'options' =>['class'=>'payment'] ],
        ['label' => Yii::t('app','confirmation'), 'options' =>['class'=>'confirm'] ],
       
    //    ['label' => 'Акции', 'url' => ['/site/news']],
        
    ],
]);?> 
<div class="items orderTabs">
    <?php echo $this->render('_items',['dataProvider'=>$dataProvider,'total'=>$total]);?>
</div>
<div class="delivery orderTabs">
    <?php echo $this->render('_delivery',['model'=>$model,'form'=>$form]);?>
</div>
<div class="payment orderTabs">
    <?php echo $this->render('_payment',['model'=>$model,'form'=>$form]);?>
</div>
<div class="confirm orderTabs">
    <?php echo $this->render('_confirm',['model'=>$userModel,'form'=>$form,'total'=>$total]);?>
</div>
     <?php echo Button::widget(['label'=>Yii::t('app', 'prev'),
                  'options'=>['class'=> 'send-calc margin-20 float-left prev']]);?>  
               <?php echo Button::widget(['label'=>Yii::t('app', 'next'),
                  'options'=>['class'=> 'send-calc margin-20 float-right next']]);?>          
    
    <?php echo Button::widget(['label'=>'ПОДТВЕРДИТЬ ЗАКАЗ',
                  'options'=>['class'=> 'send-calc margin-20 float-right confirm','type'=>'submit']]);?>
    <div class="totalCart totalOrder margin-20" >
        <span class="totalText"><?=Yii::t('app', 'total to pay');?>:</span>  
        <span id="total"><?php echo $total; ?></span>
    </div>          
    <?php //$form->field($model,'suma')->hiddenInput(['value'=>$total]);?>
                
          </div>
  
        </div>
      </div>
    </div>
 <?php ActiveForm::end();?>
<script type="text/javascript" language="javascript">

    $('button.confirm').on('click',function(e){
     e.preventDefault();
     var form = $(this).parents('form#confirmOrderForm');
     var data = form.serialize();
 //    console.log(data);
     form.submit();
     
 });
    
$('ul.menu-option > li > a').on('click',function(e){
    e.preventDefault();
});
$('button.next').on('click',function(e){
    e.preventDefault();
   getNextTab();
  
});
function getNextTab(){
    var li_a = $('ul.menu-option > li.active');
   
    if(getCurrentClass(li_a) == 'delivery'){
 var delivery = checkDelivery();
  if (!delivery){return false;}
    }
    
   if(getCurrentClass(li_a) == 'payment'){
  var payment = checkPayment();
  if (!payment){return false;}
    }
    
    var li_next = li_a.next();
    var tab = li_next.attr('class');
    li_a.removeClass('active');
    li_next.addClass('active');
    $('div.orderTabs').hide();
     $('div.totalOrder').hide();
      $('div.orderTabs.'+tab).show();
      if (tab == 'confirm'){
        $('button.next').hide(); 
         $('button.confirm').show();
      }
         $('button.prev').show();
     
}/**/

$('button.prev').on('click',function(e){
    e.preventDefault();
   getPrevTab();
  
});
function getPrevTab(){
    var li_a = $('ul.menu-option > li.active');
    var li_prev = li_a.prev();
    var tab = li_prev.attr('class');
    li_a.removeClass('active');
    li_prev.addClass('active');
    $('div.orderTabs').hide();
      $('div.orderTabs.'+tab).show();
           if (tab == 'items'){
        $('button.prev').hide();
        $('div.totalOrder').show();
      }
      $('button.next').show(); 
          $('button.confirm').hide();
}
function checkDelivery(){
  var selected = $('#order-sposob_dostavki').find(':radio:checked').val();
 
  if (!selected){
      alert('Вам необходимо выбрать способ доставки!');
      return false;
  }else {
      return true;
  }
}/**/

function checkPayment(){
  var radio = $('#order-sposob_oplati').find(':radio:checked');
  var selected = radio.val();
  
  //console.log(label.text());
  
 
  if (!selected){
      alert('Вам необходимо выбрать способ оплаты!');
      return false;
  }else {
      var label = radio.parent('label');
  $('#paymentLabel').text(label.text());
      return true;
  }
}/**/

function getCurrentClass(className){
    var data = className.attr('class').split(' ');
    var myClass = data[0];
    return myClass;
}/**/
</script>