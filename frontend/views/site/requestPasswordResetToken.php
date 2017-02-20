<?php
use yii\helpers\Url;
use \yii\widgets\ListView;

$this->title = 'Поиск по Имени';

?>

<section id="category">

    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'blocks/name_cloud',
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
