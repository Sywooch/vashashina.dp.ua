<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\disks\Disk */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disk-view">

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
            'full_title',
            'model_id',
            'width',
            'diameter',
            'pcd',
            'et',
            'quantity',
            'price',
            'category_id',
            'discount',
            'discount_begin',
            'discount_end',
            'views',
            'status',
            'created',
            'updated',
            'created_by',
            'update_by',
        ],
    ]) ?>

</div>
