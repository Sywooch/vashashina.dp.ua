<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DiskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('disk', 'Disks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disk-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('disk', 'Create Disk'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'full_title','value'=>function($model){return $model->title;}],
       //     'model_id',
            'width',
            'diameter',
             'pcd',
             'et',
             'quantity',
             'price',
            // 'category_id',
            // 'discount',
            // 'discount_begin',
            // 'discount_end',
            // 'views',
            // 'status',
            // 'created',
            // 'updated',
            // 'created_by',
            // 'update_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
