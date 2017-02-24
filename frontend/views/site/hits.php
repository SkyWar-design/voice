<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = 'Популярные поздравления';
$this->params['breadcrumbs'][] = $this->title;

?>

<section id="hits">
    <h1 class="staled-hr-bottom hits-big">Популярные открытки</h1>


    <form method="get" class="search-form" action="<?=Url::toRoute(['site/hits']) ?>">
        <div class="filter">
            <a href="#" class="button-grey filter-type <?=(!isset($request['card_voice']['sex'])?' max-grey':'') ?>" data-filter="all">Показать все</a>
            <?=(isset($request['card_voice']['sex'])?'<input type="hidden" name="card_voice[sex]" value="'.$request['card_voice']['sex'].'">':'') ?>
            <a href="#" class="button-grey filter-type<?=(isset($request['card_voice']['sex']) && $request['card_voice']['sex']==2?' max-grey':'') ?>"  data-filter="card_voice[sex]" data-val="2">Для девушек</a>
            <a href="#" class="button-grey filter-type<?=(isset($request['card_voice']['sex']) && $request['card_voice']['sex']==1?' max-grey':'') ?>" data-filter="card_voice[sex]" data-val="1">Для парней</a>
            <span class="count-card m-l-58"><?=$dataProvider->getTotalCount();?> открыток.</span>
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

</section>