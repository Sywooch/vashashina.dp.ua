          <div class="col-sm-12">
            <div class="row show-form">
        
                <div class="col-sm-8">
                  <div class="row">
                    <div class="col-sm-6 margin-20">
                  
                        <h4>личние данние</h4>
                        <?= $form->field($model, 'name')
                            ->input('text'); ?> 
                        
                        <?= $form->field($model, 'email')
                            ->input('email'); ?> 
                        
                         <?= $form->field($model, 'phone')
                            ->input('phone'); ?> 
                     
                    </div>

                  </div>
                </div>
                <div class="col-sm-4 padding-20">
                  <h4>способ оплатЫ:</h4>
                  <label id="paymentLabel">На курту ПриватБанка</label>
                  <h4 class="margin-30 color-gray">товар на сумму:</h4>
                  <label class="price" id="totalOrderLabel"><?=$total;?></label>
                  
                  <h4 class="margin-30 color-gray">стоимость доставки:</h4>
                  <label class="price">уточняйте</label>
                  
                  <h3 class="margin-30 color-gray"><?=Yii::t('app', 'total to pay');?>:</h3>
                  <h4 id="totalOrderH4"><?=$total;?></h4>
                 
                </div>
            
            </div>
      
          </div>