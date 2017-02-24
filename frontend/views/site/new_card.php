<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = 'Новинки';
$this->params['breadcrumbs'][] = $this->title;
$request = Yii::$app->request->get();
?>

<section id="hits">
    <h1 class="staled-hr-bottom new-card-big"><?=$this->title ?></h1>

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
