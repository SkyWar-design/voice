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

    public function actionTest()
    {

        function go_parse($item, $lang){
            $exist = Yii::$app->db->createCommand('select * from airport_parser where airport_id = :airport_id and lang=:lang')
                ->bindValue(':airport_id', $item['id'])
                ->bindValue(':lang', $lang['code'])
                ->queryAll();

            //проверяем повторения
            if ($exist){
                print_r('повторение');
                return false;
            }

            $ch = curl_init('http://www.momondo.ru/api/3.0/AutoCompleter?Query='.$item['IATA'].'&LocationLimits%5B0%5D%5Bkey%5D=1&LocationLimits%5B0%5D%5Bvalue%5D=10&Culture='.$lang['lang'].'&IsFlexible=false');
            // Параметры курла
            curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
            // Получаем html
            $text = curl_exec($ch);

            $result =  json_decode($text, true);
            // Отключаемся
            curl_close($ch);



            if (empty($result["CompositeCompleterItem"]["Items"]["0"]["City"]['CountryName']) and empty($result["CompositeCompleterItem"]["Items"]["0"]["City"]['MainCityName']) or $result["CompositeCompleterItem"]["Items"]["0"]["City"]["Code"] != $item['IATA'] ){
                print_r('не хватает полей');
                return false;
            }



            if ($result["CompositeCompleterItem"]["Items"]["0"]["City"]['CountryName']){
                $exist_countries =  Yii::$app->db->createCommand("select * from countries where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->queryOne();

                if($exist_countries['id']){
                    Yii::$app->db->createCommand("update countries set ".$lang['code']."=:param where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["City"]['CountryName'])
                        ->query();
                }else{
                    Yii::$app->db->createCommand("insert into countries (id,".$lang['code'].")VALUES (:id,:param)")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["City"]['CountryName'])
                        ->query();
                }
            }


            if ($result["CompositeCompleterItem"]["Items"]["0"]["City"]['MainCityName']){
                $exist_cities =  Yii::$app->db->createCommand("select * from cities where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->queryOne();

                if($exist_cities['id']){
                    Yii::$app->db->createCommand("update cities set ".$lang['code']."=:param where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["City"]['MainCityName'])
                        ->query();
                }else{
                    Yii::$app->db->createCommand("insert into cities (id,".$lang['code'].")VALUES (:id,:param)")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["City"]['MainCityName'])
                        ->query();
                }

            }


            return true;
        }

        $ddb = Yii::$app->db->createCommand('select * from airport where status=404')->queryAll();


        $langs = [
            '0'  => ['lang' => 'zh-CN', 'code'=>'zh'],// Китайский zh-CN zh       ГОТОВО
            '1'  => ['lang' => 'fr-FR', 'code'=>'fr'],// Французский fr-FR fr     ГОТОВО
            '2'  => ['lang' => 'es-ES', 'code'=>'es'],// Испанский es-ES es       ГОТОВО
            '3'  => ['lang' => 'de-DE', 'code'=>'de'],// Немецкий de-DE de        ГОТОВО
            '4'  => ['lang' => 'pt-PT', 'code'=>'pt'],// Португальский pt-PT pt   ГОТОВО
            '5'  => ['lang' => 'ru-RU', 'code'=>'ru'],// Русский ru-RU ru         ГОТОВО
            '6'  => ['lang' => 'tr-TR', 'code'=>'tr'],// Турецкий tr-TR tr
            '7'  => ['lang' => 'it-IT', 'code'=>'it'],// Итальянский it-IT it
            '8'  => ['lang' => 'nl-NL', 'code'=>'nl'],// Нидерландский nl-NL nl
        ];


        $i = 0 ;
        foreach ($ddb as $item){
            $i++;
            print_r($i);
            if(go_parse($item, $langs[6]))
            {

            }else{
                print_r('Косячик ='.$item["id"].' ');
            };
        }




    }

    public function actionIndex() {


        function go_parse($item, $lang){
            $exist = Yii::$app->db->createCommand('select * from airport_parser where airport_id = :airport_id and lang=:lang')
            ->bindValue(':airport_id', $item['id'])
            ->bindValue(':lang', $lang['code'])
            ->queryAll();

            //проверяем повторения
            if ($exist){
                return false;
            }

            $ch = curl_init('http://www.momondo.ru/api/3.0/AutoCompleter?Query='.$item['IATA'].'&LocationLimits%5B0%5D%5Bkey%5D=1&LocationLimits%5B0%5D%5Bvalue%5D=10&Culture='.$lang['lang'].'&IsFlexible=false');
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


            Yii::$app->db->createCommand("insert into airport_parser (airport_id,lang) VALUES (:airport_id,:lang)")
                ->bindValue(':airport_id', $item['id'])
                ->bindValue(':lang', $lang['code'])
                ->query();


            if ($result["CompositeCompleterItem"]["Items"]["0"]["Name"]){
               $exist_airport_names =  Yii::$app->db->createCommand("select * from airport_names where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->query();

                if($exist_airport_names){
                    Yii::$app->db->createCommand("update airport_names set ".$lang['code']."=:param where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["Name"])
                        ->query();
                }else{
                    Yii::$app->db->createCommand("insert into airport_names (id,".$lang['code'].")VALUES (:id,:param)")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["Name"])
                        ->query();
                }
            }


            if ($result["CompositeCompleterItem"]["Items"]["0"]["CountryName"]){
                $exist_countries =  Yii::$app->db->createCommand("select * from countries where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->query();

                if($exist_countries){
                    Yii::$app->db->createCommand("update countries set ".$lang['code']."=:param where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["CountryName"])
                        ->query();
                }else{
                    Yii::$app->db->createCommand("insert into countries (id,".$lang['code'].")VALUES (:id,:param")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["CountryName"])
                        ->query();
                }
            }


            if ($result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"]){
                $exist_cities =  Yii::$app->db->createCommand("select * from cities where id = :id")
                    ->bindValue(':id', $item['id'])
                    ->query();

                if($exist_cities){
                    Yii::$app->db->createCommand("update cities set ".$lang['code']."=:param where id=:id")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"])
                        ->query();
                }else{
                    Yii::$app->db->createCommand("insert into cities (id,".$lang['code'].")VALUES (:id,:param)")
                        ->bindValue(':id', $item['id'])
                        ->bindValue(':param', $result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"])
                        ->query();
                }

            }


            Yii::$app->db->createCommand("update airport_parser set airport_names = :airport_names, countries =:countries, cities =:cities where airport_id = :id")
                ->bindValue(':id', $item['id'])
                ->bindValue(':airport_names', $result["CompositeCompleterItem"]["Items"]["0"]["Name"] )
                ->bindValue(':countries', $result["CompositeCompleterItem"]["Items"]["0"]["CountryName"])
                ->bindValue(':cities', $result["CompositeCompleterItem"]["Items"]["0"]["MainCityName"])
                ->query();

            return true;
        }

        $ddb = Yii::$app->db->createCommand('select * from airport ')->queryAll();


        $langs = [
            '0'  => ['lang' => 'zh-CN', 'code'=>'zh'],// Китайский zh-CN zh       ГОТОВО
            '1'  => ['lang' => 'fr-FR', 'code'=>'fr'],// Французский fr-FR fr     ГОТОВО
            '2'  => ['lang' => 'es-ES', 'code'=>'es'],// Испанский es-ES es       ГОТОВО
            '3'  => ['lang' => 'de-DE', 'code'=>'de'],// Немецкий de-DE de        ГОТОВО
            '4'  => ['lang' => 'pt-PT', 'code'=>'pt'],// Португальский pt-PT pt   ГОТОВО
            '5'  => ['lang' => 'ru-RU', 'code'=>'ru'],// Русский ru-RU ru         ГОТОВО
            '6'  => ['lang' => 'tr-TR', 'code'=>'tr'],// Турецкий tr-TR tr        ГОТОВО
            '7'  => ['lang' => 'it-IT', 'code'=>'it'],// Итальянский it-IT it     ГОТОВО
            '8'  => ['lang' => 'nl-NL', 'code'=>'nl'],// Нидерландский nl-NL nl
        ];


        $i = 0 ;
        foreach ($ddb as $item){
            $i++;
            print_r($i);
            if(go_parse($item, $langs[8]))
            {

            }else{
                print_r('Косячик ='.$item["id"].' ');
            };
        }




    }

}

