<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = $current_category->name;
if( !is_null($current_category->this_id) ){
    $this->params['breadcrumbs'][] = ['label' => $main_category->name, 'url' => ['site/category', 'id' => $main_category->id]];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="category">
    <h1 class="staled-hr-bottom <?=$css_style_categories[$main_category->id] ?>-big"><?=$main_category->name ?></h1>
    <div class="sub-category">
        <?php foreach ( $categories[$main_category->id]['subcategories'] as $subcategory_id => $subcategory ): ?>
            <a href="<?=Url::toRoute(['site/category', 'id' => $subcategory_id]) ?>" <?=(Url::current()=='/category/'.$subcategory_id?'class="active"':'') ?>><?=$subcategory; ?></a>
        <?php endforeach; ?>
    </div>
    <hr class="yellow-line m-t-30">
    <hr class="grey-line">
    <div class="clear"></div>
    <div class="filter">
        <a href="#" class="button-grey max-grey">Показать все</a>
        <a href="#" class="button-grey">Для девушек</a>
        <a href="#" class="button-grey">Для парней</a>
        <span class="count-card m-l-58">2528 открыток.</span>
        <div class="filter-how m-l-10">
            <span>Сначала:&nbsp;</span>
            <input type="radio" checked name="how" value="1" id="new">
            <label for="new" class="radio">Новые</label>&nbsp;&nbsp;
            <input type="radio" name="how" value="2" id="popular">
            <label for="popular" class="radio">Популярные</label>
        </div>
    </div>

    <h2 class="m-t-20">Тем кто родился сегодня, 12 октября</h2>

    <div class="mobile-centered">
        <div class="row-content d-flex-s-b m-b-30">

            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text study" href="#">С Днем Рождения</a>
            </div>

            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text profession" href="#">С Днем Рождения</a>
            </div>

            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text mar" href="#">С Днем Рождения</a>
            </div>

        </div>
    </div>
    <hr class="grey-line m-b-20 w-100-p">

    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_category_card',
        'layout' => "{items}\n{pager}",
    ]);

    ?>


</section>
