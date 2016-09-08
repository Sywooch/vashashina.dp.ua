<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<?php \yii\web\View::beginContent('@frontend/views/mail/mail.php');?>
<?php echo Yii::t('app','Hello');?>, <?= Html::encode(($user->name)?$user->name:$user->username) ?>,

<?php echo Yii::t('app','Thanks for registration on our site');?>:

 <?php \yii\web\View::endContent();?>
