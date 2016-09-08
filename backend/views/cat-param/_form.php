<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\CatParam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-param-form">

    <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'cat_id')->dropDownList(
    		ArrayHelper::map(Category::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
