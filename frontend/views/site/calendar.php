<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Открытки к празднику';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="calendar-image"></div>
    <div class="caption">
         <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="line1"></div>
    <div class="calendar-list">
        <ul>
            <li>Январь</li>
            <li>Февраль</li>
            <li>Март</li>
            <li>Апрель</li>
        </ul>

        <ul>
            <li>Май</li>
            <li>Июнь</li>
            <li>Июль</li>
            <li>Август</li>
        </ul>

        <ul>
            <li>Сентябрь</li>
            <li>Октябрь</li>
            <li>Ноябрь</li>
            <li>Декабрь</li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="line2"></div>

</div>

<div id="smsaero_widget"></div>
<script src='http://smsaero.ru/service/widget/js/P6lk9Tzduzm3TcCWkyrZwvo6It8BQX5C' type='text/javascript'></script>
<script>
    SMSAERO_WIDGET.init("smsaero_widget");
</script>