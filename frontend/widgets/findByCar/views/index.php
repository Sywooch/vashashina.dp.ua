<?php 
use frontend\widgets\findByCar\FindByCarAsset;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\bootstrap\Button;
FindByCarAsset::register($this);
$this->registerJs("
		$('#resetDisk').on('click',function(){

		$('#searchDiskForm :checkbox').attr('checked',false);
		var select = $('#searchDiskForm').find('select');
		//console.log(select);
		$.each(select,function(){
	$(this).find(' :selected').removeAttr('selected')
	//$(this).prop('selected', false)
})
});
/*
diskPriceSlider = $('#ex3').slider({
id:'diskPriceSlider',
	width:'300px',
	}).on('slideStop',function(e){
	
		 $('#minPriceDisk').empty();
		 $('#maxPriceDisk').val(0);
	    $('#minPriceDisk').val(e.value[0]);
	    $('#maxPriceDisk').val(e.value[1]);
});
*/
 $('#minPriceDisk,#maxPriceDisk').change(function(){
	    var minPrice = parseInt($('#minPriceDisk').val());
	     var maxPrice = parseInt($('#maxPriceDisk').val())
        //     $('#ex3').attr('data-slider-value','['+minPrice+','+maxPrice+']');
	     diskPriceSlider.slider('setValue',[minPrice,maxPrice]);
          //   console.log(tirePriceSlider.getValue);
	   //    $('#filterForm').submit();
	});
		",\yii\web\View::POS_END)
?>
<div class="row" id="carFindRow">
        <div class="col-sm-12"><br>
          <h3 class="text-left margin-30">Я знаю только марку своего авто</h3>
          <div class="row">
              <?php ActiveForm::begin([
    'id' => 'car-find-form',
    'method'=>'GET',
    'action'=>['/site/podbor-po-avto'],
    'options' => ['class' => 'form-horizontal'],
]);?> 
            <div class="col-sm-2">
              <label>Марка</label>
              <?php echo Html::dropDownList('PodborShiniDiski[vendor]',$this->context->params['vendor'],$vendors,
    ['class'=>'dropdown', 'prompt'=>'Любая','id'=>'vendor']);?>
            </div>
            <div class="col-sm-2">
              <label>Модель</label>
                <?php echo Html::dropDownList('PodborShiniDiski[carModel]',
                        $this->context->params['carModel'],$carModels,
    ['class'=>'dropdown','prompt'=>'Любая','id'=>'carModel']);?>
              
            </div>
            <div class="col-sm-3">
              <label>Модификация</label>
            <?php echo Html::dropDownList('PodborShiniDiski[carMod]',
                        $this->context->params['carMod'],$carMods,
    ['class'=>'dropdown','prompt'=>'Любая','id'=>'carMod']);?>

            </div>
            <div class="col-sm-2 col-md-3">
              <label>Год</label>
        <?php echo Html::dropDownList('PodborShiniDiski[carYear]',
                        $this->context->params['carYear'],$carYears,
    ['class'=>'dropdown','prompt'=>'Любая','id'=>'carYear']);?>
             
            </div>
            <div class="col-sm-3 col-md-2">
              <button class="margin-30 send-calc" id="carFindButton">Подобрать</button>
            </div>
          </div>
        </div>
                       <?php ActiveForm::end() ?>
      </div>