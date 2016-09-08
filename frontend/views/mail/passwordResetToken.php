<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?php \yii\web\View::beginContent('@frontend/views/mail/mail.php');?>
<?php echo Yii::t('app','Hello');?>, <?= Html::encode($user->username) ?>,

<?php echo Yii::t('app','Follow the link below to reset your password');?>:

<?= Html::a(Html::encode(Yii::t('app','Password Reset')), $resetLink) ?>
 <?php \yii\web\View::endContent();?>
