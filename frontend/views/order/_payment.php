<?php use yii\helpers\ArrayHelper;?>
<div class="col-sm-12">
    <div class="row">
        <div class="bordered padding-20">
 <?= $form->field($model, 'sposob_oplati')->radioList(
    		ArrayHelper::map(\common\models\SposobOplati::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['separator'=>'<br/>',])->label(FALSE); ?> 
        </div>
    </div>
</div>