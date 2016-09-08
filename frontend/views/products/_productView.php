<?php
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$productTitle = mb_convert_case($model->title,MB_CASE_TITLE,'UTF-8');
$model->views++;
$model->save();
?>
   <div class="product">  
   <?php echo Html::a($productTitle,$model->url,
   		['class'=>'prod_title'])?>
<div class="tire"> 
    <?php echo Html::a(Html::img($model->thumbnailUrl, ['title'=>$productTitle,
    		'alt'=>$productTitle,'class'=>'tire_img']),
            $model->url
   		)?>
        <div class="tire_body">
        <p class="tire_params">
        <?php if ((array)$model->params && count($model->params)>0):?>
        <?php foreach($model->params as $param):?>
        <strong><?php echo $param->catParam->title?>:</strong> <?php echo $param->value?> <br>
       <?php endforeach;?>
       <?php endif;?>
      </p>
   
        <?=$model->short_desc;?>        
       </div>
        <div class="tire_price">
        <span style="color:#d9534f">Цена: <strong><?=$model->price;?></strong> грн.</span>
        </div>
      <div class="productBtns">
        <div class="to_cart">
            <?=Html::a(Yii::t('app','To Cart'),
                    $model->toCartUrl,['class'=>'toCart btn btn-danger btn-xs']);?>
   
       </div> 
        
        <div class="next">
               <?=Html::a(Yii::t('app','Next').' '.Html::img(['/images/next_icon.png']),
                    $model->url,['class'=>'btn btn-default btn-xs']);?>
         </div>
         </div>
       <div class="clear"></div>
               <?php if ($model->quantity >0){ $qauntity = 'avaluble.png';} else{$qauntity = 'sklad.png';};?>
      <?php echo Html::img(['/images/'.$qauntity],['class'=>'tire_status']);?>
 </div> 
 </div> 

