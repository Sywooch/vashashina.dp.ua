<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TireModel */

$this->title = mb_convert_case($model->brand->title, MB_CASE_TITLE, "UTF-8").' '.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'alias',
            'pageTitle',
            'meta_k:ntext',
            'meta_d:ntext',
            'short_desc:html',
            'long_desc:html',
            ['attribute'=>'brand_id','value'=>$model->brand->title],
            ['attribute'=>'car_type','value'=>$model->carType->title],
            ['attribute'=>'season','value'=>$model->tireSeason->title],
           
            'image',
            ['attribute'=>'thumbnail','value'=>  Html::img($model->thumbnailUrl),'format'=>'html'],
            'status',
            'featured',
            ['attribute'=>'created','value'=>date('d.m.Y H:i:s',$model->created)],
            ['attribute'=>'updated','value'=>date('d.m.Y H:i:s',$model->updated)],
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>

<?php echo  \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderTire,
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

