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

        Yii::$app->db->createCommand("delete from airport_parser")->query();
        Yii::$app->db->createCommand("delete from countries")->query();
        Yii::$app->db->createCommand("delete from cities")->query();
        Yii::$app->db->createCommand("delete from airport_names")->query();


        function go_parse($item, $lang){
            $exist = Yii::$app->db->createCommand('select * from airport_parser where airport_id = :airport_id and lang=:lang')
            ->bindValue(':airport_id', $item['id'])
            ->bindValue(':lang', $lang)
            ->queryAll();

            //проверяем птовторения
            if ($exist){
                return false;
            }

            $ch = curl_init('http://www.momondo.ru/api/3.0/AutoCompleter?Query='.$item['IATA'].'&LocationLimits%5B0%5D%5Bkey%5D=1&LocationLimits%5B0%5D%5Bvalue%5D=10&Culture=ru-RU&IsFlexible=false');
            // Параметры курла
            curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
            // Получаем html
            $text = curl_exec($ch);

            $result =  json_decode($text, true);
            // Отключаемся
            curl_close($ch);



            if (empty($result["CompositeCompleterItem"]["Items"]["0"]["Name"]) and empty($result["CompositeCompleterItem"]["Items"]["0"]["Code"]) or $result["CompositeCompleterItem"]["Items"]["0"]["Code"] != $item['IATA']){
                Yii::$app->db->createCommand("update airport set status = 404 where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->query();
                return false;
            }

            Yii::$app->db->createCommand("insert into airport_parser (airport_id,lang)VALUES (:airport_id,:lang)")
                ->bindValue(':airport_id', $item['id'])
                ->bindValue(':lang', $lang)
                ->query();


            if ($result["CompositeCompleterItem"]["Items"]["0"]["Name"]){
                Yii::$app->db->createCommand("insert into airport_names (id,ru)VALUES (:id,:ru)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':ru', $result["CompositeCompleterItem"]["Items"]["0"]["Name"])
                    ->query();
            }


            if ($result["CompositeCompleterItem"]["Items"]["0"]["CountryName"]){
                Yii::$app->db->createCommand("insert into countries (id,ru)VALUES (:id,:ru)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':ru', $result["CompositeCompleterItem"]["Items"]["0"]["CountryName"])
                    ->query();
            }


            if ($result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"]){
                Yii::$app->db->createCommand("insert into cities (id,ru)VALUES (:id,:ru)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':ru', $result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"])
                    ->query();
            }


            Yii::$app->db->createCommand("update airport_parser set airport_names = :airport_names, countries =:countries, cities =:cities where airport_id = :id")
                ->bindValue(':id', $item['id'])
                ->bindValue(':airport_names', $result["CompositeCompleterItem"]["Items"]["0"]["Name"] )
                ->bindValue(':countries', $result["CompositeCompleterItem"]["Items"]["0"]["CountryName"])
                ->bindValue(':cities', $result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"])
                ->query();

            return true;
        }

        $ddb = Yii::$app->db->createCommand('select * from airport where status !=404 ')->queryAll();
        // Инициализируем курл
        $i = 0 ;
        foreach ($ddb as $item){
            $i++;
            print_r($i);
            if(go_parse($item, $lang = "ru"))
            {

            }else{
                print_r('Косячик ='.$item["id"].' ');
            };
        }




    }

}

