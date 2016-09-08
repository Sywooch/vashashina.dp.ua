<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MetaTagTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-tag-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'metaTag')->dropDownList([ 'meta_d' => 'Meta Description', 'meta_k' => 'Meta Keywords', 'pageTitle' => 'Заголовок', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'table')->dropDownList([ 'vs_brands' => 'Производители', 'vs_categories' => 'Категории',
        'vs_tires_manufacturers' => 'Производители шин', 'vs_tires_models' => 'Модели шин',
        'vs_disks_manufacturers' => 'Производители дисков', 'vs_disks_models' => 'Модели дисков', 
        'vs_products' => 'Товары', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
