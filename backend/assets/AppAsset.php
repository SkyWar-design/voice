<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/notify.buttons.css',
        'css/notify.css',
        'css/site.css',
    ];

    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $js = [
        'js/fastclick.js',
        'js/nprogress.js',
        'js/Chart.min.js',
        'js/jquery.sparkline.min.js',
        'js/raphael.min.js',
        'js/morris.min.js',
        'js/gauge.min.js',
        'js/bootstrap-progressbar.min.js',
        'js/skycons.js',
        'js/jquery.flot.js',
        'js/jquery.flot.pie.js',
        'js/jquery.flot.time.js',
        'js/jquery.flot.stack.js',
        'js/jquery.flot.resize.js',
        'js/jquery.flot.orderBars.js',
        'js/jquery.flot.spline.min.js',
        'js/curvedLines.js',
        'js/date.js',
        'js/moment.min.js',
        'js/daterangepicker.js',
        'js/pnotify.js',
        'js/pnotify.buttons.js',
        'js/validator.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
