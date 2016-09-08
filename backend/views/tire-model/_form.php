<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\components\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;
use common\models\tires\TireManufacturer;
use common\models\tires\TireCarType;
use common\models\tires\TireSeason;

/* @var $this yii\web\View */
/* @var $model app\models\TireModel */
/* @var $form yii\widgets\ActiveForm */

$uploadDir = Yii::getAlias('@root').'/frontend/web/uploads/tire-models/'.((!$model->isNewRecord)?$model->alias.'/':FALSE);
//echo $uploadDir;die;
if (!is_dir($uploadDir)){
	mkdir($uploadDir);
}

	$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
    'uploadURL' =>YII_BASE_URL.'/uploads/tire-models/'.((!$model->isNewRecord)?$model->alias:''),
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
		
?>

<div class="tire-model-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'pageTitle')->textInput(['maxlength' => 255]) ?>

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

<div class="col-md-4">
    <?= $form->field($model, 'brand_id')->dropDownList(
    		ArrayHelper::map(TireManufacturer::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?>
    		
    <?= $form->field($model, 'car_type')->dropDownList(
    		ArrayHelper::map(TireCarType::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?>
    <?= $form->field($model, 'season')->dropDownList(
    		ArrayHelper::map(TireSeason::find()->select('id,title')->orderBy('title','ASC')->all(), 'id', 'title'), 
    		['class'=>'form-control']) ?>



    <?= $form->field($model, 'imageFile')->fileInput(); ?>
    <?php echo $model->image?>

    <?php // $form->field($model, 'thumbnail')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'status')->dropDownList([ '0' => Yii::t('app', 'Inactive'), '1' => Yii::t('app', 'Active'), ], ['class'=>'form-control']) ?>

    <?= $form->field($model, 'featured')->dropDownList([ '0' =>Yii::t('app', 'False'), '1' => Yii::t('app', 'True'), ], ['prompt' => '0','class'=>'form-control']) ?>
</div>
<div class="clear" style="clear: both"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
