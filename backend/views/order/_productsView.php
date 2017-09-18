<?php
/**
 * Created by PhpStorm.
 * User: akulyk
 * Date: 08.11.2016
 * Time: 19:29
 */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use frontend\assets\YiiConfirmAsset;
YiiConfirmAsset::register($this);
$this->registerJs(<<<JS
        
$('#pjaxProductsPerOrder').on('pjax:error', function (event, xhr, textStatus, errorThrown, options) {
    alert('Failed to load the page');
         console.log(xhr);
         console.log(textStatus);
        console.log(errorThrown);
         console.log(options);
    event.preventDefault();
});/**/
        
$('#pjaxProductsPerOrder').on('pjax:end', function (event, xhr, textStatus, errorThrown, options) {

   
});
        
$('body').on('click','#pjax-products-per-order a.ajaxUpdate',function(e){
   e.preventDefault();
        $.ajax({
      url:$(this).attr('href'),
      dataType: 'html',
      success:function(data){
        var modalContainer = $('#products-per-order-update-modal');
        var modalBody = modalContainer.find('.modal-body');
          modalBody.html(data);
              }  
   });
   });  
        
        
       $('#products-per-order-update-modal').on('hidden.bs.modal', function (e) {
reloadProductsPerOrderPjax();
      getOrderSum();
});
            
 function reloadProductsPerOrderPjax(){
         $.pjax.reload({container: "#pjaxProductsPerOrder",timeout : 10000});
            }/**/
            
 function getOrderSum(){
    var id = $('#order_id').text();
      $.ajax({
      url: baseUrl + '/order/get-total-sum?order_id='+id,
      dataType: 'html',
      success:function(suma){
       $('#orderTotalSum').text(suma);
              }  
   });
      
 }/**/
            
JS
);

 Pjax::begin(['timeout'=>100000,'id'=>'pjaxProductsPerOrder']);
echo GridView::widget([
    'dataProvider' => $productsProvider,
    'id'=>'pjax-products-per-order',
    //     'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        ['attribute'=> 'category_id','value'=>function($product){
            return $product->category->title;
        }],
        ['attribute'=> 'product_id', 'value'=>function($product){
            return $product->product->title;
        } ],
        'quantity',
        'price',
        'subtotal',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            'buttons'  => [
    'update'=>function ($url, $model) {
        return Html::a(
            '<span class="glyphicon glyphicon-pencil"></span>',
            ['/order/update-items',
                'product_id'=>$model['product_id'],'order_id'=>$model['order_id']],
            [
                'class'          => 'ajaxUpdate',
                //     'delete-url'     => $url,

                'data-toggle'=>'modal',
                'data-target'=>'#products-per-order-update-modal',
                'pjax-container' => 'pjaxImages',
                'title'          => Yii::t('app', 'Update')
            ]
        );
    },
    'delete' => function ($url, $model) {
        return Html::a(
            '<span class="glyphicon glyphicon-trash"></span>',
            ['/order/delete-items',
                'product_id'=>$model['product_id'],'order_id'=>$model['order_id']],
            [
                'class'          => 'ajaxDelete',
                //     'delete-url'     => $url,
                'data-confirm'=>Yii::t('yii','Are you sure you want to delete this item?'),
                'data-method'=>'post',
                'data-pjax'=>1,
                'pjax-container' => 'pjaxProductsPerOrder',
                'title'          => Yii::t('app', 'Delete')
            ]
        );
    }
],
            ],
    ],
]);
Pjax::end();
?>
<?php        Modal::begin([
    'header' => '<h2>Обновить данные о товаре в заказе</h2>',
    'id'=>'products-per-order-update-modal',
    // 'toggleButton' => ['label' => 'click me'],
]);?>


<?php Modal::end();?>
