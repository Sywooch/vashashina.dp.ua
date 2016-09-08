<?php 
use frontend\widgets\price\Price;
\yii\web\View::beginContent('@frontend/views/mail/mail.php');?>
<p style="margin-top:0px;margin-bottom:20px;">
       
        Благодарим за интерес к товарам Интернет-магазина <a data-orig-href="http://vashashina.dp.ua/" href="http://vashashina.dp.ua/" target="_blank">VashaShina.dp.ua.</a><br>
Ваш заказ получен и отправлен в обработку.<br>
Для подтверждения заказа наш менеджер свяжется с Вами в ближайшее время. 
       
  </p>

  <table style="border-collapse:collapse;width:100%;border-top:1px solid #DDDDDD;border-left:1px solid #DDDDDD;margin-bottom:20px;">
    <thead>
      <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:left;padding:7px;color:#222222;" colspan="2">Детализация заказа</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:left;padding:7px;"><b>№ заказа:</b> <?=$order->id;?><br/>
          <b>Дата заказа:</b> <?=date('d.m.Y',$order->created);?><br>
          <b>Способ оплаты:</b> <?=$order->sposobOplati->title;?><br>
          <b>Способ доставки:</b> <?=$order->sposobDostavki->title;?></td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:left;padding:7px;">
          <b>Имя:</b> <span class="wmi-callto"><?=$order->user->name;?></span><br>
          <b>E-mail:</b> <a class="daria-action" href="mailto:<?=$order->user->email;?>"><?=$order->user->email;?></a><br>
          <b>Телефон:</b> <span class="wmi-callto"><?=$order->user->phone;?></span><br>
         <!--  <b>IP адрес:</b> <?=Yii::$app->request->userIP;?><br> -->
         </td>
      </tr>
    </tbody>
  </table>
  <!--
    <table style="border-collapse:collapse;width:100%;border-top:1px solid #DDDDDD;border-left:1px solid #DDDDDD;margin-bottom:20px;">
    <thead>
      <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:left;padding:7px;color:#222222;">Примечание</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:left;padding:7px;"><?=$order->user->name;?><br></td>
      </tr>
    </tbody>
  </table>
  -->
  <table style="border-collapse:collapse;width:100%;border-top:1px solid #DDDDDD;border-left:1px solid #DDDDDD;margin-bottom:20px;">
    <thead>
      <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:left;padding:7px;color:#222222;">Товар:</td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:left;padding:7px;color:#222222;">Производитель</td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:right;padding:7px;color:#222222;">Количество</td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:right;padding:7px;color:#222222;">Цена</td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background-color:#EFEFEF;font-weight:bold;text-align:right;padding:7px;color:#222222;">Сумма:</td>
      </tr>
    </thead>
    <tbody>
        <?php foreach($order->productsPerOrder as $id => $productPerOrder): ?>
            <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:left;padding:7px;">
        <?php echo $productPerOrder->product->category->title.' '.$productPerOrder->product->title;?>
                  		<?php if ($productPerOrder->gift_id):?>
               		 <div style="clear:both"></div>
			<p>К данному Товару Вы получаете подарок:<br/>
			<?php $gift = Product::model()->findByPk($productPerOrder->gift_id,array('select'=>'id,title,url,manufacturer_id'));?>
		<!-- 	<image src="<?php echo $gift->imageUrl; ?>" style="width:62px;height:auto;"/> -->
			<?php echo $gift->title;?>
			</p>
			<?php endif; ?>
        </td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:left;padding:7px;"><?php //$productPerOrder->product->manufacturer->title;?></td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:right;padding:7px;"><?=$productPerOrder->quantity;?></td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:right;padding:7px;"><strong><?=Price::widget(['amount'=>$productPerOrder->subtotal/$productPerOrder->quantity]);?></strong> </td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:right;padding:7px;"><strong><?=Price::widget(['amount'=>$productPerOrder->subtotal]);?></strong> </td>
      </tr>
           <?php endforeach;?>
                </tbody>
    <tfoot>
            <tr>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:right;padding:7px;" colspan="4"><b>Итого:</b></td>
        <td style="font-size:12px;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;text-align:right;padding:7px;"><strong><?=Price::widget(['amount'=>$order->suma]); ?></strong></td>
      </tr>
          </tfoot>
  </table>
  <?php if ($order->memo):?>
  <p><strong>Примечание к заказу:</strong><br/>
  <?php echo $order->memo;?>
  </p>
  <?php endif;?>
  <p style="margin-top:0px;margin-bottom:20px;">Если у Вас есть какие-либо вопросы, ответьте на это сообщение.</p>
  <?php \yii\web\View::endContent();?>
