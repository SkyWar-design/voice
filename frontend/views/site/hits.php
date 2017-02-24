<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = 'Популярные поздравления';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="hits">
    <h1 class="staled-hr-bottom hits-big">Популярные открытки</h1>
</section>

<form method="get" class="search-form" action="<?=Url::toRoute(['site/category', 'id' => $current_category->id]) ?>">
    <div class="filter">
        <a href="#" class="button-grey filter-type <?=(!isset($request['card_voice']['sex'])?' max-grey':'') ?>" data-filter="all">Показать все</a>
        <?=(isset($request['card_voice']['sex'])?'<input type="hidden" name="card_voice[sex]" value="'.$request['card_voice']['sex'].'">':'') ?>
        <a href="#" class="button-grey filter-type<?=(isset($request['card_voice']['sex']) && $request['card_voice']['sex']==2?' max-grey':'') ?>"  data-filter="card_voice[sex]" data-val="2">Для девушек</a>
        <a href="#" class="button-grey filter-type<?=(isset($request['card_voice']['sex']) && $request['card_voice']['sex']==1?' max-grey':'') ?>" data-filter="card_voice[sex]" data-val="1">Для парней</a>
        <span class="count-card m-l-58">2528 открыток.</span>
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
    'itemView' => 'blocks/cards_hits',
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

