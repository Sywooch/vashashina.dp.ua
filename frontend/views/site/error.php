<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = Yii::t('app',$name);
?>
<div class="container">
    <h5 class="menu_title"><?=Yii::t('app','ERROR');?></h5>
<div class="news" style="text-align: left;">
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
       Данная ошибка произошла в процессе обработки сервером Вашего запроса.
    </p>
    <p>
        Пожалйуста, свяжитесь с нами, если считаете, что ошибка прозошла на стороне сервера. Спасибо.
    </p>

        </div>
    </div>
</div>
