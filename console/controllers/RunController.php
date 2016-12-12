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

        function go_parse($item){
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

            if ($result['0']["PlaceName"]){
                $id_airport_names = Yii::$app->db->createCommand("select * from airport_names where id=:id")
                    ->bindValue(':id', $item['id'])
                    ->queryOne();
                if ($id_airport_names){
                    Yii::$app->db->createCommand("delete from airport_names where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->query();
                }
                Yii::$app->db->createCommand("insert into airport_names (id,airport_names,lang)VALUES (:id,:airport_names,:lang)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':airport_names', $result['0']["PlaceName"])
                    ->bindValue(':lang', "ru")
                    ->query();
            }else{
                print_r($item['id'].' нет PlaceName');
            }


            if ($result['0']["CountryName"]){
                $id_airport_names = Yii::$app->db->createCommand("select * from countries where id=:id")
                    ->bindValue(':id', $item['id'])
                    ->queryOne();
                if ($id_airport_names){
                     Yii::$app->db->createCommand("delete from countries where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->query();
                }
                Yii::$app->db->createCommand("insert into countries (id,countries,lang)VALUES (:id,:countries,:lang)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':countries', $result['0']["CountryName"])
                    ->bindValue(':lang', "ru")
                    ->query();
            }else{
                print_r($item['id'].' нет CountryName');
            }



            if ($result['0']["CityName"]){
                $id_airport_names = Yii::$app->db->createCommand("select * from cities where id=:id")
                    ->bindValue(':id', $item['id'])
                    ->queryOne();
                if ($id_airport_names){
                    Yii::$app->db->createCommand("delete from cities where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->query();
                }

                Yii::$app->db->createCommand("insert into cities (id,cities,lang)VALUES (:id,:cities,:lang)")
                    ->bindValue(':id', $item['id'])
                    ->bindValue(':cities', $result['0']["CityName"])
                    ->bindValue(':lang', "ru")
                    ->query();
            }else{
                print_r($item['id'].' нет CityName');
            }




            if ($result['0']["PlaceName"] and $result['0']["CountryName"] and $result['0']["CityName"] ){
                Yii::$app->db->createCommand("update airport set status = 1 where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->query();
            }
            sleep(1);

        }

        $ddb = Yii::$app->db->createCommand('select * from airport where status = 0')->queryAll();
        // Инициализируем курл
        $i = 0 ;
        foreach ($ddb as $item){

            $i++;
            go_parse($item);
        }




    }

}

