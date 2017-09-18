<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'suma')->textInput() ?>

    <?= $form->field($model, 'payment_status')->dropDownList([ 'paid' => 'Paid', 'pending' => 'Pending', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'delivery_status')->dropDownList([ 'delivered' => 'Delivered', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'sposob_oplati')->textInput() ?>

    <?= $form->field($model, 'sposob_dostavki')->textInput() ?>


    <?= $form->field($model, 'manager_id')->textInput() ?>

    <?= $form->field($model, 'memo')->textInput(['maxlength' => 255]) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
