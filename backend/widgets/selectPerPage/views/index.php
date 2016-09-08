<?php
use yii\helpers\Html;

$this->registerJs('$(function () {'
        . '   $("[data-toggle=\'tooltip\']").tooltip();
})');

$this->registerJs(''
        .''
        . '$("select[name=\'per-page\']").on("change",function(e){'
    //    . 'var $this = $(this);'
   //     . 'var data = $(".filters input, th.action-column select " ).serialize();'
   //     .'  console.log(data);'
   //     . '$("#tire-grid").yiiGridView("applyFilter");'
      
      
        . '});'
        );
?>
<?php

echo Html::dropDownList($name,$selected,$options,
                        ['id'=>'perPageSelect',
                            'class'=>'tooltip-up',
                            'data-toggle'=>'tooltip',
                            'title'=>'Количество записей']);
?>