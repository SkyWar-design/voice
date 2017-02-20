<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

require(__DIR__.  '/../../vendor/parser/simple_html_dom.php');

/**
 * Test controller
 */
class RunController extends Controller {

    public function actionStart()
    {
        $i=1;
        while($i <= 12){
            self::actionTest($i);
            $i++;
        }


    }
    public function actionTest($i)
    {
        $html = file_get_html('http://www.calend.ru/names/'.$i.'/');
//        $fp = ('file5.csv');

        foreach($html->find('.holidayweek') as $e){

            foreach($e->find('tr') as $li) {
                $name= '';

                foreach($li->find('td[width="127"] a') as $lr) {
                    $name_month = $lr->plaintext;
                    echo $lr->plaintext.' ' ;
                }

                foreach($li->find('td ul li a') as $lr) {
                    $name .= $lr->plaintext.', ';
                    echo $lr->plaintext.' ' ;
                }

                Yii::$app->db->createCommand('insert into party (party.name, month_full, party.month)  VALUES (:name,:month_full,:month) ')
                    ->bindValue(':name', $name)
                    ->bindValue(':month_full', $name_month)
                    ->bindValue(':month', $i)
                    ->execute();

            }

        }



    }
}

