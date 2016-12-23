<?php
use yii\helpers\Url;
?>
<div class="player-min-content d-flex-s-b">
    <div class="player-min">
        <audio src="/mp3/<?=$model->mp3_id ?>" class="min"></audio>
        <span class="small-text w-100-p text-center inline">слушать</span>
    </div>
    <div class="card-preview">
        <a href="<?=Url::toRoute(['site/card', 'id' => $model->id]) ?>" class="card-title m-b-12">А куда делись названия?)</a>
        <a href="<?=Url::toRoute(['site/card', 'id' => $model->id]) ?>" class="button-yellow l-h-30">Отправить</a>
    </div>
    <a class="link-to-category small-text <?=$this->context->main_category['css_style'] ?>" href="<?=Url::toRoute(['site/category', 'id' => $this->context->main_category['id']]) ?>"><?=$this->context->main_category['name'] ?></a>
</div>