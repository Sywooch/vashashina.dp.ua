<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

$uploadDir = Yii::getAlias('@root').'/frontend/web/uploads/disk-models/'.((!$model->isNewRecord)?$model->alias.'/':FALSE);
//echo $uploadDir;die;
if (!is_dir($uploadDir)){
	mkdir($uploadDir);
}

	$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
    'uploadURL' =>YII_BASE_URL.'/uploads/disk-models/'.((!$model->isNewRecord)?$model->alias:''),
	'uploadDir'=>$uploadDir,
    'access' => [
        'files' => [
            'upload' => true,
            'delete' => false,
            'copy' => true,
            'move' => false,
            'rename' => false,
        ],
        'dirs' => [
            'create' => true,
            'delete' => false,
            'rename' => false,
        ],
    ],
]);

// Set kcfinder session options
Yii::$app->session->set('KCFINDER', $kcfOptions);
/* @var $this yii\web\View */
/* @var $model common\models\disks\DiskModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disk-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pageTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_k')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_d')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'short_desc')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?>
	
  	<?= $form->field($model, 'long_desc')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?> 

    <?= $form->field($model, 'brand_id')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'tip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumbnail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'views')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('disk', 'Create') : Yii::t('disk', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
