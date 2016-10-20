<?php
use frontend\assets\FancyBoxAsset;
use yii\helpers\Html;
FancyBoxAsset::register($this);

$this->registerJs('$("a.fancybox").fancybox();',static::POS_READY)

?>
<?php if (isset ($image) && $image ):?>
<?php if (!isset ($thumbnail) || !$thumbnail ){$thumbnail = $image;}?>
<?php if (!isset ($width) || !$width ){$width = 75;}?>
<?php if (!isset ($height) || !$height ){$height = 75;}?>
<?php echo Html::a(Html::img($thumbnail,['class'=>'img-responsive',
    'width'=>$width.'px','height'=>$height.'px']),
 $image,['class'=>'fancybox','data-pjax'=>0]);?>
<?php endif;?>

