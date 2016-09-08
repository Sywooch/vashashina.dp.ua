<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\disks\DiskManufacturer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disk-manufacturer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'status')->dropDownList([0=>Yii::t('app', 'InActive'),1=>Yii::t('app', 'Active')],['class'=>'span-3']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('disk', 'Create') : Yii::t('disk', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
