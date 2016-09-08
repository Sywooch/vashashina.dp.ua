<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\CatParam;

/* @var $this yii\web\View */
/* @var $model common\models\ProductParam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-param-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList(
    		ArrayHelper::map(Product::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?>

    <?= $form->field($model, 'param_id')->dropDownList(
    		ArrayHelper::map(CatParam::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
