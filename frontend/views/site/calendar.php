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
            <li>Май</li>
            <li>Июнь</li>
            <li>Июль</li>
            <li>Август</li>
            <li>Сентябрь</li>
            <li>Октябрь</li>
            <li>Ноябрь</li>
            <li>Декабрь</li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="line2"></div>

</div>
