<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TireMaxSpeed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tire-max-speed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'index')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'speed')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
