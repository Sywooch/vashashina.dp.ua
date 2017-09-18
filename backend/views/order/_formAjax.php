<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use backend\widgets\alerts\Alerts;

/* @var $this yii\web\View */
/* @var $model common\models\ProductImage */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin(['timeout'=>10000,'enablePushState' => false,'id'=>'piup']); ?>
<?php echo Alerts::widget();?>
Заказ №<?=$model->order->id;?><br/>
Категория: <strong><?=$model->category->title;?></strong>
<br/>
Товар: <strong><?=$model->product->title;?></strong>
<hr>
<div class="order-products-form">

    <?php $form = ActiveForm::begin(['action'=>['/order/update-items',
        'product_id'=>$model['product_id'],'order_id'=>$model['order_id']],
        'options'=>['data-pjax' => ''],'method'=>'post']); ?>



    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'orderProductsUpdateButton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
<script type="text/javascript">
$('orderProductsUpdateButton').on('click',function(){
    var form = $(this).parents('form');
    var data = form.serialize();
    console.log(data);
    
})

$('#productsperorder-quantity, #productsperorder-price').on('change',function(){
    var price = $('#productsperorder-price').val();
    var quantity = $('#productsperorder-quantity').val();
        var subtotal = price * quantity;
    $('#productsperorder-subtotal').val(subtotal);
})
</script>
