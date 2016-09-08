<?php

use frontend\widgets\findDisk\FindDiskAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

FindDiskAsset::register($this);

?>
<!-- filter -->

          <div class="col-md-3 filter">
                    <?php ActiveForm::begin([
    'id' => 'disk-find-form',
    'method'=>'GET',
    'action'=>['/diski/find'],
    'options' => ['class' => 'form-horizontal','data-pjax' => true],
]);?> 
            <h1 class="margin-down-20">Фильтр</h1>
                    
                <div class="row">
                <div class="col-sm-12">
              <label>Тип дисков</label>
                <?php echo Html::dropDownList('Disk[disk_type]',$this->context->params['disk_type'],$tipes,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
            </div>
                 </div>
          
              <div class="row">
                <div class="col-sm-5 icons">
                      <?=Html::img(['/images/icons/radius_icon_78x45.png'],['class'=>'']);?>
                </div>
                <div class="col-sm-7 icons">
                      <?php echo Html::label('Диаметр');?>
                    <?php echo Html::dropDownList('Disk[diameter]',$this->context->params['diameter'],$disksRadius,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5 icons">
                      <?=Html::img(['/images/icons/width_icon_68x57.png'],['class'=>'minus-margin-disk']);?>
                 
                </div>
                <div class="col-sm-7 icons">
                  <?php echo Html::label('Ширина');?> 
                  <?php echo Html::dropDownList('Disk[width]',$this->context->params['width'],$disksWidth,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
              
                </div>
              </div>
 
          
            <div class="row">
                <div class="col-xs-12">
              <label>PCD</label>
               <?php echo Html::dropDownList('Disk[pcd]',$this->context->params['pcd'],$disksPCD,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
                </div>
            </div>
                  <div class="row">
                <div class="col-xs-12">
              <label>ET</label>
               <?php echo Html::dropDownList('Disk[et]',$this->context->params['et'],$disksET,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
            </div>
                  </div>
                  <div class="row">
                <div class="col-xs-12">
              <label>Производитель</label>
           <?php echo Html::dropDownList('Disk[manufacturer_id]',$this->context->params['manufacturer_id'],$dm,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
            </div>
                  </div>
            <div class="row">
              <div class="col-xs-12">
                   <label>Цена, <?=preg_replace('#[a-z0-9.,]*#u', '',
                          Yii::$app->formatter->asCurrency(0));?></label>
          <input id="ex2" type="text" 
                 value="<?=$this->context->params['minPrice'];?>,<?=$this->context->params['maxPrice'];?>" 
                 data-slider-min="<?=$this->context->minPrice;?>" 
                 data-slider-max="<?=$this->context->maxPrice;?>" 
                 data-slider-step="5" 
                 data-slider-value="[<?=$this->context->currentMinPrice;?>,<?=$this->context->currentMaxPrice;?>]" data="value: '<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>'">
              </div><br/>
              <div class="col-xs-6">
                    <p class="inputPrice">от
         <input id="minPriceDisk" type="text" placeholder="мин" name="Disk[minPrice]" 
                value="<?=$this->context->currentMinPrice;?>" class="form-control">
                    </p>
                       </div>
              <div class="col-xs-6">
                    <p class="inputPrice">до
                  <input id="maxPriceDisk" type="text" placeholder="макс" name="Disk[maxPrice]" 
                        value="<?=$this->context->currentMaxPrice;?>" class="form-control">
                    </p>
               </div>
            </div>
           <div class="margin-down-20">
            <div class="find row">
              <div class="col-xs-12">
                <button class="send-calc">Подобрать</button>
                <div class="clearfix"></div>
                <div class="find-box bottom">Найдено<br>
                    <span class="count">0</span>&nbsp;дисков</div>
              </div>
            </div>
              </div>
        <?php ActiveForm::end() ?>         
            </div>
          
         
             <!-- end filter -->