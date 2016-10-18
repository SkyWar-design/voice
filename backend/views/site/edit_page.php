<?php
/**
 * Created by PhpStorm.
 * User: SkyWar
 * Date: 15.10.2016
 * Time: 15:42
 * @var $card_array $model
 */

/* @var $this yii\web\View */


use yii\helpers\ArrayHelper;
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$array_category = Category::getDropName();
$this->title = 'Заполнение карточек';

?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Заполнение страницы #<?=$card_array['id'] ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        id: 10
        card_id: 11
        url: http://www.voicecards.ru/item/den-zaschitnika-otechestva/lyubimomu/6907.html
        description: Пусть в страхе разбежится враг! - песня, Любимому, Портал голосовых открыток Voicecards предлагает большой выбор голосовых поздравлений на любой вкус и по любому поводу. Ваш подарок будет доставлен в виде звонка на телефон. Услуга действует с оплатой по смс. Всем, кто хочет удивить прикольным поздравлением- советую: http://www.voicecards.ru. Огромная коллекция голосовых поздравлений и розыгрышей на телефон.
        keywords: Пусть в страхе разбежится враг! - песня, Любимому, смс поздравления, голосовые поздравления, голосовые открытки
        title: Пусть в страхе разбежится враг! - песня - Любимому - VoiceCards.ru
        text_h1: Музыкальная открытка "Пусть в страхе разбежится враг! - песня"
        status: 0

        <div class="x_content">
            <br />
            <form  id="demo-form2" class="form-horizontal form-label-left" novalidate>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Card ID<span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <input type="text"  name="card_edit[id]" style="display: none"  value="<?=$card_array['id'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                        <input type="text" id="last-name" name="card_edit[mp3_id]"  value="<?=$card_array['card_id'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <a class="btn btn-default" href="/edit_card?card_edit=<?=$card_array['card_id'] ?>" role="button">Link</a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">URL<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" id="last-name" name="card_edit[mp3_id]"  value="<?=$card_array['url'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_description]" rows="7" ><?=$card_array['description'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Keywords<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_theme]" rows="3" ><?=$card_array['keywords'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_tags]" rows="3" ><?=$card_array['title'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">H1<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_tags]" rows="3" ><?=$card_array['text_h1'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Статус</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="card_edit[status}">
                            <option value="1" <?php echo $card_array['status']  == 1 ? 'selected': '' ?> >Активна</option>
                            <option value="0" <?php echo $card_array['status']  == 0 ? 'selected': '' ?> >Неактивна</option>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
                        <button type="submit" id="send_form" class="btn btn-primary">Сохранить и загрузить следующую</button>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-3">
                        <button type="submit" id="del_form" class="btn btn-danger">Удалить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        var token = $('meta[name=csrf-token]').attr("content");

        $('#demo-form2').click(function (){
            return false;
        });
        function goPage(url) {
            document.location.href = url;
            return false;
        }
        $('#del_form').click(function (){
            var data = $('#demo-form2').serializeArray();
            $.ajax({
                type: "POST",
                url: "/del_card",
                context: document.body,
                data: { csrf_backend: token, card_array: data },
                success: function(otvet){
                    otvet = JSON.parse(otvet);
                    if (otvet.status =="success"){
                        new PNotify({
                            title: 'Сохранение',
                            text: 'Карточка #'+otvet.id+' успешно удалена. Переадресация...',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        setTimeout(function(){goPage('edit_card')}, 2400);
                    }else{
                        console.log(otvet);
                        new PNotify({
                            title: 'Сохранение',
                            text: 'Не удалось удалить карточку #'+otvet.id+' '+otvet.message,
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                }
            });

        });
        $('#send_form').click(function (){
            var data = $('#demo-form2').serializeArray();
            var date = $('#birthday').val();
            if(data.length < 5 ){
                new PNotify({
                    title: 'Ошибка',
                    text: 'Не заполнено все необходимые поля',
                    type: 'error',
                    styling: 'bootstrap3'
                });
                return false;
            }
            $.ajax({
                type: "POST",
                url: "/edit_card",
                context: document.body,
                data: { csrf_backend: token, card_array: data },
                success: function(otvet){
                    otvet = JSON.parse(otvet);
                    if (otvet.status =="success"){
                        new PNotify({
                            title: 'Сохранение',
                            text: 'Карточка #'+otvet.id+' успешно сохранена. Переадресация...',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        setTimeout(function(){goPage('edit_card')}, 2400);
                    }else{
                        console.log(otvet);
                        new PNotify({
                            title: 'Сохранение',
                            text: 'Не удалось сохранить карточку #'+otvet.id+' '+otvet.message,
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                }
            });

        });
        $('#birthday').daterangepicker({
            changeYear: false,
            dateFormat: 'dd/mm',
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>