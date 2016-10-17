<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-4">
              <div class="logo">
                  <strong>Логотип</strong>
                  <p class="pod_logo">подстрочник</p>
              </div>
            </div>
            <div class="col-xs-6 col-sm-4">
                <center><a href="/"><img src="/image/logo.png" alt="logo"></a></center>
            </div>
            <div class="col-xs-6 col-sm-4">
                <div class="call-me">
                    <div class="smalltext">Бесплатно по России</div>
                    <div class="call-me-phone"><a href="tel:+78005557550" title="Контактный телефон">8 800 555 7 550</a></div>
                    <div class="call-me-link"><a class="dotted popup-js popup-with-form6" title="Заказать обратный звонок" href="#call-me"><i class="fa fa-phone" aria-hidden="true"></i>Позвоните мне!</a></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default',
        ],
    ]);
    $menuItems = [
        ['label' => 'Каталог поздравлений', 'url' => ['site/catalog']],
        ['label' => 'Хиты', 'url' => ['/site/the_best']],
        ['label' => 'Новинки', 'url' => ['/site/contact']],
        ['label' => 'Календарь праздников', 'url' => ['/site/contact']],
        ['label' => 'Смс поздравления', 'url' => ['/site/contact']],
        ['label' => 'Смс поздравления', 'url' => ['/site/contact']],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
