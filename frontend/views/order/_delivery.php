<?php 
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>
<div class="col-sm-12">
    <div class="row">
        <div class="bordered padding-20">
           
              <?= $form->field($model, 'sposob_dostavki')->radioList(
    		ArrayHelper::map(\common\models\SposobDostavki::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['separator'=>'<br/>',])->label(FALSE); ?> 
                    
        </div>
    </div>
</div>