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
            <h2>Добавление новой страницы></h2>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Card ID<span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <input type="text" id="last-name" name="card_edit[card_id]"  value="" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">URL<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" id="last-name" name="card_edit[url]"  value="" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[description]" rows="7" ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Keywords<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[keywords]" rows="3" ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[title]" rows="3" ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">H1<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="card_edit[text_h1]" rows="3" ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Статус</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="card_edit[status}">
                            <option value="1">Активна</option>
                            <option value="0">Неактивна</option>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
                        <button type="submit" id="send_form" class="btn btn-primary">Добавить</button>
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
            $.ajax({
                type: "POST",
                url: "/add_page",
                context: document.body,
                data: { csrf_backend: token, page_array: data },
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