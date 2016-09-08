<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\form\ActiveForm;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DiskModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('disk', 'Disk Models');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
	$('#metaDataButton').click(function(){
	$('#metaData').toggle();
	return false;
    });//
		
		");
?>
<div class="disk-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('disk', 'Create Disk Model'), ['create'], ['class' => 'btn btn-success']) ?>
           <?php echo Button::widget([
    'label'=>Yii::t('app','Update Meta Data'),
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-default','id'=>'metaDataButton'],
]); ?>
    </p>
        <div id="metaData" style="display: none;margin:10px 15px; border: 1px dashed silver; padding:25px; width:auto;">
    <?php $modelProduct = new \common\models\disks\DiskModel();
    // add behavior
    $behavior = new \backend\behaviors\metaData\MetaDataBehavior;
    $behavior->randomPTTData =$modelProduct->reciveRandomPTTData();
    $behavior->randomPTT = true;
    $behavior->autoPageTitle = true;
    
    $behavior->randomMDTData =$modelProduct->reciveRandomMDTData();
    $behavior->randomMDT = true;
    $behavior->autoMeta_d = true;
    
    $behavior->randomMKTData =$modelProduct->reciveRandomMKTData();
    $behavior->randomMKT = true;
    $behavior->autoMeta_k = true;
    $modelProduct->attachBehavior('MetaTag', $behavior );
    //
  
        $form =ActiveForm::begin([
	'action'=>['update-meta-data'],
        'id'=>'updateMetaData',
	'enableAjaxValidation'=>false,
]); ?>
    <?php echo  $this->render('/site/_metaTagsForm',array('form'=>$form,'model'=>$modelProduct,'dntShowCurField'=>true));?> 
    
    	<?php //echo $form->dropDownListRow($modelProduct,'category_id',Category::getDropDownList(),array('empty' => 'Категория товара')); ?>
     <?php // echo $form->dropDownListRow($modelProduct,'manufacturer_id',  CHtml::listData(Manufacturers::model()->findAll(),'id','title'),array('empty' => 'Производитель товара')); ?>
        
    <?php echo Button::widget([
    'label'=>'Обновить',
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-success'],
]); ?>
    <?php ActiveForm::end(); ?>
</div>
 <div id="modelData">
                <p>Моделей дисков без картинок: <?=$emptyImages;?><br/>
                Моделей дисков без описаний: <?=$emptyDescs;?><br/>
                Моделей дисков без мета-тегов: <?=$emptyMeta;?></p>
            </div>	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['header'=>'Brand','value'=>function($model){
                                        return $model->brand->title;}],
            'title',
            ['label'=>Yii::t('disks','Count Disks'),  'value'=>function($model){return $model->countDisks;}],
            'tip',
            'color',
            'kol_otverstiy',
           // 'pageTitle',
           // 'meta_k:ntext',
            // 'meta_d:ntext',
            // 'short_desc:ntext',
            // 'long_desc:ntext',
            // 'brand_id',
            // 'category_id',
            // 'type',
            // 'image',
            // 'thumbnail',
            // 'views',
            // 'created',
            // 'updated',
            // 'status',
            // 'featured',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
