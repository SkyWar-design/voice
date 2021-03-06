<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = $current_category->name;
if( !is_null($current_category->this_id) ){
    $this->params['breadcrumbs'][] = ['label' => $this->context->main_category['name'], 'url' => ['site/category', 'id' => $this->context->main_category['id']]];
}
$this->params['breadcrumbs'][] = $this->title;
$request = Yii::$app->request->get();
?>

<section id="category">
    <h1 class="staled-hr-bottom <?=$this->context->main_category['css_style'] ?>-big"><?=$this->context->main_category['name'] ?></h1>
    <div class="sub-category">
        <?php foreach ( $categories[$this->context->main_category['id']]['subcategories'] as $subcategory_id => $subcategory ): ?>
            <a href="<?=Url::toRoute(['site/category', 'id' => $subcategory_id]) ?>" <?=(preg_match('/category\/'.$subcategory_id.'/', Url::current())?'class="active"':'') ?>><?=$subcategory; ?></a>
        <?php endforeach; ?>
    </div>
    <hr class="yellow-line m-t-30">
    <hr class="grey-line">
    <div class="clear"></div>
    <form method="get" class="search-form" action="<?=Url::toRoute(['site/category', 'id' => $current_category->id]) ?>">
        <div class="filter">
            <a href="#" class="button-grey filter-type <?=(!isset($request['card_voice']['sex'])?' max-grey':'') ?>" data-filter="all">Показать все</a>
            <?=(isset($request['card_voice']['sex'])?'<input type="hidden" name="card_voice[sex]" value="'.$request['card_voice']['sex'].'">':'') ?>
            <a href="#" class="button-grey filter-type<?=(isset($request['card_voice']['sex']) && $request['card_voice']['sex']==2?' max-grey':'') ?>"  data-filter="card_voice[sex]" data-val="2">Для девушек</a>
            <a href="#" class="button-grey filter-type<?=(isset($request['card_voice']['sex']) && $request['card_voice']['sex']==1?' max-grey':'') ?>" data-filter="card_voice[sex]" data-val="1">Для парней</a>
            <span class="count-card m-l-58"><?=$dataProvider->getTotalCount();?> открыток.</span>
            <div class="filter-how m-l-10">
                <span>Сначала:&nbsp;</span>
                <input type="radio" <?=((!isset($request['sort']) || $request['sort'] == 'new')?'checked':'') ?> name="sort" value="new" id="new">
                <label for="new" class="radio filter-type">Новые</label>&nbsp;&nbsp;
                <input type="radio" <?=((isset($request['sort']) && $request['sort'] == 'popular')?'checked':'') ?> name="sort" value="popular" id="popular">
                <label for="popular" class="radio filter-type">Популярные</label>
            </div>
        </div>
    </form>

    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'blocks/cards_category',
        'layout' => "{items}\n{pager}",
        'pager' => [
            'firstPageLabel' => '<i class="fa fa-angle-double-left fa-2" aria-hidden="true"></i>',
            'lastPageLabel' => '<i class="fa fa-angle-double-right fa-2" aria-hidden="true"></i>',
            'nextPageLabel' => '<i class="fa fa-angle-right fa-2" aria-hidden="true"></i>',
            'prevPageLabel' => '<i class="fa fa-angle-left fa-2" aria-hidden="true"></i>',
            'maxButtonCount' => 12,
        ],
    ]);

    ?>

    <hr class="grey-line m-b-20 w-100-p">

    <h2 class="m-t-20">Вам также понравятся</h2>

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

</section>
<?=\common\models\CardVoice::sendSearchFrom(); ?>