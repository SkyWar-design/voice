<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$this->registerJsFile('js/mediaelement-and-player.js');


?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-8">
                <h1>Голосовые поздравления</h1>
                <p>Любому человеку приятно будет получить в подарок голосовое поздравление с днем рождения,
                    или поздравление голосом известного человека.<br>
                    Попробуйте разыграть своего друга или подругу, отправив обращение президента...</p>
                <!-- карточки по рейтингу -->
                <?= $this->render( 'blocks/cards_rating',['cards_rating'=>$cards_rating]); ?>
                <h1>Голосовые открытки</h1>
                <p>Любому человеку приятно будет получить в подарок голосовое поздравление с днем рождения,
                    или поздравление голосом известного человека.<br>
                    Попробуйте разыграть своего друга или подругу, отправив обращение президента...</p>

            </div>
            <div class="col-lg-4">
                <!-- карточки по темам -->
                <?= $this->render( 'blocks/cards_themes' ); ?>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        $('audio').mediaelementplayer({
            defaultAudioWidth: 61,
            defaultAudioHeight: 65
        });
//        var player = new MediaElementPlayer('#player');
//
//        $('.btn-success').click(function(){
//            player.play();
//        });
//        $('.btn-danger').click(function(){
//            player.pause();
//        });
    });
</script>