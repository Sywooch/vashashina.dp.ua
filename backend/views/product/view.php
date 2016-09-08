<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->category->title.' '. $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($model->category);
?>
<div class="product-view">

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
            ['attribute' => 'category_id', 'value'=>$model->category->title],
            ['attribute' => 'brand_id', 'value'=>$model->brand->title],
            'alias',
            'pageTitle',
            'meta_d',
            'meta_k',
            'short_desc:html',
            'long_desc:html',
            'thumbnail',
            'image',
            'grouping',
            'status',
          
            'featured',
            'price',
            'quantity',
            'discount',
            'views',
            ['attribute'=>'discount_begin','value'=>($model->discount_begin)?date('d-m-Y H:i',$model->discount_begin):false],
            ['attribute'=>'discount_end','value'=>($model->discount_end)?date('d-m-Y H:i',$model->discount_end):false],
            'created',
            'updated',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
