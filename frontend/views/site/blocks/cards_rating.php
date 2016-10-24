<?php
/**
 * Created by PhpStorm.
 * User: SkyWar
 * Date: 18.09.2016
 * Time: 14:38
 */
use yii\helpers\Html;
?>
<div class="jumbotron">
<p>Топ поздравлений<p>
    <div class="row">
        <?php foreach($cards_rating as $cards) { ?>
        <div class="col-xs-6 col-sm-4">
            <div class="card">
                <div class="player">
                        <audio id="player" style="display: none" src="mp3/<?= $cards['mpr3_id'] ?>.mp3" type="audio/mp3" controls="controls"></audio>
                </div>
                <div class="card-info">
                    <p class="name">
                     <a href="/card/<?= Html::encode($cards['id']) ?>"></a>
                    </p>
                </div>
                 <p class="send">
                    <a href="#">отправить</a>
                 </p>
             </div>

         </div>
        <?php } ?>
    </div>

</div>

