<?php //var_dump($model);
use yii\helpers\Html;
$this->registerJs('
checkRandomTitle();
checkRandomMetaD();
checkRandomMetaK();
		
		$("[id$=\"randomptt\"]").on("click",function(){
checkRandomTitle();
});
		
		$("[id$=\"randomdt\"]").on("click",function(){
checkRandomMetaD();
});
		
		$("[id$=\"randomdt\"]").on("click",function(){
checkRandomMetaK();
});
		
function checkRandomTitle(){
	if(	$("[id$=\"randomptt\"]").is(":checked")){
$("[id$=\"pagetitletemplate\"]").parent("div").hide();
$("[id$=\"randompttdata\"]").parent("div").show();
}else{$("[id$=\"pagetitletemplate\"]").parent("div").show();
$("[id$=\"-randompttdata\"]").parent("div").hide();
}
		}

function checkRandomMetaD(){
	if(	$("[id$=\"randommdt\"]").is(":checked")){
$("[id$=\"meta_dtemplate\"]").parent("div").hide();
$("[id$=\"randommdtdata\"]").parent("div").show();
}else{$("[id$=\"meta_dtemplate\"]").parent("div").show();
$("[id$=\"randommdtdata\"]").parent("div").hide();
}
		}

function checkRandomMetaK(){
	if(	$("[id$=\"randommkt\"]").is(":checked")){
$("[id$=\"meta_ktemplate\"]").parent("div").hide();
$("[id$=\"randommktdata\"]").parent("div").show();
}else{$("[id$=\"meta_ktemplate\"]").parent("div").show();
$("[id$=\"randommktdata\"]").parent("div").hide();
}
		}
		
		');
?>
<?php if (isset($model->replaceDescription)):?>  
<p>Допускаются следующие параметры для автозамены:<br />
  <?php foreach($model->replaceDescription as $desc):?>
  <strong><?=$desc;?></strong><br/>
  <?php endforeach;?>
  </p>
  <?php endif;;?>
  <div class="col-md-10">
   <div id="pageTitle" style="border: 1px dashed grey;padding: 5px 15px;">
        <?php if (!isset($dntShowCurField) || $dntShowCurField===false) echo $form->field($model,'pageTitle')->textarea(array('rows'=>5,'maxlength'=>255)); ?>
        <?php if (isset($model->autoPageTitle)) echo $form->field($model,'autoPageTitle')->checkBox(array('checked'=>false)); ?>
        <?php if (isset($model->randomPTT)) echo $form->field($model,'randomPTT')->checkBox(array('checked'=>false)); ?>
        <?php if (isset($model->randomPTT)){ 
        	echo Html::label('Разделяйте варианты подстановки ";"');
        	echo $form->field($model, 'randomPTTData')->textarea(array('rows'=>5,
       )); }?>
        <?php if (isset($model->pageTitleTemplate)) echo $form->field($model, 'pageTitleTemplate')->textarea(array('rows'=>5,
       )); ?>
       
    </div>

   <div id="meta_d" style="border: 1px dashed grey;padding: 5px 15px;">
        <?php if (!isset($dntShowCurField) || $dntShowCurField===false) echo $form->field($model,'meta_d')->textarea(array('rows'=>5,'maxlength'=>255)); ?>
        <?php if (isset($model->autoMeta_d)) echo $form->field($model,'autoMeta_d')->checkBox(array('checked'=>false)); ?>
        <?php if (isset($model->randomMDT)) echo $form->field($model,'randomMDT')->checkBox(array('checked'=>false)); ?>
        <?php if (isset($model->randomMDT)) echo $form->field($model, 'randomMDTData')->textarea(array('rows'=>5,
       )); ?>
        <?php if (isset($model->meta_dTemplate)) echo $form->field($model, 'meta_dTemplate')->textarea(array('rows'=>5,
        )); ?>
       
    </div>
                <div id="meta_k" style="border: 1px dashed grey;padding: 5px 15px;">
        <?php if (!isset($dntShowCurField) || $dntShowCurField===false) echo $form->field($model,'meta_k')->textarea(array('rows'=>5,'maxlength'=>255)); ?>
        <?php if (isset($model->autoMeta_k)) echo $form->field($model,'autoMeta_k')->checkBox(array('checked'=>false)); ?>
        <?php if (isset($model->randomMKT)) echo $form->field($model,'randomMKT')->checkBox(array('checked'=>false)); ?>
        <?php if (isset($model->randomMKT)) echo $form->field($model, 'randomMKTData')->textarea(array('rows'=>5,
       )); ?>
        <?php if (isset($model->meta_kTemplate)) echo $form->field($model, 'meta_kTemplate')->textarea(array('rows'=>5,
        )); ?>
       
    </div>
</div>  
  <div class="clear" style="clear: both"></div>