<?php $this->registerJS(
        "$('#sortSelect').on('change',function(){"
        ."$(this).parents('form').find('input[name|=\"Tire[sort]\"]:hidden').remove();"
          ."$(this).parents('form').find('input[name|=\"Disk[sort]\"]:hidden').remove();"
        ."$('div.ajax-overlay').show();"
        . "$(this).parents('form').submit();});");?>

<div class="col-sm-8 col-xs-12 text-left-xs">
               
                            <?php yii\widgets\ActiveForm::begin([
    'id' => 'sortOrder-form',
    'method'=>'GET',
   // 'action'=>['/shiny/find'],
    'options' => ['class' => 'form-vertical'],
]);?> 
                   
                  <label>Сортировать по:</label>
                  <?=$select;?> 
                 
                  <?php yii\widgets\ActiveForm::end();?>
                  
              </div>