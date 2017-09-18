<?php
use yii\helpers\Html;

$orderStatus = array('pending'=> 'В обработке','cancelled'=>'Отменен','completed'=>'Завершен');
?>
<table class="table bordered">
        <tr><td>Заказов <?php echo Html::a('<strong>в этом месяце</strong>',
                    ['order/index','OrderSearch[month]'=>date('Y-m')])?> - <?=$ordersThisMonth['total']['count'];?>,
                на сумму - <strong><?=Yii::$app->formatter->asCurrency($ordersThisMonth['total']['sum']);?></strong>,
                в т.ч.</td>
            <td>Заказов <?php echo Html::a('<strong>в прошлом месяце</strong>',
                    ['order/index','OrderSearch[month]'=>date('m-Y', strtotime('first day of previous month'))])?> -
                <?=$ordersLastMonth['total']['count'];?>,
                на сумму - <strong><?=Yii::$app->formatter->asCurrency($ordersLastMonth['total']['sum']);?></strong>,
                в т.ч.</td></tr>
        <tr><td> <?php echo Html::a('<span style="color: green">Выполненных</span>',
                    ['order/index','OrderSearch[month]'=>date('Y-m'),
                        'OrderSearch[payment_status]'=>'completed']);?> - <?=$ordersThisMonth['completed']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersThisMonth['completed']['sum']);?></td>
            <td> <?php echo Html::a('<span style="color: green">Выполненных</span>',
                    ['order/index','OrderSearch[month]'=>date('Y-m', strtotime('first day of previous month')),
                        'OrderSearch[payment_status]'=>'completed']);?> - <?=$ordersLastMonth['completed']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersLastMonth['completed']['sum']);?></td></tr>
        <tr><td><?php echo Html::a('<span style="color: coral">В обработке</span>',
                    ['order/index','OrderSearch[month]'=>date('Y-m'),
                        'OrderSearch[payment_status]'=>'pending']);?> - <?=$ordersThisMonth['pending']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersThisMonth['pending']['sum']);?></td>
            <td><?php echo Html::a('<span style="color: coral">В обработке</span>',
                    ['order/index','OrderSearch[month]'=>date('Y-m', strtotime('first day of previous month')),
                        'OrderSearch[payment_status]'=>'pending']);?> - <?=$ordersLastMonth['pending']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersLastMonth['pending']['sum']);?></td></tr>
        <tr><td><?php echo Html::a('<span style="color: red">Отмененных</span>',
                    ['order/index','OrderSearch[month]'=>date('Y-m'),
                        'OrderSearch[payment_status]'=>'cancelled']);?> - <?=$ordersThisMonth['cancelled']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersThisMonth['cancelled']['sum']);?></td>
            <td><?php echo Html::a('<span style="color: red">Отмененных</span>',
                    ['order/index','OrderSearch[month]'=>date('Y-m', strtotime('first day of previous month')),
                        'OrderSearch[payment_status]'=>'cancelled']);?> - <?=$ordersLastMonth['cancelled']['count'];?>,
                на сумму -  <?=Yii::$app->formatter->asCurrency($ordersLastMonth['cancelled']['sum']);?></td></tr>
    </table>