<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TireManufacturer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tire-manufacturer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255,'class'=>'span-3']) ?>

    <?php // $form->field($model, 'alias')->textInput(['maxlength' => 255,'class'=>'span-3']) ?>

    <?= $form->field($model, 'status')->dropDownList([0=>Yii::t('app', 'InActive'),1=>Yii::t('app', 'Active')],['class'=>'span-3']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
