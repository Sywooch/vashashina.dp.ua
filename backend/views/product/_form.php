<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\components\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;
use common\models\Category;
use common\models\Brand;
use dosamigos\datetimepicker\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\TireModel */
/* @var $form yii\widgets\ActiveForm */

$uploadDir = Yii::getAlias('@root').'/frontend/web/uploads/products/'.((!$model->isNewRecord)?$model->alias.'/':FALSE);
//echo $uploadDir;die;
if (!is_dir($uploadDir)){
	mkdir($uploadDir);
}
	$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
    'uploadURL' =>YII_BASE_URL.'/uploads/products/'.((!$model->isNewRecord)?$model->alias:''),
	'uploadDir'=>$uploadDir,
    'access' => [
        'files' => [
            'upload' => true,
            'delete' => false,
            'copy' => true,
            'move' => false,
            'rename' => false,
        ],
        'dirs' => [
            'create' => true,
            'delete' => false,
            'rename' => false,
        ],
    ],
]);

// Set kcfinder session options
Yii::$app->session->set('KCFINDER', $kcfOptions);
		

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

 
    <?= $form->field($model, 'pageTitle')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_d')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_k')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'short_desc')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?>
	
  	<?= $form->field($model, 'long_desc')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?> 

   
    <?= $form->field($model, 'category_id')->dropDownList(
    		ArrayHelper::map(Category::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control','prompt'=>'Выберите категорию']) ?>
    
    <?= $form->field($model, 'brand_id')->dropDownList(
    		ArrayHelper::map(Brand::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control','prompt'=>'Выберите производителя']) ?>
    
    <?= $form->field($model, 'imageFile')->fileInput(); ?>
    <?php echo $model->image?>

 <div class="col-md-4">
    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'views')->textInput() ?>

    <?= $form->field($model, 'discount_begin')->widget(DateTimePicker::className(), [
    'language' => 'ru',
    		'options' => ['value'=>($model->discount_begin)? date('Y-m-d H:i',$model->discount_begin) :''],
  //  'size' => 'ms',
  //  'template' => '{input}',
  //  'pickButtonIcon' => 'glyphicon glyphicon-time',
    'inline' => false,
    'clientOptions' => [
       // 'startView' => 0,
       // 'minView' => 0,
     //   'maxView' => 0,
        'autoclose' => false,
        'linkFormat' => 'yyyy-mm-dd hh:ii:ss', // if inline = true
    	//'startDate' => '2013-02-14 00:00',
    	'minuteStep'=> 10,
        // 'format' => 'HH:ii P', // if inline = false
        'todayBtn' => true
    ]
]); ?>

       <?= $form->field($model, 'discount_end')->widget(DateTimePicker::className(), [
    'language' => 'ru',
       		'options' => ['value'=>($model->discount_end)? date('Y-m-d H:i',$model->discount_end) :''],
  //  'size' => 'ms',
  //  'template' => '{input}',
  //  'pickButtonIcon' => 'glyphicon glyphicon-time',
    'inline' => false,
    'clientOptions' => [
       // 'startView' => 0,
       // 'minView' => 0,
     //   'maxView' => 0,
        'autoclose' => false,
        'linkFormat' => 'yyyy-mm-dd hh:ii:ss', // if inline = true
    	//'startDate' => '2013-02-14 00:00',
    	'minuteStep'=> 10,
        // 'format' => 'HH:ii P', // if inline = false
        'todayBtn' => true,
    	
    ],   'class'=>'myClass',
]); ?>
    
    <?= $form->field($model, 'grouping')->textInput(['maxlength' => 16]) ?>
 	
    <?= $form->field($model, 'featured')->dropDownList([ '0' =>Yii::t('app', 'False'), '1' => Yii::t('app', 'True'), ], ['prompt' => '0','class'=>'form-control']) ?>
    
    <?= $form->field($model, 'status')->dropDownList([ '0' => Yii::t('app', 'Inactive'), '1' => Yii::t('app', 'Active'), ], ['class'=>'form-control']) ?>
 </div>
     <div style="clear:both;"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
