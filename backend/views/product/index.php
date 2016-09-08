<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use kartik\widgets\FileInput;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
	$('#metaDataButton').click(function(){
	$('#metaData').toggle();
	return false;
    });//
		
	$('#importButton').click(function(){
	$('#import').toggle();
	return false;
    });//
		
		");
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="alerts">
<?php if (Yii::$app->session->hasFlash('success')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-success alert-dismissible',
    ],
    'body' => Yii::$app->session->getFlash('success'),
]);?>
<?php elseif (Yii::$app->session->hasFlash('warning')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-warning alert-dismissible',
    ],
    'body' => Yii::$app->session->getFlash('warning'),
]);?>
<?php endif;?>
</div>
    <p>
    <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
        	   <?php echo Button::widget([
    'label'=>Yii::t('app','Update Meta Data'),
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-default','id'=>'metaDataButton'],
]); ?>
        	   
          	   <?php echo Button::widget([
    'label'=>Yii::t('app','Import Products'),
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-default','id'=>'importButton'],
]); ?>
	    </p>
	    <div id="metaData" style="display: none;margin:10px 15px; border: 1px dashed silver; padding:25px; width:auto; overflow:hidden;">
    <?php $modelProduct = new \common\models\Product();
        $form =ActiveForm::begin([
	'action'=>['update-meta-data'],
        'id'=>'updateMetaData',
	'enableAjaxValidation'=>false,
]); ?>
    <?php        $behavior = new \backend\behaviors\metaData\MetaDataBehavior;
    $behavior->randomPTTData =$modelProduct->reciveRandomPTTData();
    $behavior->randomPTT = true;
    $behavior->autoPageTitle = true;
    
    $behavior->randomMDTData =$modelProduct->reciveRandomPTTData();
    $behavior->randomMDT = true;
    $behavior->autoMeta_d = true;
    
    $behavior->randomMKTData =$modelProduct->reciveRandomPTTData();
    $behavior->randomMKT = true;
    $behavior->autoMeta_k = true;
    $modelProduct->attachBehavior('MetaTag', $behavior );
    ?>
    <?php echo  $this->render('/site/_metaTagsForm',array('form'=>$form,'model'=>$modelProduct,'dntShowCurField'=>true));?> 
     <?php echo Button::widget([
    'label'=>'Обновить',
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-success'],
]); ?>
    <?php ActiveForm::end(); ?>
</div>
	    <div id="import" style="display: none;margin:10px 15px; border: 1px dashed silver; padding:25px; width:auto;overflow:hidden;">
    <?php 
        $form =ActiveForm::begin([
	'action'=>['import'],
        'id'=>'importData',
        		'options'=>['enctype'=>'multipart/form-data'],
	'enableAjaxValidation'=>false,
]); ?>
        <div class="col-md-5">
        <?php echo FileInput::widget([
'model'=>new \backend\models\ImportForm,
'attribute' => 'file[]',
'options'=>[
'multiple'=>true,
'accept' => 'csv','xls','xml'
],
 'pluginOptions' => [
'showPreview' => true,
'showCaption' => true,
'showRemove' => true,
'showUpload' => false
]
]); ?>
  </div>
   <?php echo Html::hiddenInput('csvinit', 'true');?>
     <?php echo Button::widget([
    'label'=>'Импортировать',
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-success'],
]); ?>
    <?php ActiveForm::end(); ?>
</div>
<div style="clear:both"></div>
    <?php echo  DynaGrid::widget([
    'columns'=> $searchModel->getGridColumns(),
    'storage'=>DynaGrid::TYPE_DB,
    'theme'=>'panel-primary',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'panel'=>['heading'=>'<h3 class="panel-title">'.Html::encode(Yii::t('app','Products').': '.Yii::t('tires',$this->title)).'</h3>'],
    		'toolbar' =>  [
    				['content'=>
    			//			Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
    						Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
    				],
    				['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
    				'{toggleData}',
    				'{export}',
    		],
        'exportConfig'=> [ 
            \kartik\grid\GridView::EXCEL => 
        		['label' => 'Export to Excel',
        		'mime' => 'application/vnd.ms-excel',
				'extension' => 'xls',
				'writer' => 'Excel5',
        		'filename' =>'ShinaProducts']
            		],
    	
    ],
//		'caption'=>Html::encode(Yii::t('tires','Supplier').': '.Yii::t('tires',$this->title)),
    'options'=>['id'=>'dynagrid-1'] // a unique identifier is important
]);?>

    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            ['attribute'=>'category_id','value'=>function($model){return $model->category->title;}],
            'price',
            'discount',
            'views',
            // 'meta_k',
            // 'short_desc',
            // 'long_desc:ntext',
            // 'thumbnail',
            // 'image',
            // 'grouping',
            // 'status',
            // 'category_id',
            // 'featured',
            // 'price',
            // 'quantity',
            // 'discount',
            // 'views',
            // 'discount_begin',
            // 'discount_end',
            // 'created',
            // 'updated',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>

</div>
