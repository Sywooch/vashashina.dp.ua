<?php 
use frontend\widgets\sidebarright\SideBarRight;
use frontend\widgets\sidebarleft\SideBarLeft;
/* @var $this View */ ?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<?php //echo SideBarRight::widget();?>
<?php //echo SideBarLeft::widget();?>

<div id="content">
	 
    <?php echo  $content;?>
 </div>
<?php $this->endContent(); ?>