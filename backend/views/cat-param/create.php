<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CatParam */

$this->title = Yii::t('app', 'Create Cat Param');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cat Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-param-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
