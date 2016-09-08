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
$this->registerJs('$(".qty:input").on("change blur",function(){
    tr = $(this).parents("tr");
    if (tr){
    var quantity = this.value;
    var id = jQuery(this).attr("id").split("_");
     var category_id = id[1];
     var item_id = id[2];
   

 $.ajax({
   type: "POST",
   url:  "'.Url::to(["/cart/update"]).'",
   data: {"qty":quantity,
         "item_id":item_id,
         "category_id":category_id
          },
   success: processJson,
        dataType: "json"
  
});
   if(quantity == 0)tr.remove(); 
   }
});

function processJson(data) {

tr.find("td.subtotal").text("=  " + data.subtotal);
setTotal(data.total,data.count);

}    

$("button.cancel").click(function(){
if (window.confirm("Вы уверены, что хотите удалить этот товар из корзины?")){
     var id = jQuery(this).attr("id").split("_");
     var category_id = id[1];
     var item_id = id[2];


 $.ajax({
   type: "POST",
   url: "'.Url::to(["/cart/remove"]).'",
   data: {"item_id":item_id,
          "category_id":category_id
         },
   success: processJsonDel,
        dataType: "json"
  
});
var tr = $(this).parents("tr");
tr.remove();
}
return false;      
});

function processJsonDel(data) {
setTotal(data.total,data.count);
}/**/

function setTotal(total,count){
    if (count == 0){
        window.location = baseUrl;
    }else{
    $("div.totalOrder").find("#total").text(total);
$("#totalOrderLabel, #totalOrderH4").text(total);
    }
}/**/');
?>

    <div class="col-sm-12">       
          <div class="row">
              <div >
             <?php   $form = ActiveForm::begin(['action'=>['/order/new']]); ?>  
         
         
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>'{items}',
        'showHeader'=>false,
        'tableOptions'=>['class'=>'table orderItemsTable'],
      //  'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'image', 'value'=>  function($cart){
                return Html::img($cart['image'],
                ['title'=>$cart['name'],'alt'=>$cart['name'],
                    'width'=>'135px','height'=>'135px'
            ]);
            },'format'=>'raw',
              'header'=>false,
              'contentOptions'=>['class'=>'img text-center']],
            ['attribute'=> 'name','header'=>false,
                'label'=>mb_convert_case(Yii::t('app','title'), MB_CASE_TITLE, "UTF-8"),
                 'contentOptions'=>['class'=>'name text-center']],
             ['attribute'=> 'price','contentOptions'=>['class'=>'price text-center'],
                 'header'=>false,'label'=>mb_convert_case(Yii::t('app','price'), MB_CASE_TITLE, "UTF-8"),
                 'value'=> function($cart){
                 return $cart['price'].'  x';}
                 ],
             ['attribute'=> 'qty','label'=>mb_convert_case(Yii::t('app','quantity'), MB_CASE_TITLE, "UTF-8"),
                 'value'=>  function($cart){
                          return Html::input('text','qty',$cart['qty'],['class'=>'qty form-control',
                              'id'=>'qty_'.$cart['category_id'].'_'.$cart['id']]);},
                'format'=>'raw',
                'header'=>false,
                 'contentOptions'=>['class'=>'qty text-center']],
             ['attribute'=> 'subtotal',
                 'label'=>mb_convert_case(Yii::t('app','subtotal'), MB_CASE_TITLE, "UTF-8"),
                 'header'=>false,
                  'value'=> function($cart){
                 return '=  '.$cart['subtotal'];},
                'contentOptions'=>['class'=>'subtotal'] ],
            ['value'=>function($cart){return '<button class="close cancel" id="cancel_'.$cart['category_id'].'_'.$cart['id'].'" type="button" aria-hidden="true">×</button>';},
                    'format'=>'raw',
                     'contentOptions'=>['class'=>'cancel text-center']],
           
        ]
        ]); ?>

        <?php ActiveForm::end();?>
              </div>
           </div>
        </div>
<script type="text/javascript">

</script>
          
     
