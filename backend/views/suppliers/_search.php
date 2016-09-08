<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\TireSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tire-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'full_title') ?>

    <?= $form->field($model, 'model_id') ?>

    <?= $form->field($model, 'width_id') ?>

    <?= $form->field($model, 'profile_id') ?>

    <?php // echo $form->field($model, 'diameter_id') ?>

    <?php // echo $form->field($model, 'max_load_id') ?>

    <?php // echo $form->field($model, 'max_speed_id') ?>

    <?php // echo $form->field($model, 'ship') ?>

    <?php // echo $form->field($model, 'usilennaya') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'discount_begin') ?>

    <?php // echo $form->field($model, 'discount_end') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
