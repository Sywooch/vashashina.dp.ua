<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Button;
use yii\helpers\Html;
use kartik\widgets\FileInput;
//use yii\helpers\Url;
//use yii\web\UploadedFile;
//use dosamigos\fileupload\FileUpload;
?>
<h1>Импортирование данных Поставщика</h1>


    <?php Alert::widget([
       'options' => [
        'class' => 'alert-info',
    ],
 //   'body' => 'Say hello...',
    ]); ?>
<?php //echo anchor('products/export','Экспорт в файл');?><br /><br />
<div class="col-md-6">
<fieldset>
    <legend><strong>Ипортирование товаров из XLS, CSV или XML - файла</strong></legend>
<?php //echo anchor('shini/deactivate_tires/tt_shini','Деактивировать шины TireTraider','style="color:red"');?><br /><br />
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
 <?php echo $form->errorSummary($model); ?>
<?php echo Button::widget( array(
    'label'=>'Импорт',
    'tagName'=> 'button',
   // 'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
   // 'size'=>'large', // null, 'large', 'small' or 'mini'
    'options'=>['style'=>'margin-bottom:10px;','class'=>'btn-lg btn-primary','type'=>'submit'],
)); ?>
<br/>


<?php //echo $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>
<?php echo FileInput::widget([
'model'=>$model,
'attribute' => 'file[]',
'options'=>[
'multiple'=>true,
'accept' => 'csv','xls','xlsx','xml'
],
 'pluginOptions' => [
'showPreview' => true,
'showCaption' => true,
'showRemove' => true,
'showUpload' => false
]
]); ?>

<div style="margin-top: 10px; "class="col-md-8">

<?php echo $form->field($model,'supplier')->dropDownList(
		['TireTrader' => 'TireTrader',
		 'TireTrader' => 'TireTrader',
],
		['prompt'=>Yii::t('app', 'Choose a supplier')]);?>
    <?php echo Html::hiddenInput('csvinit', 'true');?>
</div>
<div style="margin-top: 10px; "class="col-md-8">

<?php echo $form->field($model,'type')->dropDownList(
		['Tires' => 'Tires',
		 'Disks' => 'Disks',
                 'Products' => 'Products',
],
		['prompt'=>Yii::t('app', 'Choose what to import')]);?>
    <?php echo Html::hiddenInput('csvinit', 'true');?>
</div>
<div>
<?php Button::widget([
    'label'=>'Выбрать Все',
    'options'=>array('id'=>'buttonStateful'),
]); ?>
<?php Button::widget([
    'label'=>'Очистить',
    'options'=>array('id'=>'buttonClear', 'style' =>'margin-left:10px;'),
]); ?>
<br /><br />
<div id="TireTrader" class="columns" style="display:none;border: 1px slategray solid; margin: 15px; width: 250px;padding: 25px;">
    <h6 style="text-align: center">Шамбала. Выберите, какие данные импортровать</h6>
    <?php echo Html::checkBoxList('columnsShambala','', array('id'=>'ID', 'sku'=>'Артикул', 'title'=> 'Название', 
                                                'opt_uah'=> 'Опт, грн','opt_e'=> 'Опт, Евро (USD)',
                                                'rrc_uah'=> 'Рек. розн. цена, грн','rrc_e'=> 'Рек. розн. цена, Евро (USD)','discount'=> 'Скидка','qty_kiev' => 'Кол-во на складе в Киеве',
                                                'qty_dnepr' => 'Кол-во на складе в Днепре', 'ed_izm' => 'Единицы измерения'));?>
    
</div>

</div>
<?php $form->end(); ?> 

</fieldset>
</div>
<br />
<div id="actions">


<div style="height: 5px;"></div>


<script type="text/javascript">
   /*
    jQuery(document).ready(function(){
        // убираем дополнительные переносы строк в чекбоксах
         jQuery('.columns').find("br").remove();
     // выбираем поставищика
        supplayer = jQuery('#supplyer option:selected').val();
        // прячем всех поставщиков чекбоксы
        jQuery('div.columns').hide();
        // активируем показ чекбоксов активного постаыщика
        jQuery('div#'+supplayer).show();
       
    });

jQuery('#supplyer').change(function(){
   supplayer = jQuery(this).find('option:selected').val();
//   console.log(supplayer);
        jQuery('div.columns').hide();
        jQuery('div#'+supplayer).show();
         // деактивируем все чекбоксы для избежания ошибки
        jQuery('#buttonClear').click();
});

// Выбираем все чекбоксы выбранного поставщика   
$('#buttonStateful').click(function() {
  var checkboxes =  jQuery('#columns'+supplayer).find("input");
 // console.log(checkboxes);
  jQuery.each(checkboxes,function(){
     if ($(this).is(":checked")){
        $(this).removeAttr("checked");
        } else {
            $(this).attr('checked',true);
        }
  });
  /*  var btn = $(this);
    btn.button('loading'); // call the loading function
    setTimeout(function() {
        btn.button('reset'); // call the reset function
    }, 3000);
    */
/*});

// декативируем чекбоксы для ВСЕХ поставищиков во избежание ошибки
jQuery('#buttonClear').click(function() {
  jQuery('#columnsShambala,#columnsWestshipment,#columnsOutdoor').find("input").removeAttr("checked");
  });
  
$('input#all').click(function(){
     if ($(this).is(":checked")){
        $('input.checkfield').removeAttr("checked");
         $(this).attr('checked',true);
   $('input.all').each(function(){
    $(this).attr('checked',true);
   // this.value = 'active';
   });
   } else{
     $('input.all').each(function(){
    $(this).removeAttr("checked");
   });
   }  
    
});

// price only
$('input#price').click(function(){
     if ($(this).is(":checked")){
        $('input.checkfield').removeAttr("checked");
         $('input.all').removeAttr("checked");
         $(this).attr('checked',true);
   $('input.price').each(function(){
    $(this).attr('checked',true);
   // this.value = 'active';
   });
   } else{
     $('input.price').each(function(){
    $(this).removeAttr("checked");
   });
   }  
    
});
*/
</script>
</div>
