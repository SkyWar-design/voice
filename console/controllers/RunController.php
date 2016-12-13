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

        function go_parse($item, $lang){
            $exist = Yii::$app->db->createCommand('select * from airport_parser where airport_id = :airport_id and lang=:lang')
            ->bindValue(':airport_id', $item['id'])
            ->bindValue(':lang', $lang)
            ->queryAll();


            if ($exist){
                return false;
            }

            $ch = curl_init('https://www.skyscanner.ru/dataservices/geo/v2.0/autosuggest/RU/ru-RU/'.$item['IATA']);
            // Параметры курла
            curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
            // Получаем html
            $text = curl_exec($ch);

            $result =  json_decode($text, true);
            // Отключаемся
            curl_close($ch);

            Yii::$app->db->createCommand("insert into airport_parser (airport_id,lang)VALUES (:airport_id,:lang)")
                ->bindValue(':airport_id', $item['id'])
                ->bindValue(':lang', $lang)
                ->query();

            if ($result['0']["LocalizedPlaceName"]){
                Yii::$app->db->createCommand("insert into airport_names (id,airport_names,lang)VALUES (:id,:airport_names,:lang)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':airport_names', $result['0']["LocalizedPlaceName"])
                    ->bindValue(':lang', $lang)
                    ->query();
            }else{
                if ($result['0']["PlaceName"]){
                    Yii::$app->db->createCommand("insert into airport_names (id,airport_names,lang)VALUES (:id,:airport_names,:lang)")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':airport_names', $result['0']["PlaceName"])
                        ->bindValue(':lang', $lang)
                        ->query();
                }
            }

            if ($result['0']["CountryName"]){
                Yii::$app->db->createCommand("insert into countries (id,countries,lang)VALUES (:id,:countries,:lang)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':countries', $result['0']["CountryName"])
                    ->bindValue(':lang', $lang)
                    ->query();
            }

            if ($result['0']["CityName"]){
                Yii::$app->db->createCommand("insert into cities (id,cities,lang)VALUES (:id,:cities,:lang)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':cities', $result['0']["CityName"])
                    ->bindValue(':lang', $lang)
                    ->query();
            }


            Yii::$app->db->createCommand("update airport_parser set airport_names = :airport_names, countries =:countries, cities =:cities, ResultingPhrase = :ResultingPhrase where airport_id = :id")
                ->bindValue(':id', $item['id'])
                ->bindValue(':airport_names', $result['0']["LocalizedPlaceName"] ? $result['0']["LocalizedPlaceName"]:$result['0']["PlaceName"])
                ->bindValue(':countries', $result['0']["CountryName"])
                ->bindValue(':cities', $result['0']["CityName"])
                ->bindValue(':ResultingPhrase', $result['0']["ResultingPhrase"])
                ->query();

            return true;
        }

        $ddb = Yii::$app->db->createCommand('select * from airport limit 500')->queryAll();
        // Инициализируем курл
        $i = 0 ;
        foreach ($ddb as $item){
            $i++;
            print_r($i);
            go_parse($item, $lang = "ru");
        }




    }

}

