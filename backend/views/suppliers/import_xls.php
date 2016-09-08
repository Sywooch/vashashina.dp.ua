 <?php error_reporting(E_ALL);
ini_set('display_errors', 'on'); 
 use yii\helpers\Html;
 
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
//var_dump($columns);
//var_dump($labels);die;
//var_dump($xls);die;
 $error = array();
 $this->title = 'Импортирование';
if (count($xls)){
    
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
<?=trim(str_replace('"','',$labels[$header]));?>
</th>
<?php endforeach;?>
</thead>
<tbody>
<?php $i = 0;?>  
     <?php foreach ($xls as $key =>  $product):?>
 
<tr valign='top'>
<?php foreach ($product as $k => $v):?>

<?php if(isset($columns[$k])):?>
<td><?=$v;?> <?=Html::hiddenInput('line_'.$i.'['.$supplyModel.$type.']['.$columns[$k].']',$v);?></td>
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
     }else
     {
    echo "<h1> Обнаружена ошибка... </h1> ";
    echo "<p> Нет записей для импорта! Пожалуйста, попробуйте еще раз. </p> ";
  }
?>