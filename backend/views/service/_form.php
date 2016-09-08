<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

$uploadDir = Yii::getAlias('@root').'/frontend/web/uploads/services/'.((!$model->isNewRecord)?$model->alias.'/':FALSE);
//echo $uploadDir;die;
if (!is_dir($uploadDir)){
	mkdir($uploadDir);
}
$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
		'uploadURL' =>YII_BASE_URL.'/uploads/services/'.((!$model->isNewRecord)?$model->alias:''),
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
/* @var $model common\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_k')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_d')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?>

    <?= $form->field($model, 'views')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
