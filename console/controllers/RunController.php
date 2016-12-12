<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;

/**
 * Test controller
 */
class RunController extends Controller {
//create table airport_names (
//id int (11),
//airport_names varchar (50),
//lang varchar (50)
//);
//
//
//create table cities (
//id int (11),
//cities varchar (50),
//lang varchar (50)
//);
//
//create table countries (
//id int (11),
//countries varchar (50),
//lang varchar (50)
//);

    public function actionIndex() {

        function go_parse($param){
            $ch = curl_init('https://www.skyscanner.ru/dataservices/geo/v2.0/autosuggest/RU/ru-RU/'.$param.'?isDestination=true&ccy=RUB');
            // Параметры курла
            curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
            // Получаем html
            $text = curl_exec($ch);

            $result =  json_decode($text, true);
            // Отключаемся
            curl_close($ch);

            return($result['0']);
        }

        $ddb = Yii::$app->db->createCommand('select * from airport where status = 0 limit 1')->queryAll();
        // Инициализируем курл

        foreach ($ddb as $item){
            var_dump(go_parse($item['IATA']));
        }




    }

}

