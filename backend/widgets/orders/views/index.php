<?php
$orderStatus = array('pending'=> 'В обработке','cancelled'=>'Отменен','completed'=>'Завершен');
?>
<table class="table bordered">
        <tr><td>Заказов <strong>в этом месяце</strong> - <?=$ordersThisMonth['total']['count'];?>,
                на сумму - <strong><?=Yii::$app->formatter->asCurrency($ordersThisMonth['total']['sum']);?></strong>,
                в т.ч.</td>
            <td>Заказов <strong>в прошлом месяце</strong> - <?=$ordersLastMonth['total']['count'];?>,
                на сумму - <strong><?=Yii::$app->formatter->asCurrency($ordersLastMonth['total']['sum']);?></strong>,
                в т.ч.</td></tr>
        <tr><td> <span style="color: green">Выполненных</span> - <?=$ordersThisMonth['completed']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersThisMonth['completed']['sum']);?></td>
            <td> <span style="color: green">Выполненных</span> - <?=$ordersLastMonth['completed']['count'];?>, 
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersLastMonth['completed']['sum']);?></td></tr>
        <tr><td><span style="color: coral">В обработке</span> - <?=$ordersThisMonth['pending']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersThisMonth['pending']['sum']);?></td>
            <td><span style="color: coral">В обработке</span> - <?=$ordersLastMonth['pending']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersLastMonth['pending']['sum']);?></td></tr>
        <tr><td><span style="color: red">Отмененных</span> - <?=$ordersThisMonth['cancelled']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersThisMonth['cancelled']['sum']);?></td>
            <td><span style="color: red">Отмененных</span> - <?=$ordersLastMonth['cancelled']['count'];?>, 
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersLastMonth['cancelled']['sum']);?></td></tr>
    </table>