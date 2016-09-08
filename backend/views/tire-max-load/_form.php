<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TireMaxLoad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tire-max-load-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'index')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'max_load')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'inactive' => 'Inactive', 'active' => 'Active', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
