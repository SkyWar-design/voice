<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;
use frontend\assets\AppAsset;

AppAsset::register($this);

$categories = $this->context->categories;
$css_style_categories = $this->params['css_style_categories'];
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
    <header>
        <div class="container">
            <a href="<?=Url::toRoute('site/index') ?>" class="logo">
                <span class="logo-img"></span>
                <div class="inline">
                    <span class="title">Название</span>
                    <span class="under-title">Голосовые открытки</span>
                </div>
            </a>
            <br class="h-br">
            <div class="header-inform-block">
                <div class="social-buttons inline v-top p-hidden">
                    <a href="#" class="social facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#" class="social facebook"><i class="fa fa-vk" aria-hidden="true"></i></a>
                    <a href="#" class="social twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#" class="social odnoklassniki"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
                </div>
                <div class="header-date inline v-top m-hidden p-b-hidden">2 ноября 2016</div>
                <div class="about">
                    <?=Menu::widget([
                        'items' => [
                            ['label' => 'О проекте', 'url' => ['site/index']],
                            ['label' => 'Блог', 'url' => ['/site/blog']],
                            ['label' => 'Личный кабинет', 'url' => ['site/login']],
                        ],
                    ]); ?>
                </div>
                <form action="/" method="get" class="header-search-form">
                    <input type="text" placeholder="Поиск по сайту..." name="search">
                    <button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <br class="h-br">
            <div class="header-contact">
                <div>Служба поддержки:</div>
                <div>8 800-554-55-43</div>
                <a href="#" class="link">suport@site.ru</a>
            </div>

        </div>

    </header>

    <nav class="header-menu">
        <?=Menu::widget([
            'items' => [
                ['label' => 'Каталог поздравлений', 'url' => ['site/catalog']],
                ['label' => 'ХИТЫ', 'url' => ['product/index']],
                ['label' => 'Новинки', 'url' => ['site/login']],
                ['label' => 'Календарь праздников', 'url' => ['site/calendar']],
                ['label' => 'СМС поздравления', 'url' => ['site/login']],
            ],
        ]); ?>
    </nav>

    <section>
        <div class="container d-flex m-b-25">
            <?=Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);?>
        </div>
        <div class="container d-flex-s-b p-b-60 main-content space-around">

            <div class="left-content">
                <?= $content ?>
            </div>
            <div class="right-content">
                <nav class="right-menu">
                    <h4>Голосовые открытки по темам</h4>
                    <hr class="grey-line">
                    <div class="category-menu">

                        <?php foreach ( $categories as $main_category_id => $category_subcategory ): //add class active to category-row ?>
                            <div class="category-row">
                                <div class="category-title">
                                    <span class="category-icon-min" id="<?=$css_style_categories[$main_category_id] ?>"></span>
                                    <span><?=$category_subcategory['name_category'] ?></span>
                                    <span class="arrow"></span>
                                </div>
                                <ul>
                                    <?php foreach ( $category_subcategory['subcategories'] as $subcategories_id => $subcategories ): ?>
                                        <li><a href="<?=Url::toRoute('site/category/'.$subcategories_id) ?>"><?=$subcategories ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="category-row">
                            <div class="category-title">
                                <span class="category-icon-min" id="celebration"></span>
                                <span>С днем рождения</span>
                                <span class="arrow"></span>
                            </div>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </section>
<div class="clear"></div>
<footer>
    <div class="container d-flex-s-b p-b-20">
        <div class="footer-row">
            <a href="<?=Url::toRoute('site/index') ?>" class="logo">
                <span class="logo-img"></span>
                <div class="inline">
                    <span class="title">Название</span>
                    <span class="under-title">Голосовые открытки</span>
                </div>
            </a>
            <ul class="d-menu">
                <li><a href="">Информация о стоимости услуг</a></li>
                <li><a href="">Информация о стоимости услуг</a></li>
                <li><a href="">Информация о стоимости услуг</a></li>
            </ul>
        </div>

        <div class="footer-row">
            <div class="title-row">Название блока</div>
            <ul>
                <li><a href="">Информация о стоимости услуг</a></li>
                <li><a href="">Информация о стоимости услуг</a></li>
                <li><a href="">Информация о стоимости услуг</a></li>
            </ul>
        </div>

        <div class="footer-row">
            <div class="title-row">Название блока</div>
            <ul>
                <li><a href="">Информация о стоимости услуг</a></li>
                <li><a href="">Информация о стоимости услуг</a></li>
                <li><a href="">Информация о стоимости услуг</a></li>
            </ul>
        </div>

        <div class="footer-row">
            <div class="footer-contact">
                <div>Служба поддержки:</div>
                <div>8 800-554-55-43</div>
                <a href="#" class="link">suport@site.ru</a>
            </div>
            <div class="social-buttons">
                <a href="#" class="social facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#" class="social facebook"><i class="fa fa-vk" aria-hidden="true"></i></a>
                <a href="#" class="social twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#" class="social odnoklassniki"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
            </div>
        </div>

    </div>
    <div class="end-footer">
        <div class="container d-flex-s-b">
            <div class="copy-title">&copy;&nbsp;Название <?= date('Y') ?></div>
            <div class="payment-row">
                <div class="copy-title inline m-r-10">Мы принимаем:</div>
                <div class="payment"></div>
            </div>
        </div>
    </div>
<!--        --><?//= date('Y') ?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
