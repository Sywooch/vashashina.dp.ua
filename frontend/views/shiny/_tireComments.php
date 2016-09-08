<?php
use frontend\assets\CommentAsset;
use yii\widgets\ActiveForm;
CommentAsset::register($this);

?>
<div class="col-sm-12">
            <div class="row">
              <div class="col-sm-8 show-reviews">
                  <?php if (count($comments)>0):?>
                  <?php foreach ($comments as $comment):?>
                <div class="some-review margin-30">
                    
                    <div class="pull-left"><h4><?=$comment->author;?>
                            <span><?=date("d.m.Y",$comment->created );?></span></h4></div>
                    <div class="rating pull-right">
                        <input name="val" value="<?=$comment->rating;?>" type="hidden"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="commentText default-font">
                  <p class="comment"><?=$comment->text;?></p>
                    </div>
                    </div>
               <?php endforeach;?>   
                  
        <?php if ($countComments >6):?>
                <div class="show-all-reviews margin-down-30">
                    <span>Все комментарии</span></div>
                  <?php endif;?>
                      <?php else:?>
                  <p>Комментариев пока нет, Будьте первым!!!</p>
                   <?php endif;?>
              </div>
              <div class="col-sm-4 add-review margin-30">
                <h4>оставить отзыв</h4>
                <?php $form = ActiveForm::begin(
                  ['options'=>['class'=>'margin-20']]);?>
               <?php echo $form->field($model,'author')->input('text');?>
                <?php echo $form->field($model,'author_email')->input('email');?>
                <?php echo $form->field($model,'text')->textarea();?>
                <?php echo $form->field($model,'category_id')
                        ->hiddenInput(['value'=>$model->category_id])->label(FALSE);?>
                <?php echo $form->field($model,'item_id')
                        ->hiddenInput(['value'=>$model->item_id])->label(FALSE);?>
                 <div id="ratingDiv" class="ratingDiv">
    <div id="rating_show" style="float: left; width:110px">Оцените товар</div>
    <div id="ratingForm" class="ratingForm" style="width: 125px;float: left">
    <input name="val" value="<?=($model->rating)?$model->rating:false;?>" type="hidden"/>
  
  
</div>
</div>  
    <?php echo $form->field($model,'rating')
                   ->hiddenInput(['value'=>$model->rating,'class'=>'ratingField'])
            ->label(FALSE);?>
                <?php if(Yii::$app->user->isGuest):?>
   <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::classname() ) ?>
                  <?php endif;?>
                  <button class="send-calc margin-20">ОСТАВИТЬ ОТЗЫВ</button>
                <?php ActiveForm::end();?> 
              </div>
            </div>
          </div>
<script type="text/javascript">
  $('.rating').rating({
	fx: 'half',
       image: baseUrl+'/js/jquery/css/images/stars_16.png',
       loader: baseUrl+'/js/jquery/css/images/ajax-loader.gif',
       readOnly:true,
	   url: '',
       callback: function(responce){
           
           this.vote_success.fadeOut(2000);
           
           alert('Общий бал: '+this._data.val);
       },
       click:function(){
        console.log(this);
        return false;
       }
});
jQuery(function(){
	  $('.ratingForm').rating({
			fx: 'half',
		       image: baseUrl+'/js/jquery/css/images/stars_16.png',
       loader: baseUrl+'/js/jquery/css/images/ajax-loader.gif',
		       readOnly:false,
		       showVotes:false,
			   url: '',
		       callback: function(responce){
		           
		           this.vote_success.fadeOut(2000);
		           
		           alert('Общий бал: '+this._data.val);
		       },
		       click:function(e){
                           console.log(e);
		     //  $('#ratingField').val(e);
		      var input = $('input.ratingField');
                      input.val(e);
		   console.log(  input);
		        return false;
		       }
		});
            });
</script>