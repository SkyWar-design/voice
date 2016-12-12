<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;

/**
 * Test controller
 */
class RunController extends Controller {

    public function actionIndex() {
        $ddb = Yii::$app->BD->createCommand('select * from airport limit 9')->queryAll();

        var_dump($ddb);
    }

}

