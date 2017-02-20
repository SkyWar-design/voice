<?php
use yii\helpers\Url;



$url = $model['id'].'/'.$model['url'];
?>

<div class="player-min-content d-flex-s-b">
    <div class="player-min">
        <audio src="/mp3/<?=$model['mp3_id'] ?>.mp3" class="min"></audio>
        <span class="small-text w-100-p text-center inline">слушать</span>
    </div>
    <div class="card-preview">
        <a href="<?='/card/'.$url ?>" class="card-title m-b-12"><?=$model['card_name'] ? $model['card_name']:'без названия' ?></a>
        <a href="<?='/card/'.$url ?>" class="button-yellow l-h-30">Отправить</a>
    </div>
</div>