<?php 
use yii\helpers\Html;
?>

<div class="container podborTireDisk">
<?php echo \frontend\widgets\findByCar\FindByCar::widget();?>
<?php if (isset($podbor) && count($podbor) > 0):?>
<?php $this-> title = 'Подбор шин и дисков для автомобиля ';
$this-> title .= $podbor['vendor'].' '.$podbor['car'].' '.$podbor['modification'].' ';
 $this-> title .= $podbor['year'].'  года выпуска';?>
 
             	<div class="margin-20"><strong>На автомобиль 
      <span class="colorred"><?php echo $podbor['vendor']?> <?php echo $podbor['car']?> 
      <?php echo $podbor['modification']?> <?php echo $podbor['year']?> года выпуска</span> подходят следующие типоразмеры автошин и дисков:</strong>
      </div>
      
                <div class="row">
                <div class="col-sm-6">
                <div class="finded bordered">
                	<div class="title">Рекомендуемые шины</div>
                    <table class="tatidi" cellpadding="0" cellspacing="0">	
					<tbody>
					 <?php if (count ($zavodTires)>0 &&$zavodTires):?>
					<tr>
                    <td class="color" colspan="2">Заводская комплектация</td>
                    </tr>
                    <?php foreach($zavodTires as $zt):?>
                    <?php if ($zt):?>
                    <tr>
                    <td colspan="2">
                    <?php echo Html::a($zt,['/shiny/find',
                    		'Tire[width]'=>\common\models\PodborShiniDiski::getTireParam('width',$zt),
                     		'Tire[diameter]'=>\common\models\PodborShiniDiski::getTireParam('diameter',$zt),
                     		'Tire[profile]'=>\common\models\PodborShiniDiski::getTireParam('profile',$zt)
                    		
                    ])?>
                    </td>
                    </tr>
                     <?php endif; ?>
                    <?php endforeach;?>
                      <?php endif; ?>
                      
                    <?php if (count ($zamenaTires)>0 && $zamenaTires):?>
                    
                    <tr>
                    <td class="color" colspan="2">Варианты замены</td>
                    </tr>
                     <?php foreach($zamenaTires as $zmt):?>
                      <?php if ($zmt):?>
                    <tr>
                    <td colspan="2">
                     <?php echo Html::a($zmt,['/shiny/find',
                     		'Tire[width]'=>\common\models\PodborShiniDiski::getTireParam('width',$zmt),
                     		'Tire[diameter]'=>\common\models\PodborShiniDiski::getTireParam('diameter',$zmt),
                     		'Tire[profile]'=>\common\models\PodborShiniDiski::getTireParam('profile',$zmt)
                     		
                     ])?>
                    </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach;?>
                     <?php endif; ?>
                     
                         <?php if (count ($tuningTires)>0 && $tuningTires):?>
                  
                    <tr>
                    <td class="color" colspan="2">Варианты тюнинга</td>
                    </tr>
                     <?php foreach($tuningTires as $tt):?>
                      <?php if ($tt):?>
                    <tr>
                    <td colspan="2">
                     <?php echo Html::a($zmt,['/shiny/find',
                     		'Tire[width]'=>\common\models\PodborShiniDiski::getTireParam('width',$tt),
                     		'Tire[diameter]'=>\common\models\PodborShiniDiski::getTireParam('diameter',$tt),
                     		'Tire[profile]'=>\common\models\PodborShiniDiski::getTireParam('profile',$tt)
                     		
                     ])?>
                    </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach;?>
                     <?php endif; ?>
                    </tbody>
                    </table>
                 </div>
                    </div>
                
                <div class="col-sm-6">
                <div class="finded bordered">
                	<div class="title">Рекомендуемые диски</div>
                    <table class="tatidi" cellpadding="0" cellspacing="0">
                    <tbody>
                     <?php if (count ($zavodDisks)>0 && $zavodDisks):?>
                    <tr>
                    <td class="color" colspan="2">Заводская комплектация</td>
                    </tr>
                     <?php foreach($zavodDisks as $zd):?>
                    <?php if ($zd):?>
                    <tr>
                    <td colspan="2">
                    <?php echo Html::a($zd,['/diski/find',
                     		'Disk[width]'=>\common\models\PodborShiniDiski::getDiskParam('width',$zd),
                     		'Disk[diameter]'=>\common\models\PodborShiniDiski::getDiskParam('diameter',$zd),
                     		'Disk[et]'=>\common\models\PodborShiniDiski::getDiskParam('et',$zd)
                     		
                     ])?>
                    </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach;?>
                    <?php endif; ?>
                    
                      <?php if (count ($zamenaDisks)>0 && $zamenaDisks):?>
                      
                    <tr>
                    <td class="color" colspan="2">Варианты замены</td>
                    </tr>
                     <?php foreach($zamenaDisks as $zmd):?>
                    <?php if ($zmd):?>
                   <tr>
                   <td colspan="2">
                   
                   <?php echo Html::a($zmd,['/diski/find',
                     		'Disk[width]'=>\common\models\PodborShiniDiski::getDiskParam('width',$zmd),
                     		'Disk[diameter]'=>\common\models\PodborShiniDiski::getDiskParam('diameter',$zmd),
                     		'Disk[et]'=>\common\models\PodborShiniDiski::getDiskParam('et',$zmd)
                     		
                     ])?>
                   </td>
                   </tr>
                    <?php endif; ?>
                    <?php endforeach;?>
                    <?php endif; ?>
                   
                   <?php if (count ($tuningDisks)>0 && $tuningDisks):?>
                    <tr>
                    <td class="color" colspan="2">Варианты тюнинга</td>
                    </tr>
                     <?php foreach($tuningDisks as $td):?>
                    <?php if ($td):?>
                   <tr>
                   <td colspan="2">
                   <?php echo Html::a($td,['/diski/find',
                     		'Disk[width]'=>\common\models\PodborShiniDiski::getDiskParam('width',$td),
                     		'Disk[diameter]'=>\common\models\PodborShiniDiski::getDiskParam('diameter',$td),
                     		'Disk[et]'=>\common\models\PodborShiniDiski::getDiskParam('et',$td)
                     		
                     ])?>
                   </td>
                   </tr>
                    <?php endif; ?>
                    <?php endforeach;?>
                    <?php endif; ?> 
                    
                    </tbody>
                    </table>
                    </div>
                </div>
                
                </div>
<?php endif; ?>
</div>

                
             