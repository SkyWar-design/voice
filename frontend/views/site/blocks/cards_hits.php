<?php
use yii\helpers\Url;
$url = $model->page->id.'/'.$model->page->url;

$css_style_categories = Yii::$app->params['css_style_categories'];

$main_category = $model->mainCategory;

var_dump($main_category);

?>
<div class="player-min-content d-flex-s-b">
    <div class="player-min">
        <audio src="/mp3/<?=$model->mp3_id ?>.mp3" class="min"></audio>
        <span class="small-text w-100-p text-center inline">слушать</span>
    </div>
    <div class="card-preview">
        <a href="<?='/card/'.$url ?>" class="card-title m-b-12"><?=$model->page->card_name ? $model->page->card_name:'без названия' ?></a>
        <a href="<?='/card/'.$url ?>" class="button-yellow l-h-30">Отправить</a>
    </div>
<!--    <a class="link-to-category small-text --><?//=$css_style_categories[$main_category['id']] ?><!--" href="--><?//=Url::toRoute(['site/category', 'id' => $main_category['id']]) ?><!--">--><?//=$main_category['name'] ?><!--</a>-->
</div>