<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = 'Популярные поздравления';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="hits">
    <h1 class="staled-hr-bottom hits-big">Популярные открытки</h1>
</section>

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

