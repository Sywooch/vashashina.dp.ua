<?php
use yii\bootstrap\Alert;
?>
<div class="alerts">
<?php if (Yii::$app->session->hasFlash('success')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-success alert-dismissible',
    ],
    'body' => Yii::$app->session->getFlash('success'),
]);?>
<?php elseif (Yii::$app->session->hasFlash('warning')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-warning alert-dismissible',
    ],
    'body' => Yii::$app->session->getFlash('warning'),
]);?>
<?php elseif (Yii::$app->session->hasFlash('danger')):?>
<?php echo Alert::widget([
    'options' => [
        'class' => 'alert-danger alert-dismissible',
    ],
    'body' => Yii::$app->session->getFlash('danger'),
]);?>
<?php endif;?>
</div>