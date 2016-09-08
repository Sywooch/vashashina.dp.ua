<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;
use yii\widgets\DetailView;



/* @var $this yii\web\View */
/* @var $model app\models\Tire */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerts">
<?php if (Yii::$app()->session->hasFlash('success')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-success alert-dismissible',
    ],
    'body' => Yii::$app()->session->getFlash('success'),
]);?>
<?php elseif (Yii::$app()->session->hasFlash('warning')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-warning alert-dismissible',
    ],
    'body' => Yii::$app()->session->getFlash('warning'),
]);?>
<?php endif;?>
</div>
<div class="tire-view">

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
            'full_title',
            'model_id',
            'width_id',
            ['attribute'=>'profile_id',
             'value'=>$model->tireProfile->profile,  ],
            'diameter_id',
            'max_load_id',
            'max_speed_id',
            'ship',
            'usilennaya',
            'quantity',
            'price',
            'category_id',
            'discount',
            'discount_begin',
            'discount_end',
            'status',
            'created',
            'updated',
            'created_by',
            'update_by',
        ],
    ]) ?>

</div>
