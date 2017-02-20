<?php
/* @var $month_ru_name = текущий месяц на русском */
/* @var $calendar_build = календарь по неделям */
/* @var $ru_month = месяц на русском для дат */
/* @var $month_now = число месяца */
/* @var $date_now = день недели */

$this->title = 'Календарь';
$this->params['breadcrumbs'][] = $this->title;
use frontend\models\Calendar;
$calendar = new Calendar();

?>

<section id="calendar">
    <h1 class="staled-hr-bottom m-b-20">Открытки к празднику</h1>
    <div class="calendar-mou">
        <a data-month="01" href="/calendar/01">Январь</a>
        <a data-month="05" href="/calendar/05">Май</a>
        <a data-month="09" href="/calendar/09">Сентябрь</a>
        <a data-month="02" href="/calendar/02">Февраль</a>
        <a data-month="06" href="/calendar/06">Июнь</a>
        <a data-month="10" href="/calendar/10">Октябрь</a>
        <a data-month="03" href="/calendar/03">Март</a>
        <a data-month="07" href="/calendar/07">Июль</a>
        <a data-month="11" href="/calendar/11">Ноябрь</a>
        <a data-month="04" href="/calendar/04">Апрель</a>
        <a data-month="08" href="/calendar/08">Август</a>
        <a data-month="12" href="/calendar/12">Декабрь</a>
    </div>

    <hr class="yellow-line m-t-20">
    <hr class="grey-line">
    <div class="clear"></div>
    <h2 class="m-t-20 m-b-20">Праздники в <?=$month_ru_name?></h2>

    <div class="calendar-table">
        <div class="table-row">
            <div class="table-name">Понедельник</div>
            <?php foreach ($calendar_build as $ponedel){  ?>
            <div class="calendar-day <?php if ($ponedel['0'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                <span class="date-day"><?=$ponedel['0'] ? $ponedel['0'].' '.$ru_month:'' ?></span>
                <span class="im"><?=$ponedel['0'] ? 'Именины:':'' ?></span>
                <div class="celebration-day">
                    <?php $name = $calendar->get_calendar_name($month_now, $ponedel['0']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                                  <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                </div>
            </div>
            <?php }?>
        </div>

        <div class="table-row">
            <div class="table-name">Вторник</div>
            <?php foreach ($calendar_build as $ponedel){ ?>
                <div class="calendar-day <?php if ($ponedel['1'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                    <span class="date-day"><?=$ponedel['1'] ? $ponedel['1'].' '.$ru_month:'' ?></span>
                    <span class="im"><?=$ponedel['1'] ? 'Именины:':'' ?></span>
                    <div class="celebration-day">
                        <?php $name = $calendar->get_calendar_name($month_now, $ponedel['1']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                            <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="table-row">
            <div class="table-name">Среда</div>
            <?php foreach ($calendar_build as $ponedel){ ?>
                <div class="calendar-day <?php if ($ponedel['2'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                    <span class="date-day"><?=$ponedel['2'] ? $ponedel['2'].' '.$ru_month:'' ?></span>
                    <span class="im"><?=$ponedel['2'] ? 'Именины:':'' ?></span>
                    <div class="celebration-day">
                        <?php $name = $calendar->get_calendar_name($month_now, $ponedel['2']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                            <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="table-row">
            <div class="table-name">Четверг</div>
            <?php foreach ($calendar_build as $ponedel){ ?>
                <div class="calendar-day <?php if ($ponedel['3'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                    <span class="date-day"><?=$ponedel['3'] ? $ponedel['3'].' '.$ru_month:'' ?></span>
                    <span class="im"><?=$ponedel['3'] ? 'Именины:':'' ?></span>
                    <div class="celebration-day">
                        <?php $name = $calendar->get_calendar_name($month_now, $ponedel['3']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                            <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="table-row">
            <div class="table-name">Пятница</div>
            <?php foreach ($calendar_build as $ponedel){ ?>
                <div class="calendar-day <?php if ($ponedel['4'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                    <span class="date-day"><?=$ponedel['4'] ? $ponedel['4'].' '.$ru_month:'' ?></span>
                    <span class="im"><?=$ponedel['4'] ? 'Именины:':'' ?></span>
                    <div class="celebration-day">
                        <?php $name = $calendar->get_calendar_name($month_now, $ponedel['4']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                            <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="table-row holiday">
            <div class="table-name">Суббота</div>
            <?php foreach ($calendar_build as $ponedel){ ?>
                <div class="calendar-day <?php if ($ponedel['5'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                    <span class="date-day"><?=$ponedel['5'] ? $ponedel['5'].' '.$ru_month:'' ?></span>
                    <span class="im"><?=$ponedel['5'] ? 'Именины:':'' ?></span>
                    <div class="celebration-day">
                        <?php $name = $calendar->get_calendar_name($month_now, $ponedel['5']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                            <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="table-row holiday">
            <div class="table-name">Воскресенье</div>
            <?php foreach ($calendar_build as $ponedel){ ?>
                <div class="calendar-day <?php if ($ponedel['6'] == $date_now and $month_now == date('m')){echo 'current';} ?>">
                    <span class="date-day"><?=$ponedel['6'] ? $ponedel['6'].' '.$ru_month:'' ?></span>
                    <span class="im"><?=$ponedel['6'] ? 'Именины:':'' ?></span>
                    <div class="celebration-day">
                        <?php $name = $calendar->get_calendar_name($month_now, $ponedel['6']); $name = explode(',', $name) ?>
                        <?php foreach ($name as $name_card){ ?>
                            <a href="/name/<?=trim($name_card)?>"><?=trim($name_card)?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>

</section>

<script>
     $("a[data-month='<?=$month_now?>']").css("color", "#464646").css('font-weight',"600");
</script>
