<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

$uploadDir = Yii::getAlias('@root').'/frontend/web/uploads/pages/'.
        ((!$model->isNewRecord)?date('Y',$model->created).'/':date('Y').'/');
//echo $uploadDir;die;
if (!is_dir($uploadDir)){
	mkdir($uploadDir,0777);
}
$uploadDir .= ((!$model->isNewRecord)?date('m',$model->created).'/':date('m').'/');
//echo $uploadDir;die;
if (!is_dir($uploadDir)){
	mkdir($uploadDir,0777);
}

$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
		'uploadURL' =>YII_BASE_URL.'/uploads/pages/'.
                       ((!$model->isNewRecord)?date('Y',$model->created).'/':date('Y').'/').
                        ((!$model->isNewRecord)?date('m',$model->created).'/':date('m').'/'),
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
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>

 	<?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?>

    <?= $form->field($model, 'meta_k')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_d')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->dropDownList([ '1' => Yii::t('app', 'Active'), '0' => Yii::t('app', 'Inactive'), ], ['class'=>'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
