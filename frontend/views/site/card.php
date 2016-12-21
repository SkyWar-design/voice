<?php
$this->title = 'Название карточки';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="card">
    <h1 class="staled-hr-bottom">Путин поздравляет с днем рождения</h1>
    <div class="player-big d-menu">
        <audio src="/mp3/test.mp3" class="big"></audio>
    </div>


    <div class="player-min-content d-flex-s-b m-menu mobile-preview">
        <div class="player-min">
            <audio src="/mp3/test.mp3" class="min"></audio>
            <span class="small-text w-100-p text-center inline">слушать</span>
        </div>
        <div class="card-preview">
            <a href="/site/card" class="card-title m-b-12">2 октября - С днем рождения!</a>
            <a href="/site/card" class="button-yellow l-h-30">Отправить</a>
        </div>
        <a class="link-to-category small-text study" href="#">С Днем Рождения</a>
    </div>

    <div class="d-flex-s-b m-t-40 space-around">
        <div class="description-card">
            <h2 class="m-b-20">Текст открытки</h2>
            <p class="m-b-40">Здравствуйте, это Владимир Путин. Меня убедительно попросил... очень достойный человек Вам позвонить. Я отказать не смог, хотя конечно очень занят. Поздравляю Вас с днем рождения, от души! А в подарок от меня - жёлтая Лада Калина и второй ЙотаФон. Курьер Вам доставит... Хочу предложить вам отправиться со мной полетать со стерхами, на дельтаплане. Стерхи - красивые ребята. Почувствуете себя в роли вожака. В воздухе адреналин гуляет, чувство приятное! Я распоряжусь, вам выдадут пилотское свидетельство... Или давайте понаблюдаем за амурскими тиграми, проведем время наедине... с тайгой. Мне кажется это очень романтично - побыть в день рождения вдали от цивилизации. Можем еще позаниматься дзюдо. Научу коронным приемам и присвою вам восьмой дан... Сегодня я прерву свой напряженный рабочий график, специально для Вас. Пусть всё невозможное становится возможным! Желаю сбываться всем вашим мечтам, идеям и планам! Удачи.</p>
            <div class="title-description">Тема открытки:</div>
            <div class="category-description m-b-40">
                <a href="#">Поздравления с днем рождения от знаменитостей</a>,
                <a href="#">Прикольные поздравления с днем рождения</a>
            </div>
            <div class="title-description">Теги:</div>
            <div class="tags d-flex-s-b">
                <a href="#" class="button-grey">Для девушек</a>
                <a href="#" class="button-grey">Для девушек</a>
                <a href="#" class="button-grey">Для девушек</a>
                <a href="#" class="button-grey">Для девушек</a>
            </div>
        </div>

        <div class="order-card">
            <h2 class="m-b-20">Отправить открытку</h2>
            <p class="m-b-20">Введите номер городского или мобильного телефона и нажмите кнопку «Отправить».</p>
            <p class="m-b-20">Получателю поступит звонок с озвученным текстом данной открытки.</p>
            <div class="form-row m-b-20">
                <label class="title-description">Телефон получателя:</label>
                <input name="phone" type="text" class="tel" placeholder="+7">
                <div class="info-text">Пример заполнения: +7XXXXXXXXXX</div>
            </div>
            <div class="form-row m-b-20">
                <label class="title-description m-b-10">Доставить открытку:</label>
                <input type="radio" checked name="time" value="1" id="now">
                <label for="now" class="radio">Сейчас</label>
                <input type="radio" name="time" value="2" id="set-time">
                <label for="set-time" class="radio m-l-30">В указанное время</label>
            </div>
            <div class="form-row m-b-20">
                <input type="checkbox" checked name="email_send" value="1" id="email-send">
                <label for="email-send" class="checkbox">Сообщить мне о доставке!</label>
                <input type="email" name="email" placeholder="Ваш e-mail">
                <div class="info-text">Укажите свой email чтобы получить уведомление о доставке открытки</div>
            </div>
            <div class="form-submit">
                <input type="submit" class="button-yellow" value="Отправить на телефон">
            </div>
        </div>
    </div>

    <h2 class="m-b-20 m-t-20">Вам также понравятся</h2>
    <hr class="yellow-line">

    <div class="mobile-centered">
        <div class="row-content d-flex-s-b m-b-30">

            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="/site/card" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="/site/card" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text study" href="#">С Днем Рождения</a>
            </div>

            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text profession" href="#">С Днем Рождения</a>
            </div>

            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text mar" href="#">С Днем Рождения</a>
            </div>
            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text feb" href="#">С Днем Рождения</a>
            </div>
            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text svd" href="#">С Днем Рождения</a>
            </div>
            <div class="player-min-content d-flex-s-b">
                <div class="player-min">
                    <audio src="/mp3/test.mp3" class="min"></audio>
                    <span class="small-text w-100-p text-center inline">слушать</span>
                </div>
                <div class="card-preview">
                    <a href="#" class="card-title m-b-12">2 октября - С днем рождения!</a>
                    <a href="#" class="button-yellow l-h-30">Отправить</a>
                </div>
                <a class="link-to-category small-text new" href="#">С Днем Рождения</a>
            </div>

        </div>
    </div>

    <hr class="grey-line m-b-20">

</section>

<script>
    $(document).ready(function () {
        $('audio.big').mediaelementplayer({
            audioWidth: 712,
            audioHeight: 92,
            startVolume: 1,
            enableAutosize: false,
            features: ['playpause','progress','current','duration','tracks','volume']
        });
        $('.tel').mask('+70000000000');
    })
</script>
