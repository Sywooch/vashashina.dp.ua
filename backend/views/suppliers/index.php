<?php

use yii\helpers\Html;
use yii\web\Session;
//use yii\grid\GridView;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\grid\CheckboxColumn;

use common\models\tires\Tire;
use common\models\disks\Disk;
use yii\bootstrap\ButtonDropdown;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//var_dump($supplierModel);die;

$this->title = Yii::t('tires', 'TireTrader');
$this->params['breadcrumbs'][] = ['label'=>Yii::t('tires', 'Suppliers')];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo \backend\widgets\alerts\Alerts::widget();?>
<div class="tire-index">

    <p>
      	<?php echo ButtonDropdown::widget([
    'label' => 'Управление прайсом',
    'dropdown' => [
        'items' => [
            ['label' => Yii::t('tires', 'Null supplier {modelClass} price', [
  				 'modelClass' => Yii::t('tires',$this->context->supplier)]), 
            		'url' => ['deactivate-supplier-price','supplier'=>$this->context->supplier,'type'=>$_GET['type']],
        			'options'=>['class'=>'showOverlay']],
            ['label' => Yii::t('tires', 'Null Our price supplier {modelClass}', [
   				 'modelClass' => Yii::t('tires',$this->context->supplier),
					]), 'url' => ['deactivate-price','supplier'=>$this->context->supplier
                ,'type'=>$_GET['type']],'options'=>['class'=>'showOverlay']],
        	['label'=>Yii::t('tires', 'Null Our ALL price', [
   				 'modelClass' => Yii::t('tires',$this->context->supplier),
				]),'url'=> ['deactivate-price','supplier'=>$this->context->supplier,
                                    'type'=>$_GET['type'],'all'=>true]]	,
        	['label'=>Yii::t('tires', 'Update our price', [
    			'modelClass' => Yii::t('tires',$this->context->supplier),
				]),'url'=>['update-price','supplier'=>$this->context->supplier,'type'=>$_GET['type']],
        			'options'=>['class'=>'showOverlay']
      	],
        ],
    ],
	'options' =>['class'=>'btn btn-primary']
]);?>
        
            	<?php echo ButtonDropdown::widget([
    'label' => 'Управление позициями',
    'dropdown' => [
        'items' => [
            ['label' => Yii::t('app', 'Update items manufacturers', [
  				 'modelClass' => Yii::t('tires',$this->context->supplier)]), 
            	'url' => ['update-our-positions','supplier'=>$this->context->supplier,'type'=>$type,
                            'update'=>'brands'],'options'=>['class'=>'showOverlay']],
            ['label' => Yii::t('app', 'Update items models', [
  				 'modelClass' => Yii::t('tires',$this->context->supplier)]), 
            	'url' => ['update-our-positions','supplier'=>$this->context->supplier,'type'=>$type,
                            'update'=>'models'],'options'=>['class'=>'showOverlay']],
            ['label' => Yii::t('app', 'Update items', [
   				 'modelClass' => Yii::t('tires',$this->context->supplier),
					]), 
                'url' => ['update-our-positions','supplier'=>$this->context->supplier
                ,'type'=>$type,'update'=>'items'],'options'=>['class'=>'showOverlay']],
            
            ['label' => Yii::t('app', 'Update prices', [
   				 'modelClass' => Yii::t('tires',$this->context->supplier),
					]), 
                'url' => ['update-our-positions','supplier'=>$this->context->supplier
                ,'type'=>$type,'update'=>'prices'],'options'=>['class'=>'showOverlay']],
        	

        ],
    ],
	'options' =>['class'=>'btn btn-default']
]);?>
<?php 
if ($_GET['type'] == 'Disks'){
	$where = 'disk_id IS Null OR disk_id = 0';
}elseif ($_GET['type'] == 'Tires'){
	$where = 'tire_id IS Null OR tire_id = 0';
}

?>
    </p>
<p>Информация о прайсе поставщика:<br/>
    Количество  наших позиций <strong><?=Yii::t('app',$_GET['type']);?></strong> в прайсе Поставщика - <?=$model::find()->count()?><br/> 
Количество позиций в прайсе Поставщика - <?=$supplierModel::find()->count()?><br/>
Количество незаполненных позиций <strong><?=Yii::t('app',$_GET['type']);?></strong> в прайсе поставищка - <?=$supplierModel::find()->where($where)->count()?>
<br/>

</p>
<?php echo  DynaGrid::widget([
    'columns'=> $searchModel->getGridColumns(),
    'storage'=>DynaGrid::TYPE_DB,
    'theme'=>'panel-primary',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'panel'=>['heading'=>'<h3 class="panel-title">'.Html::encode(Yii::t('tires','Supplier').': '.Yii::t('tires',$this->title)).'</h3>'],
    		'toolbar' =>  [
    				['content'=>
    			//			Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
    						Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default showOverlay', 'title'=>'Reset Grid'])
    				],
    				['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
    				'{toggleData}',
    				'{export}',
    		],  'exportConfig'=> [ 
            \kartik\grid\GridView::EXCEL => 
        		['label' => 'Export to Excel',
        		'mime' => 'application/vnd.ms-excel',
				'extension' => 'xls',
				'writer' => 'Excel5',
        		'filename' =>'ShinaSupplier'.$this->context->supplier]
            		],
    	
    ],
//		'caption'=>Html::encode(Yii::t('tires','Supplier').': '.Yii::t('tires',$this->title)),
    'options'=>['id'=>'dynagrid-1'] // a unique identifier is important
]);?>
    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' =>  
        $searchModel->getGridColumns(),
      
'toolbar'=>[
['content'=>
Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('app', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['view','supplier'=>$this->context->supplier], ['data-pjax'=>false, 'class' => 'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
],
		'{export}',
		
		'{toggleData}'
],
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
        		'type' => GridView::TYPE_PRIMARY,
        		'heading' => 'Панель поставщика'  
        ],
        'caption'=>Html::encode(Yii::t('tires','Supplier').': '.Yii::t('tires',$this->title)),
        'export'=>['label'=>'Экспорт']
    ]); */
    ?>

</div>
