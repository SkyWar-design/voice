<?php
/**
 * Created by PhpStorm.
 * User: SkyWar
 * Date: 18.02.2017
 * Time: 14:24
 */
namespace frontend\models;

use Yii;
use yii\base\Model;


class Calendar extends Model
{
   public function week_now(){
        $days = [
            'Воскресенье' , 'Понедельник' ,
            'Вторник' , 'Среда' ,
            'Четверг' , 'Пятница' , 'Суббота'
        ];
        // номер дня недели
        // с 0 до 6, 0 - воскресенье, 6 - суббота
        $num_day = (date('w'));
        // получаем название дня из массива
        $name_day = $days[$num_day];

        return $name_day;
    }

    function xgetdate($timestamp=false)
    {
        $today = time ();
        if ($timestamp === false) $timestamp = $today;
        $date = getdate ($timestamp);
        $date["days"] = (int)date ("t", $timestamp);
        if (date ("Ym", $timestamp) == date ("Ym", $today)) {
            $date["today"] = (int)date ("d", $today);
        }
        return $date;
    }
    function get_calendar_name($month, $day)
    {
        if (empty($day)){
            return false;
        }

        $name = Yii::$app->db->createCommand("SELECT party.name as name FROM party where `month` = :month and `month_full` like :date_now")
            ->bindValue(':month', $month)
            ->bindValue(':date_now', '%'.$day.'%')
            ->queryOne();

        $str = mb_substr($name['name'], 0, -2);


        return $str;
    }

    function build_calendar($month=false, $year=false)
    {

        if (!$year) $year = date ("Y");
        if (!$month) $month = date ("m");
        $actual_date = self::xgetdate(mktime (23, 59, 59, $month, 1, $year));

        $first_day = $actual_date["wday"];
        if (!$first_day--) $first_day = 6; // more usual: 0 - Monday, 6 - Sunday
        foreach (range (1, $first_day) as $i) $calendar[0][] = "";


        $last_day = $actual_date["days"] + $first_day;
        foreach (range ($first_day, $last_day - 1) as $i) {
            $calendar[$i / 7][$i % 7] = $i - $first_day + 1;
        }

        $last_week = count ($calendar) - 1;
        $full_week = ($last_week + 1) * 7;
        while ($full_week --> $last_day) $calendar[$last_week][] = "";




        return $calendar;

    }


    public function week_calendar(){

        $dayofmonth = date('t');
        $day_count = 1;
        $num = 0;


    }


    public function month_now($month){
        $date=$month;
        switch ($date){
            case 1: $m='январе'; break;
            case 2: $m='феврале'; break;
            case 3: $m='марте'; break;
            case 4: $m='апреле'; break;
            case 5: $m='мае'; break;
            case 6: $m='июне'; break;
            case 7: $m='июле'; break;
            case 8: $m='августе'; break;
            case 9: $m='сентябре'; break;
            case 10: $m='октябре'; break;
            case 11: $m='ноябре'; break;
            case 12: $m='декабре'; break;
        }
        return $m;
    }


    public function russian_date($date){
        switch ($date){
            case 1: $m='января'; break;
            case 2: $m='февраля'; break;
            case 3: $m='марта'; break;
            case 4: $m='апреля'; break;
            case 5: $m='мая'; break;
            case 6: $m='июня'; break;
            case 7: $m='июля'; break;
            case 8: $m='августа'; break;
            case 9: $m='сентября'; break;
            case 10: $m='октября'; break;
            case 11: $m='ноября'; break;
            case 12: $m='декабря'; break;
        }
        return $m;
    }



}