<?php 
use frontend\widgets\topCart\TopCartAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

TopCartAsset::register($this);
$this->registerJs("
$('#popCartItems').on('shown.bs.modal', function(e) { $('body').css('padding-right',0);});
    ",  \yii\web\View::POS_READY,'cartTop');
//var_dump($this->context->cart);die;
?>

        <div class="col-sm-3 col-xs-6 cart">
          <div class="money show-cart">
              <span class="count"><?=$this->context->count;?></span>
              <span class="price"><?=$this->context->total;?></span></div>
              <?php echo $this->render('topCartItems');?>
        </div>

    