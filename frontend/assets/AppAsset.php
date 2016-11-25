<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $css = [
        'css/reset.min.css',
        'css/main.css',
        'css/font-awesome.min.css'
//        'css/mediaelementplayer.css',

    ];
    public $js = [

    ];
    //приоритет закгрузки js скриптов в yii
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset'
    ];

}
