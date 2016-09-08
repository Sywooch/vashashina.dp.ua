<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

$uploadDir = Yii::getAlias('@root').'/frontend/web/uploads/articles/'.
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
		'uploadURL' =>YII_BASE_URL.'/uploads/articles/'.
                       ((!$model->isNewRecord)?date('Y',$model->created).'/':date('Y').'/').
                        ((!$model->isNewRecord)?date('m',$model->created).'/':date('m').'/'),
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
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_d')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_k')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
		//'skin'=>'moono',
		'enableKCFinder' => true,
    ]) ?>
    
    <?= $form->field($model, 'imageFile')->fileInput(); ?>
    <?php echo $model->image?>
    
    <?= $form->field($model, 'views')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
