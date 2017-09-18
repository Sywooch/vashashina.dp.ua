 <?php error_reporting(E_ALL);
ini_set('display_errors', 'on'); 
 use yii\helpers\Html;
 
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\jui\Resizable;
 use yii\jui\JuiAsset;
//var_dump($columns);die;
//var_dump($labels);die;
//var_dump($xls);die;
 JuiAsset::register($this);

 $error = array();
 $this->title = 'Импортирование';
if (count($xls)){
 /*   Resizable::begin([
        'clientOptions' => [
            'grid' => [20, 10],
        ],
    ]);
 */
 $form = ActiveForm::begin();?>
<h1 style="text-align: center;"><?=(isset($supplyModel))?$supplyModel:'';?></h1>  
<br/>
<?php echo Button::widget( array(
    'label'=>'Закончить импортирование',
    'tagName'=> 'button',
   // 'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
   // 'size'=>'large', // null, 'large', 'small' or 'mini'
    'options'=>['class'=>'btn btn-primary','type'=>'submit'],
)); ?>

<?php echo  Html::a('Вернуться назад', ['/suppliers/import'], ['class'=>'btn btn-warning']);

  echo Html::hiddenInput('supplyModel',$supplyModel);
  echo Html::hiddenInput('type',$type);
  echo Html::hiddenInput('csvgo',true);
 // var_dump($columns);die;
?>
   <br/> <br/>
   <p> Вы собираетесь импортировать <?=count($xls)?> позиций </p>
<table class="table table-bordered">
<thead>
<?php foreach ($columns as $k=> $header):?>
<th>
<?=$header;?>
</th>
<?php endforeach;?>
</thead>
<tbody>
<?php $i = 0;?>
     <?php foreach ($xls as $key =>  $product):?>
 
<tr valign='top'>
<?php foreach ($product as $k => $v):?>

<?php if(isset($columns[$k])):?>
<td><?=$v;?> <?=Html::hiddenInput('line_'.$i.'['.$supplyModel.$type.']['.$k.']',$v);?></td>
 <?php endif;?> 
<?php //  endif;
        endforeach; ?>
</tr>
<?php $i++;?>   
<?php endforeach; ?>
</tbody>
   </table>
     <?php

 ActiveForm::end();
  //  Resizable::end();
     }else
     {
    echo "<h1> Обнаружена ошибка... </h1> ";
    echo "<p> Нет записей для импорта! Пожалуйста, попробуйте еще раз. </p> ";
  }
?>
 <?php $this->registerJS(<<<JS
 
$( "table th" ).resizable({
resize:function(event,ui){
      ui.helper.parent().css('width',ui.size.width+'px');
},
 
});
 
$('form').on('submit',function(e){
//e.preventDefault();
var selects = $('select');
var items = [];
var allow = true;

$.each(selects,function() {
  var selected = $(this).find('option:selected').val();
   $(this).parent().css("background-color","transparent");
  if ($.inArray(selected, items ) === -1 ){
  items.push(selected);
  } else{
  $(this).parent().css({backgroundColor:"red"});
  $(this).focus();
  allow = false;
  return false;
  }
})

if (allow === false){
return false;
} 

return;
//$(this).submit();

});

JS
);?>
