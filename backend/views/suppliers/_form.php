<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tire-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'width_id')->textInput() ?>

    <?= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'diameter_id')->textInput() ?>

    <?= $form->field($model, 'max_load_id')->textInput() ?>

    <?= $form->field($model, 'max_speed_id')->textInput() ?>

    <?= $form->field($model, 'ship')->textInput(['maxlength' => 7]) ?>

    <?= $form->field($model, 'usilennaya')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'discount_begin')->textInput() ?>

    <?= $form->field($model, 'discount_end')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'update_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
