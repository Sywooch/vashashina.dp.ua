<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TireManufacturerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tires', 'Tire Manufacturers');
$this->params['breadcrumbs'][] = $this->title;
//echo mb_convert_case('ахиллес', MB_CASE_TITLE, 'UTF-8');;
?>
<div class="tire-manufacturer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Manufacturer',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' =>'title', 'value'=>function($model){return mb_convert_case($model->title, MB_CASE_TITLE, 'UTF-8');}],
            'alias',
            ['attribute' =>'status','value'=>function($model){return  ($model->status > 0)?Yii::t('app', 'Active'):Yii::t('app', 'InActive');}],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
