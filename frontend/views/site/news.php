<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
function cutString($string, $maxlen = 255) {
    $len = (mb_strlen($string) > $maxlen)
        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
        : $maxlen
    ;
    $cutStr = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen)
        ? '' . $cutStr . '...'
        : '' . $cutStr . ''
    ;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = mb_convert_case(Yii::t('app','news'), MB_CASE_TITLE, 'UTF-8');
$links = [
     [
            'label' => $this->title,
         
            'template' => "<li><span class=\"path\">{link}</span></li>\n", // template for this link only
        ],
];
if (isset($_GET['page']) && $_GET['page'] > 1 ){
$links[0]['url'] =  ['/news'];  
$links[]= [ 'label' => mb_convert_case(Yii::t('app','page'), MB_CASE_TITLE, 'UTF-8'). '-'.$_GET['page'],
        'template' => "<li><span class=\"path\">{link}</span></li>\n",];    
}
?>
<div class="container news">
        <?php echo Breadcrumbs::widget([
    'itemTemplate' => "<li class=\"path\">{link}</li>\n", // template for all links
    'homeLink'=>['label'=>  Yii::t('app', 'Home'),
        'template'=>"<li class=\"this-page\">Вы находитесь здесь: {link}</li>\n",
        'url'=>  yii\helpers\Url::home()],
    'links' => $links,
]);?>
    <div class="row">    
        <h1 class="news orange padding-20"><?=$this->title;?><span class="count new"><?=$count;?></span></h1>
       <?php    foreach ($models as $model):?>
        <div class="col-sm-6">
        <div class="some-news box finded bordered padding-10">
            <!--
            <?php if($model->created):?>
            <div class="date"><?=date('d.m.Y',$model->created);?></div>
            <?php endif;?>
            -->
            <div class="head"><?=Html::a($model->title,$model->url);?></div>
             <div class="rightArrow">
                <?=Html::a('',$model->url);?></div>
        </div>
              
        
      </div>
            <?php    endforeach;?>
           
  </div>
   <?php echo \kulyk\linkpager\LinkPager::widget([
    'pagination' => $pages,
]);?>
</div>
