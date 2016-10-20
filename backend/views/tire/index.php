<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\widgets\alerts\Alerts;
use kartik\widgets\FileInput;
//use kartik\dynagrid\DynaGrid;
use yii\grid\GridView;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tires', 'Tires');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/tiresIndex.js',
         ['depends'=>[\yii\web\JqueryAsset::className(),
             \yii\grid\GridViewAsset::className(),
              \yii\widgets\ActiveFormAsset::className(),
              \yii\widgets\PjaxAsset::className(),
              \yii\web\YiiAsset::className(),
             \yii\bootstrap\BootstrapAsset::className(),
              \yii\bootstrap\BootstrapPluginAsset::className(),],'position'=>static::POS_END]);
$this->registerJs("
  $(document).ready(function(){
  // убираем применения фильтрм по изменению или нажатию кнопки
  $(document).off('change.yiiGridView keydown.yiiGridView');
  });
		");
?>
<div class="tire-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php echo Alerts::widget();?>

</div>
    <p>
        <?= Html::a(Yii::t('tires', 'Create {modelClass}', [
    'modelClass' => Yii::t('tires','Tire'),
]), ['create'], ['class' => 'btn btn-success']) ?>
 <?php echo Button::widget([
    'label'=>Yii::t('app','Import Tires'),
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-default','id'=>'importButton'],
]); ?>
        
         <?php echo Button::widget([
    'label'=>Yii::t('app','Export Tires'),
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-default','id'=>'exportButton'],
]); ?>

    </p>
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
    <div id="export" class="col-md-2" style="display: none;margin:10px 15px; border: 1px dashed silver; padding:25px; width:auto;overflow:hidden;">
    <?php 
        $form =ActiveForm::begin([
	'action'=>['export'],
        'id'=>'exportData',
        		//'options'=>['enctype'=>'multipart/form-data'],
	'enableAjaxValidation'=>false,
]); ?>
      
            <div class="form-group">
        <?php echo Html::textInput('currencies[EUR]','',
                ['placeholder'=>'EURO','class'=>'form-control']);?>
            </div>
                <div class="form-group">
        <?php echo Html::textInput('currencies[USD]','',
                ['placeholder'=>'USD','class'=>'form-control']);?>
            </div>
         <div class="form-group">
              <?php echo Html::label(Yii::t('app','Company Name'));?>
         <?php echo Html::textInput('companyName','VashaShina.dp.ua',
                 ['placeholder'=>Yii::t('app','Company Name'),
                     'class'=>'form-control',
                    ]);?>
                   </div>
                   <div class="form-group">
                       <?php echo Html::label(Yii::t('app','Site Name'));?>
         <?php echo Html::textInput('siteName','VashaShina.dp.ua',
                 ['placeholder'=>Yii::t('app','Site Name'),
                     'class'=>'form-control',
                    ]);?>
                   </div>
             <div class="form-group">
                    <?php echo Html::label(Yii::t('app','Site Url'));?>
         <?php echo Html::textInput('siteUrl','vashashina.dp.ua',
                 ['placeholder'=>Yii::t('app','Site Url'),
                     'class'=>'form-control',
                    ]);?>
                   </div>
                          

                          <div class="form-group">
       <?php echo Html::dropDownList('format', '',['xml'=>'XML-формат'],
               ['prompt'=>Yii::t('app','Choose file format'),
                   'class'=>'form-control']);?>
                          </div>
                <div class="form-group"> 
       <?php echo Html::dropDownList('platform', '',['rozetka.ua'=>'Rozetka.ua',
          'hotline.ua'=>'Hotline.ua','aukro.ua'=>'Aukro.ua',
           'prom.ua'=>'Prom.ua'],
               ['prompt'=>Yii::t('app','Choose a platform'),
                   'class'=>'form-control']);?>
                     </div>
 
 <br/><br/>
  <div class="form-group"> 
     <?php echo Button::widget([
    'label'=>'Экспортировать',
   // null, 'large', 'small' or 'mini'
    'options'=>['class' => 'btn btn-success'],
]); ?>
    </div>
    <?php ActiveForm::end(); ?>
 </div>
<div style="clear:both"></div>
     
<?php  \yii\widgets\Pjax::begin(['id'=>'tires']); ?>
    <?php /* echo  DynaGrid::widget([
    'columns'=> $searchModel->getGridColumns(),
    'storage'=>DynaGrid::TYPE_DB,
    'theme'=>'panel-primary',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'panel'=>['heading'=>'<h3 class="panel-title">'.Html::encode(Yii::t('tires',$this->title)).'</h3>'],
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
        		'filename' =>'ShinaTires']
            		],
    	
    ],
//		'caption'=>Html::encode(Yii::t('tires','Supplier').': '.Yii::t('tires',$this->title)),
    'options'=>['id'=>'dynagrid-tires'] // a unique identifier is important
]);*/?>
    <?php echo GridView::widget([
        'id'=>'tire-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'th.action-column select', 
        'columns' => [
             [
            'class' => 'yii\grid\CheckboxColumn',
        // you may configure additional properties here
            ],
    //        ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'brandTitle',
                'label'=>Yii::t('app','Brand'),
                'value'=>function($model){
        return $model->brandTitle;} ,
             'filter'=>ArrayHelper::map(\common\models\tires\TireManufacturer::find()
                     ->select(['id','UPPER(title) AS title'])->asArray()
                     ->orderBy(['title'=>'ASC'])->all(), 'id', 'title'),
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Brand'),
                        'class'=>'form-control']],
             ['attribute'=>'tireModel',
                   'label'=>Yii::t('app','Model'),
                 'value'=>function($model){
            return $model->modelTitle;},
                    'filter'=>$tireModels,
                    'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Model'),
                        'class'=>'form-control'],
              ],
          //   ['attribute'=>'params','value'=>function($model){return $model->getParams();}],
           // ['attribute'=> 'full_title',
           //  'value'=>function($model){return $model->title;}    ],
         //      ['attribute'=> 'model_id',
           //   'value'=>function($model){return $model->tireModel->model;}  ],
            ['attribute'=>'carTypeTitle',
                 'label'=>Yii::t('tires','Car Type'),
                'value'=> function ($model){
                    return $model->carType->title;
                },
                'filter'=>ArrayHelper::map(\common\models\tires\TireCarType::find()
                     ->select(['id','title'])->asArray()
                     ->orderBy(['title'=>'ASC'])->all(), 'id', 'title'),
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Car Type'),
                        'class'=>'form-control']
                ],
              ['attribute'=>'tireSeasonTitle',
                   'label'=>Yii::t('tires','Season'),
                   'value'=> function ($model){
                    return $model->tireSeason->title;
                },
                  'filter'=>ArrayHelper::map(\common\models\tires\TireSeason::find()
                     ->select(['id','title'])->asArray()
                     ->orderBy(['title'=>'ASC'])->all(), 'id', 'title'),
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Season'),
                        'class'=>'form-control']],
            ['attribute'=>'width','label'=>'W',
                 'filter'=>$tireWidths,
                'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Season'),
                        'class'=>'form-control param'],
                'headerOptions'=>['class'=>'param_width']],
             ['attribute'=>'profile','label'=>'P',
                  'filter'=>$tireProfiles,
                  'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Season'),
                        'class'=>'form-control param'],
                 'headerOptions'=>['class'=>'param_width']],
            ['attribute'=>'diameter','label'=>'R',
                 'filter'=>$tireDiameters,
                 'filterInputOptions'=>[//'prompt'=>Yii::t('app', 'Season'),
                        'class'=>'form-control param'],
                'headerOptions'=>['class'=>'param_width']],
                      ['attribute'=>'max_load','label'=>'ML'],
                      ['attribute'=>'max_speed','label'=>'MS'],
            
              ['attribute'=>'ship','label'=>'Шип.'],
             ['attribute'=>'usilennaya','label'=>'Усил.'],
          
             ['attribute'=>'quantity','label'=>Yii::t('app','Qty')],
             'price',
            // 'category_id',
            // 'discount',
            // 'discount_begin',
            // 'discount_end',
            	['attribute'=>'views','label'=>Yii::t('app','Vws')],
            // 'status',
            // 'created',
            // 'updated',
            // 'created_by',
            // 'update_by',

            ['class' => 'yii\grid\ActionColumn',
                 'header'=> \backend\widgets\selectPerPage\SelectPerPage::widget()],
        ],
    ]); ?>
<?php  \yii\widgets\Pjax::end(); ?>
</div>
