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
$model = new Category();
$array_category = $model->getDropName();
$this->title = 'Заполнение карточек';

?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Заполнение карточки #<?=$card_array['card_voice_id'] ?></h2>
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
        <div class="x_content">
            <br />
            <form  id="demo-form2" class="form-horizontal form-label-left" novalidate>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">URL <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="url" name="card_edit[url]" data-validate-lengthRange="6" data-validate-words="2" required="required" value="<?=$card_array['url'] ?>"placeholder="Url для страницы, на латыни, пример: c_dnem_rojdenia" class="form-control col-md-7 col-xs-12">
                        <input type="text" id="last-name" name="card_edit[id]" required="required" value="<?=$card_array['card_voice_id'] ?>" style="display: none">
                    </div>
                    <div class='tooltip help'>
                        <span>?</span>
                        <div class='content'>
                            <b></b>
                            <p>Необходимо заполнить url</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">MP3 ID<span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <input type="text" id="last-name" name="card_edit[mp3_id]"  required="required" value="<?=$card_array['mp3_id'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <audio id="player"  src="<?php echo Yii::getAlias('@mp3') ?>/<?=$card_array['mp3_id'] ?>.mp3" type="audio/mp3" ></audio>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description страницы<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_description]" required="required" rows="7" ><?=$card_array['voice_description'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Keywords страницы<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_keywords]" required="required" rows="5" ><?=$card_array['voice_keywords'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title страницы<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_title]" rows="4" ><?=$card_array['voice_title'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">H1 страницы<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control"  name="card_edit[voice_text_h1]" rows="3" ><?=$card_array['voice_text_h1'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Текст карточки<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_description]" rows="7" ><?=$card_array['voice_text_description'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Тематика карточки<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_theme]" rows="3" ><?=$card_array['voice_text_theme'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Тэги карточки<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[voice_text_tags]" rows="3" ><?=$card_array['voice_text_tags'] ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Пол</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="card_edit[sex}">
                            <option value="1" <?php echo $card_array['sex']  == 1 ? 'selected': '' ?> >Для мужчины</option>
                            <option value="2" <?php echo $card_array['sex']  == 2 ? 'selected': '' ?> >Для женщины</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Категория</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="card_edit[category}">
                            <?php foreach ($array_category as $category){?>
                            <option value="<?=$category['id'] ?>" <?php echo $category['name'] == $card_array['name'] ? 'selected': '' ?> ><?=$category['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Дата события<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="birthday" name="card_edit[date]" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" id="send_form" class="btn btn-primary btn-lg">Сохранить и загрузить следующую</button>
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
        $('#send_form').click(function (){
            var data = $('#demo-form2').serializeArray();
            var date = $('#birthday').val();
            var url = $('#url').val();
            if(date == ''){
                new PNotify({
                    title: 'Ошибка',
                    text: 'Не заполнено поле Даты',
                    type: 'error',
                    styling: 'bootstrap3'
                });
                return false;
            }
            if(url == ''){
                new PNotify({
                    title: 'Ошибка',
                    text: 'Не заполнено поле URL',
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