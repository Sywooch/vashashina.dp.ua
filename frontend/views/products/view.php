<?php 
use yii\helpers\Html;
use frontend\assets\ViewAsset;
$this->title = ($model->page_title)?$model->page_title:$model->category->title. ' '.$model->title;
$this->registerMetaTag(['name'=> 'keywords','content' =>$model->meta_k]);
$this->registerMetaTag(['name'=> 'description','content'=>$model->meta_d]);


ViewAsset::register($this);
$this->registerJs("$('.fancybox').fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
        //        maxWidth	: 800,
	//	maxHeight	: 600,
		fitToView	: false,
	//	width		: '70%',
	//	height		: '70%',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none' , 
		helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});", $this::POS_END, 'fancybox-a');
?>
<div id="model">
<p class="block_title" style="color:#C22030"><?= mb_strtoupper($model->category->title);?> &raquo; <?=$model->title;?></p>
<table border="0" id="model_params">
<tr>
<td>
<a class="fancybox" data-fancybox-group="gallery" href="<?=$model->imageUrl;?>" title="<?=$model->title;?>">
<img src="<?=$model->thumbnailUrl;?>" 
alt="<?=$model->image;?>" title="<?=$model->image;?>" />
</a>
    <div class="socialButtons">
        
    </div>
</td>
<td style="padding: 20px;">
<?php if($model->params):?>
<?php foreach ($model->params as $key => $param):?>
<p><strong><?=$param['param'];?>:</strong> <?=$param['value'];?></p>
<div class="bottom_border"></div>
<?php endforeach;?>
<?php endif;?>
<p><strong>Цена:</strong> <?=$model->price;?></p>
<div class="bottom_border"></div>
<?php if ($model->quantity >0 && $model->status == '1'):?>
<p><strong>Количество:</strong> <?=$model->quantity;?></p>
<?php else:?>
<p><strong>Нет в наличии</p>
<?php endif;?>
<div class="bottom_border"></div>
<br/>
<?php if ($model->quantity > 0 && $model->status == '1'):?>
       <?=Html::a(Yii::t('app','To Cart').' '.Html::img(['/images/next_icon.png']),
                    $model->toCartUrl,['class'=>'add_to_cart']);?>
<?php endif;?>
</td>
</tr>
<tr>
<td colspan="2">
<div align="left" style="padding: 20px;"><?=$model->long_desc;?>
</div>
</td>
</tr>
</table>
</div>
<script language="javascript" type="text/javascript" src="/js/add_to_cart.js"></script>