<?php
use yii\widgets\Breadcrumbs;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = $model->title;
$this->registerMetaTag(['name'=> 'keywords','content' =>$model->meta_k]);
$this->registerMetaTag(['name'=> 'description','content'=>$model->meta_d]);
$links = [
     [
            'label' => mb_convert_case(Yii::t('app','news'),MB_CASE_TITLE,'UTF-8'),
            'url' =>['/news'],
            'template' => "<li><span class=\"this-page\">{link}</span></li>\n", // template for this link only
        ],
    ['label'=>$model->title],
    ];
?>

<div class="container">
            <?php echo Breadcrumbs::widget([
    'itemTemplate' => "<li class=\"path\">{link}</li>\n", // template for all links
    'homeLink'=>['label'=>  Yii::t('app', 'Home'),
        'template'=>"<li class=\"this-page\">Вы находитесь здесь: {link}</li>\n",
        'url'=>  yii\helpers\Url::home()],
    'links' => $links,
]);?>
    <h3 class="header-font padding-20"><?=  mb_convert_case($model->title,MB_CASE_UPPER,'UTF-8');?></h3>
<div class="row" >
    <div class="col-sm-12 default-font">
               <?php echo \frontend\widgets\yashare\YaShare::widget([
                'title'=>$model->title,
                'url'=>$model->url,
                'image'=>$model->imageUrl,
                'desc'=>$model->text
            ]);?>
<?=$model->text;?>
        </div>
</div>
</div>
