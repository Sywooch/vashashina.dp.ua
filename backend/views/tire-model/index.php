<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\form\ActiveForm;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TireModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tires', 'Tire Models');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
	$('#metaDataButton').click(function(){
	$('#metaData').toggle();
	return false;
    });//
		
		");
?>
<div class="tire-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Model',
]), ['create'], ['class' => 'btn btn-success']) ?>
   
	   <?php echo Button::widget([
    'label'=>Yii::t('app','Update Meta Data'),
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-default','id'=>'metaDataButton'],
]); ?>
	    </p>
	    <div id="metaData" style="display: none;margin:10px 15px; border: 1px dashed silver; padding:25px; width:auto;">
    <?php $modelProduct = new \common\models\tires\TireModel();
    // add behavior
    $behavior = new \backend\behaviors\metaData\MetaDataBehavior;
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
                <p>Моделей шин без картинок: <?=$emptyImages;?><br/>
                Моделей шин без описаний: <?=$emptyDescs;?><br/>
                Моделей шин без мета-тегов: <?=$emptyMeta;?></p>
            </div>	    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            
            [ 'attribute'=>'brand_id',
                'label'=>Yii::t('app','Brand'),
              'value'=>function($model){return mb_convert_case($model->brand->title,MB_CASE_TITLE,'UTF-8');},
           'filter'=>ArrayHelper::map(\common\models\tires\TireManufacturer::find()
                     ->select(['id','UPPER(title) AS title'])->asArray()
                     ->orderBy(['title'=>'ASC'])->all(), 'id', 'title'),
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Brand'),
                        'class'=>'form-control'],
            ],
                      ['attribute'=> 'title','value'=>'title',
                           'filter'=>$tireModels,],
            ['label'=>Yii::t('tires','Count Tires'),  'value'=>function($model){return $model->countTires;}],
           [ 'attribute'=>'car_type',
              'value'=>function($model){
                if($model->carType !== NULL){
                return $model->carType->title;
                }
                },
          'filter'=>ArrayHelper::map(\common\models\tires\TireCarType::find()
                     ->select(['id','title'])->asArray()
                     ->orderBy(['title'=>'ASC'])->all(), 'id', 'title'),
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Car Type'),
                        'class'=>'form-control']
            ],
           [ 'attribute'=>'season',
              'value'=>function($model){return $model->tireSeason->title;},
         'filter'=>ArrayHelper::map(\common\models\tires\TireSeason::find()
                     ->select(['id','title'])->asArray()
                     ->orderBy(['title'=>'ASC'])->all(), 'id', 'title'),
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Season'),
                        'class'=>'form-control']
            ],
                 [ 'attribute'=>'desc','value'=> function($model){
                  return ($model->long_desc)?Yii::t('app','Yes'):Yii::t('app','No');
                 },
                   'filter' => ['1'=>Yii::t('app','Yes'),'0'=>Yii::t('app','No')  ],
                  'headerOptions'=>['class'=>'min-width']
                 ],
        ['attribute'=>'image', 'value'=>  function($model){
        if ($model->image !== null){
         //   $image = $model->image;
        
    return $this->render('/product/fancybox',['thumbnail'=>$model->thumbnailUrl,
       'image'=>$model->imageUrl]); 
        }
          },
                  'filter'=>FALSE,
                  'format'=>'raw'
                  ],
        //    'meta_k:ntext',
            // 'meta_d:ntext',
            // 'short_desc:ntext',
            // 'long_desc:ntext',
            // 'brand_id',
            // 'car_type',
            // 'season',
            // 'image',
            // 'thumbnail',
            // 'created',
            // 'updated',
            	'views',
            // 'status',
            // 'featured',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?php $this->registerJs("$('body').on('change','select[name=\"TireModelSearch[brandTitle]\"]',function(e){
    var brand_id = $(this).find('option:selected').val();
  //  console.log(brand_id);
       $.ajax({
      url: baseUrl+'/tire-manufacturer/get-brand-models',
      data: {id:brand_id},
      dataType: 'html',
      success:function(data){
       if (data.length > 0){
    $('select[name=\"TireModelSearch[tireModel]\"]').replaceWith(data);       
       }
              }  
   });
});"
        . "");


