<?php
use \yii\widgets\ListView;

$this->title = 'Поиск по тегам';

?>

<h1>Вы искали "<?=$search ?>"</h1>

<section id="category">

    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'blocks/tags_cloud',
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
