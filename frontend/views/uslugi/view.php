<?php
/* @var $this yii\web\View */
$this->title = ($model->page_title)?$model->page_title:$model->title;
?>
<div id="novosti">
    <h5 class="menu_title"><?=  mb_convert_case($model->title,MB_CASE_UPPER,'UTF-8');?></h5>
<div class="news" style="text-align: left;">
<?=$model->text;?>
</div>
</div>
