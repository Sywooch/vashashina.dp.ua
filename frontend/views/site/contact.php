<?php
use yii\helpers\Html;
use common\models\Settings;
?> 

<div class="row contact">
      <div class="col-md-9"> 
      <div class="overlays" onClick="style.pointerEvents='none'"></div>
   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2644.8339900893952!2d35.004639499999996!3d48.4788978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40dbe24fd46129af%3A0x4d69c5821c65930e!2z0LLRg9C7LiDQkdGD0LvQuNCz0ZbQvdCwLCAxMCwg0JTQvdGW0L_RgNC-0L_QtdGC0YDQvtCy0YHRjNC6LCDQlNC90ZbQv9GA0L7Qv9C10YLRgNC-0LLRgdGM0LrQsCDQvtCx0LvQsNGB0YLRjA!5e0!3m2!1suk!2sua!4v1442216141530" width="100%" height="500px" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>
      <div class="col-md-3 info">
        <h1 class="h-line orange"><span>контакты</span></h1>
        <div>
          <h4 class="margin-50 text-center-xs">шиномонтаж</h4>
           <div class="margin-10">
          <div class="contactImg"><?=Html::img(['/images/phone.png']);?></div>
          <div class="contactText"> 
            <p>Тел.: <?=Settings::findOne(['name'=>'Телефон1'])->value;?></p>
            <p>Тел.: <?=Settings::findOne(['name'=>'Телефон2'])->value;?></p>
          </div>
           </div>
           <div class="margin-10">
            <div class="contactImg"><?=Html::img(['/images/map.png']);?></div>
          <div contactText>
            <p>г. Днепропетровск <br/> 
                ул.Булыгина, 10А <br/> 
                ПН-СБ: с 8:00 до 18:00</p>
           
          </div>
           </div>
        </div>
              <div>
          <h4 class="margin-50 text-center-xs">интернет-магазин</h4>
          <div class="margin-10">
          <div class="contactImg"><?=Html::img(['/images/phone.png']);?></div>
          <div class="contactText"> 
            <p>Тел.: <?=Settings::findOne(['name'=>'Телефон3'])->value;?></p>
            <p>Тел.: <?=Settings::findOne(['name'=>'Телефон4'])->value;?></p>
          </div>
          </div>
           <div class="margin-10">
          <div class="contactImg"><?=Html::img(['/images/icons/mail.png']);?></div>
          <div contactText>
            <p>e-mail: <?=Settings::findOne(['name'=>'email'])->value;?></p>
          </div>
           </div>
           <div class="margin-10">
               <div class="contactImg"><?=Html::img(['/images/icons/skype.png']);?></div>
          <div contactText>
            <p>skype: <?=Settings::findOne(['name'=>'skype'])->value;?></p>
           
          </div>
           </div>
        </div>
      </div>
    </div>
