<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\disks\DiskModel */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disk Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disk-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('disk', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('disk', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('disk', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'brand_id','value'=>$model->brand->title],
            'title',
            'alias',
            'pageTitle',
            'meta_k:ntext',
            'meta_d:ntext',
            'short_desc:ntext',
            'long_desc:ntext',
         
            'category_id',
            'tip',
            'image',
            'thumbnail',
            'views',
            ['attribute'=>'created','value'=>date('d.m.Y H:i:s',$model->created)],
            ['attribute'=>'updated','value'=>date('d.m.Y H:i:s',$model->updated)],
            'status',
            'featured',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>

<?php echo  \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderDisk,
   //     'filterModel' => $searchModelTire,
   //     'filter'=>FALSE,
        'columns'=> [
            ['class' => 'yii\grid\SerialColumn'],
             'id',
            ['attribute'=> 'full_title',
             'value'=>function($model){return $model->title;}    ],
            'price',
            'quantity',
            'views'
        ],
       
    ]); ?> 
