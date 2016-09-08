<?php 
use frontend\widgets\findTire\FindTireAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

FindTireAsset::register($this);
$this->registerJs("

		",\yii\web\View::POS_END);
//var_dump($tiresRadius);die;

?>
       <div class="col-sm-6">
           <div class="search-box">
          <h2>шины</h2>
          <div class="col-sm-12">
              <?php ActiveForm::begin([
    'id' => 'tire-find-form',
    'method'=>'GET',
    'action'=>['/shiny/find'],
    'options' => ['class' => 'form-horizontal'],
]);?> 
              <ul class="select-type" id="carType">
              <li><a class="active">Все</a></li>
              <li><a>Легковые</a></li>
              <li><a>Грузовые</a></li>
              <li><a>Джипы</a></li>
              <li><a>Мото</a></li>
              <li><a>Микроавтобусы</a></li>
            </ul>
              <?php echo Html::hiddenInput('Tire[car_type]', 'all',['id'=>'carTypeInput']);?>
            <div class="select-img row">
              <div class="col-sm-6 col-md-4 to-center">
                  <?=Html::img(['/images/radius_icon.png'],['class'=>'img-responsive']);?>
                 
                <label>Диаметр</label>
                <?php echo Html::dropDownList('Tire[diameter]','',$tiresRadius,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
                             </div>
              <div class="col-sm-6 col-md-4">
                  <?=Html::img(['/images/width_icon.png'],['class'=>'img-responsive']);?>
              
                <label>Ширина</label>
                 <?php echo Html::dropDownList('Tire[width]','',$tiresWidth,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
               
              </div>
              <div class="col-sm-6 col-md-4 to-center">
                         <?=Html::img(['/images/height_icon.png'],['class'=>'img-responsive']);?>
                <label>Высота</label>
                <?php echo Html::dropDownList('Tire[profile]','',$tiresProfile,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
              </div>
            </div>
            <div class="other-option row">
              <div class="col-sm-6">
                <label>Сезон</label><br>
               <?=Html::a('','javascript:void(0)',['class'=>'seasonIcon','id'=>'summerA']);?>
                <?=Html::a('','javascript:void(0)',['class'=>'seasonIcon','id'=>'winterA']);?>
                <?=Html::a('','javascript:void(0)',['class'=>'seasonIcon','id'=>'allSeasonA']);?>
              <?php echo Html::hiddenInput('Tire[season]', '',['id'=>'seasonInput']);?>
              </div>
              <div class="col-sm-6">
                <label>Производитель</label>
              <?php echo Html::dropDownList('Tire[manufacturer_id]','',$tm,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
              </div>
            </div>
            <div class="slider-calc row">
              <div class="col-xs-12">
                <div class="count-fill pull-left">
                  <input id="minPriceTire" type="text" placeholder="мин" name="Tire[minPrice]" value="<?=$this->context->minPrice;?>" class="form-control">
                </div>
                <input id="ex" type="text" value="500,3070" data-slider-min="<?=$this->context->minPrice;?>" data-slider-max="<?=$this->context->maxPrice;?>" data-slider-step="5" data-slider-value="[<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>]" data="value: '<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>'">
                <div class="count-fill pull-right">
                  <input id="maxPriceTire" type="text" placeholder="макс" name="Tire[maxPrice]" value="<?=$this->context->maxPrice;?>" class="form-control">
                </div>
              </div>
            </div>
            <div class="find row">
              <div class="col-xs-12">
                <button class="send-calc">Подобрать</button>
                <div class="find-box">Найдено<br>
                    <span class="count">0</span>&nbsp;шин</div>
              </div>
            </div>
          </div>
          <?php ActiveForm::end() ?>
        </div>
       </div>