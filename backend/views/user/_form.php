<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'pass')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'pass_repeat')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'authRole')->dropDownList(
    		['клиент'=>'клиент','менеджер'=>'менеджер'], 
    		['class'=>'form-control', 'prompt' => 'Выберите роль для пользователя']) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
