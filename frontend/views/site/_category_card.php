<?php
use yii\helpers\Url;
?>
<div class="player-min-content d-flex-s-b">
    <div class="player-min">
        <audio src="/mp3/test.mp3" class="min"></audio>
        <span class="small-text w-100-p text-center inline">слушать</span>
    </div>
    <div class="card-preview">
        <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
        <a href="#" class="button-yellow l-h-30">Отправить</a>
    </div>
    <a class="link-to-category small-text <?=$this->context->main_category['css_style'] ?>" href="<?=Url::toRoute(['site/category', 'id' => $this->context->main_category['id']]) ?>"><?=$this->context->main_category['name'] ?></a>
</div>