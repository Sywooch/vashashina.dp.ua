<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\tires\TireModel;
use common\models\tires\TireWidth;
use common\models\tires\TireProfile;
use common\models\tires\TireMaxLoad;
use common\models\tires\TireMaxSpeed;
use common\models\tires\TireRadius;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Tire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tire-form">

    <?php $form = ActiveForm::begin(); ?>

  
<div class="col-md-4">
    <?= $form->field($model, 'model_id')->dropDownList(
    		ArrayHelper::map(TireModel::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?> 

     <?= $form->field($model, 'width')->textInput(
    		['class'=>'form-control']) ?> 

     <?= $form->field($model, 'profile')->textInput(
    		 
    		['class'=>'form-control']) ?> 

      <?= $form->field($model, 'diameter')->textInput(
    		 
    		['class'=>'form-control']) ?>

      <?= $form->field($model, 'max_load')->textInput(
    	 
    		['class'=>'form-control']) ?>
    		
      <?= $form->field($model, 'max_speed')->textInput(
    		 
    		['class'=>'form-control']) ?>

 
    <?= $form->field($model, 'ship')->textInput(['maxlength' => 7]) ?>

    <?= $form->field($model, 'usilennaya')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

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

  <?= $form->field($model, 'status')->dropDownList([ '0' => Yii::t('app', 'Inactive'), '1' => Yii::t('app', 'Active'), ], ['class'=>'form-control']) ?>
</div>
    <div style="clear:both;"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
