<?php
use frontend\widgets\findTire\FindTireAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

FindTireAsset::register($this);

?>
<!-- filter -->

          <div class="col-md-3 filter">
                    <?php ActiveForm::begin([
    'id' => 'tire-find-form',
    'method'=>'GET',
    'action'=>['/shiny/find'],
    'options' => ['class' => 'form-horizontal', 'data-pjax' => true],
]);?> 
            <h1 class="margin-down-20">Фильтр</h1>
                    
            <div class="row">
                <div class="col-sm-12">
              <label>Тип шин</label>
                <?php echo Html::dropDownList('Tire[car_type]',$this->context->params['car_type'],$car_types,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
                </div>
            </div>
            <div>
              <div class="row">
                <div class="col-sm-5 icons">
                      <?=Html::img(['/images/icons/radius_icon_78x45.png'],['class'=>'']);?>
                </div>
                <div class="col-sm-7 icons">
                    <?php echo Html::label('Диаметр');?>
                    <?php echo Html::dropDownList('Tire[diameter]',$this->context->params['diameter'],$tiresRadius,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5 icons">
                      <?=Html::img(['/images/icons/width_icon_68x57.png'],['class'=>'minus-margin']);?>
                 
                </div>
                <div class="col-sm-7 icons">
                   <?php echo Html::label('Ширина');?>  
                  <?php echo Html::dropDownList('Tire[width]',$this->context->params['width'],$tiresWidth,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
              
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5 icons">
                       <?=Html::img(['/images/icons/height_icon_77x45.png'],['class'=>'']);?>
                </div>
                <div class="col-sm-7 icons">
                     <?php echo Html::label('Высота');?>
                <?php echo Html::dropDownList('Tire[profile]',$this->context->params['profile'],$tiresProfile,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
            <div class="season">
              <label>Cезон</label><br>
               <?=Html::a('','javascript:void(0)',
    ['class'=>($this->context->params['season']=='summerA')?'seasonIcon active':'seasonIcon','id'=>'summerA']);?>
                <?=Html::a('','javascript:void(0)',
    ['class'=>($this->context->params['season']=='winterA')?'seasonIcon active':'seasonIcon','id'=>'winterA']);?>
                <?=Html::a('','javascript:void(0)',
    ['class'=>($this->context->params['season']=='allSeasonA')?'seasonIcon active':'seasonIcon','id'=>'allSeasonA']);?>
                <?php echo Html::hiddenInput('Tire[season]', $this->context->params['season'],['id'=>'seasonInput']);?>
            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
              <label>Шипованая</label>
               <?php echo Html::dropDownList('Tire[ship]',$this->context->params['ship'],$ship,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
            </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
              <label>Производитель</label>
           <?php echo Html::dropDownList('Tire[manufacturer_id]',$this->context->params['manufacturer_id'],$tm,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
            </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                  <label>Цена, <?=preg_replace('#[a-z0-9.,]*#u', '',
                          Yii::$app->formatter->asCurrency(0));?></label>
                
          <input id="ex" type="text" 
                 value="<?=$this->context->params['minPrice'];?>,<?=$this->context->params['maxPrice'];?>" 
                 data-slider-min="<?=$this->context->minPrice;?>" 
                 data-slider-max="<?=$this->context->maxPrice;?>" 
                 data-slider-step="5" 
                 data-slider-value="[<?=$this->context->currentMinPrice;?>,<?=$this->context->currentMaxPrice;?>]" data="value: '<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>'">
              </div><br/>
              <div class="col-xs-6">
                  <p class="inputPrice">от
         <input id="minPriceTire" type="text" placeholder="мин" name="Tire[minPrice]" 
                value="<?=$this->context->currentMinPrice;?>" class="form-control">
                  </p>
                       </div>
              <div class="col-xs-6">
                 <p class="inputPrice">до
                  <input id="maxPriceTire" type="text" placeholder="макс" name="Tire[maxPrice]" 
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
                    <span class="count">0</span>&nbsp;шин</div>
              </div>
            </div>
              </div>
        <?php ActiveForm::end() ?>         
            </div>
          
         
             <!-- end filter -->