<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\price\Price;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$tireTitle = mb_convert_case($model->tireModel->brand->title,MB_CASE_TITLE,'UTF-8').' '.$model->tireModel->title;
$model->updateCounters(['views'=>1]);
////$model->views++;
//$model->save();
//Yii::$app->formatter->currencyCode = 'usd';
?>
                <div class="some-good-container">
                  <div class="code text-right color-gray">Код товара: <?=$model->id;?></div>
                  <div class="some-good">
                    <div class="col-xs-12 col-sm-3 equalHeight">
                        
                        <?=Html::a(Html::img($model->diskModel->thumbnailUrl,['class'=>'img-responsive']),
                                $model->diskModel->imageUrl,['class'=>'fancybox','data-pjax'=>0]);?>
                    </div>
                    <div class="col-xs-12 col-sm-9 equalHeight border-left">
                      <h3>
                          <?=Html::a($model->diskModel->fullTitle,$model->fullUrl,['data-pjax'=>0]);?></h3>
                      <div class="row">
                        <div class="col-xs-7">
                          <table>
                               <tr>
                              <td>Тип диска</td>
                              <td><?=$model->diskModel->tip;?></td>
                            </tr>
                            <tr>
                              <td>Ширина</td>
                              <td><?=$model->width;?></td>
                            </tr>
                           
                            <tr>
                              <td>Диаметр</td>
                              <td>R <?=$model->diameter;?></td>
                            </tr>
                            <tr>
                              <td>PCD</td>
                              <td><?=$model->pcd;?></td>
                            </tr>
                            <tr>
                              <td>ET</td>
                              <td><?=$model->et;?></td>
                            </tr>
                            <?php if($model->diskModel->color):?>
                             <tr>
                              <td>Цвет</td>
                              <td><?=$model->diskModel->color;?></td>
                            </tr>
                            <?php endif;?>
                             <tr>
                              <td>Количество отверстий</td>
                              <td><?=$model->diskModel->kol_otverstiy;?></td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-5">
                          <div>
                              <div class="price margin-10"><?=Price::widget(['amount'=>$model->getPrice()]);?></div>
                            <?php ActiveForm::begin([
                          
                          'method'=>'GET',
                          'action'=>$model->toCartUrl,
                          'options' => ['class' => 'form-horizontal'],
                            ]);?>
                        
                            <button class="send-calc <?=($model->quantity >0)?"":"not-exist";?> buy">купить</button>
                            <span>X
                                <input type="number" name="qty" placeholder="1" value="1">
                            </span>
                            <div class="exist"><?=($model->quantity >0)?"Есть в наличии":"Нет в наличии";?></div>
                            <?php ActiveForm::end();?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

