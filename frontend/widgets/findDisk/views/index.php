<?php 
use frontend\widgets\findDisk\FindDiskAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;
use yii\bootstrap\Modal;

$bundles = FindDiskAsset::register($this);

$this->registerJs("


		",\yii\web\View::POS_END)
?>
        <div class="col-sm-6">
             <div class="search-box">
          <h2>диски</h2>
            
          <div class="col-sm-12">
               <?php ActiveForm::begin([
    'id' => 'disk-find-form',
    'method'=>'GET',
    'action'=>['/diski/find'],
    'options' => ['class' => 'form-horizontal'],
]);?> 
              <ul class="select-type" id="diskType">
              <li><a class="active">Все</a></li>
              <li><a>Стальные</a></li>
              <li><a>Литые</a></li>
              <li><a>Кованные</a></li>
              <?php echo Html::hiddenInput('Disk[disk_type]', 'all',['id'=>'diskTypeInput']);?>
            </ul>
            <div class="select-img row">
              <div class="col-sm-6 col-md-6 to-center">
                   <?=Html::img(['/images/radius_icon.png'],['class'=>'img-responsive']);?>
                <label>Диаметр</label>
               <?php echo Html::dropDownList('Disk[diameter]','',$disksRadius,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
              </div>
              <div class="col-sm-6 col-md-6">
                   <?=Html::img(['/images/width_icon.png'],['class'=>'img-responsive']);?>           
                <label>Ширина</label>
                <?php echo Html::dropDownList('Disk[width]','',$disksWidth,
    ['class'=>'dropdown','prompt'=>'Любая']);?>
              </div>
                <div class="hiddenSelect"></div>
            </div>
            <div class="other-option row">
              <div class="col-sm-6 col-md-4 to-center">
                <label>PCD<span class="tooltip-up" data-toggle="modal" data-target="#pcdModal" 
                                title="Что такое PCD?">?</span></label>
                <?php echo Html::dropDownList('Disk[pcd]','',$disksPCD,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
              </div>
              <div class="col-sm-6 col-md-4 to-center">
                <label>ET<span class="tooltip-up" data-toggle="modal" data-target="#etModal"
                               title="Что такое вылет ET?">?</span></label>
                 <?php echo Html::dropDownList('Disk[et]','',$disksET,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
              </div>
              <div class="col-sm-6 col-md-4 to-center">
                <label>Производитель</label>
                 <?php echo Html::dropDownList('Disk[manufacturer_id]','',$dm,
    ['class'=>'dropdown','prompt'=>'Любой']);?>
              </div>
            </div>
            <div class="slider-calc row">
              <div class="col-xs-12">
                <div class="count-fill pull-left">
                  <input id="minPriceDisk" type="text" placeholder="мин" name="Disk[minPrice]" value="<?=$this->context->minPrice;?>" class="form-control">
                </div>
                <input id="ex2" type="text" value="<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>" data-slider-min="<?=$this->context->minPrice;?>" 
                       data-slider-max="<?=$this->context->maxPrice;?>" data-slider-step="5" data-slider-value="[<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>]" data="value: '<?=$this->context->minPrice;?>,<?=$this->context->maxPrice;?>'">
                <div class="count-fill pull-right">
                  <input id="maxPriceTire2" type="text" placeholder="макс" name="Disk[maxPrice]" value="<?=$this->context->maxPrice;?>" class="form-control">
                </div>
              </div>
            </div>
            <div class="find row">
              <div class="col-xs-12">
                <button class="send-calc">Подобрать</button>
                <div class="find-box">Найдено<br><span class="count">0</span>&nbsp дисков</div>
              </div>
            </div>
               <?php ActiveForm::end();?>
          </div>
         
        </div>
        </div>
<?php
Modal::begin([
    'id'=>'etModal',
    'header' => '<h2>Что такое вылет ET?</h2>',
   
]);

echo $this->render('popupET',['imageDir'=>$bundles->baseUrl]);

Modal::end();
?>

<?php
Modal::begin([
    'id'=>'pcdModal',
    'header' => '<h2>Что такое PCD?</h2>',
   
]);

echo $this->render('popupPCD',['imageDir'=>$bundles->baseUrl]);

Modal::end();