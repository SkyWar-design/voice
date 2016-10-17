<?php
/**
 * Created by PhpStorm.
 * User: SkyWar
 * Date: 15.10.2016
 * Time: 15:42
 */

/* @var $this yii\web\View */
/* @var $filter */
/* @var $filter_category */

use app\common\GridViewEditable;
use yii\helpers\html;
use yii\helpers\ArrayHelper;
use common\models\CardVoice;
use common\models\Category;
use yii\helpers\VarDumper;

$this->title = 'Карточки';
$array_category = Category::getDropName();
array_unshift($array_category, ['id' => '0', 'name' => "Не выбрано"] );

?>
<div class="col-md-12 col-xs-12">
    <div id="w0" class="x_panel">
        <div class="x_content">
            <div class="x_title"><h2>Фильтры</h2><div class="clearfix"></div></div>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default radio_filtr <?php if (empty($filter) or $filter==3){ echo 'active';} ?>" id="3">
                    <input type="radio" name="options3" > Все карточки
                </label>
                <label class="btn btn-default radio_filtr <?php if ($filter == 1){ echo 'active';} ?>" id="1">
                    <input  type="radio" name="options" > Активные
                </label>
                <label class="btn btn-default radio_filtr <?php if ($filter == 2){ echo 'active';} ?>"  id="2">
                    <input type="radio" name="options"> Неактивные
                </label>
            </div>
            <div class="btn-group" data-toggle="buttons">
                <select class="form-control" id ="category" name="card_edit[category}">
                    <?php foreach ($array_category as $category){?>
                        <option value="<?=$category['id'] ?>" <?=$filter_category == $category['id'] ? 'selected': '' ?> ><?=$category['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<?=
\yiister\gentelella\widgets\grid\GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'hover' => true,
        'columns' => [
            'id',
            'voice_title',
            'voice_text_h1',
            'voice_text_description',
            'voice_text_theme',
            'category.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Пол',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::activeDropDownList($model, 'sex', $model->DropSex,['class'=>'sex_'.$model->id]);
                    },

                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Статус карточки',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::activeDropDownList($model, 'status', $model->DropStatus,['class'=>'status_'.$model->id]);
                    },

                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия',
                'template' => '{update}{link}',
                'buttons' => [
                    'update' => function ($url,$model,$key) {
                        return Html::button($content = 'Редактировать', $options = ['class' => 'btn btn-info edit_button','value_id' => $model->id]);
                    },
                    'link' => function ($url,$model,$key) {
                        return Html::button($content = 'Сохранить', $options = ['class' => 'save_card btn btn-success','value_id' => $model->id]);
                    },

                ],
            ],
        ],
    ]
);

?>
</div>
<script>
    $(document).ready(function() {
        var token = $('meta[name=csrf-token]').attr("content");

        $('.edit_button').click(function (e) {
            var id = $(this).attr("value_id");
            goPage('edit_card?card_edit='+id);
        });

        $('.radio_filtr').click(function (e) {
            console.log('123');
            var id = $(this).attr("id");
            var category = $("#category").val();
            goPage('cards?filter='+id);
        });

        $("#category").change(function (e) {
            var id = $(".radio_filtr.active").attr("id");
            var category = $(this).val();
            goPage('cards?filter='+id+'&category='+category);
        });

        function goPage(url) {
            document.location.href = url;
            return false;
        }

        $('.save_card').click(function (e) {
            val = $(this).attr("value_id");
            console.log('sa');
            var myTableArray = [];

            $("tbody tr").each(function() {
                var arrayOfThisRow = [];
                var tableData = $(this).find('td');
                if (tableData.length > 0) {
                    tableData.each(function() {
                        console.log($(this).text());
                        arrayOfThisRow.push($(this).text());
                    });
                    myTableArray.push(arrayOfThisRow);
                }
            });

            myTableArray.forEach(function(item, i, arr) {
                if(item[0] == val){
                //замена элементов массива
                    var value_sex = $("#cardvoice-sex.sex_"+val).val();
//                    item.splice(5,1,value_sex);
                    var value_status = $("#cardvoice-status.status_"+val).val();
//                    item.splice(6,1,value_status);
                    $.ajax({
                        type: "POST",
                        url: "/update",
                        context: document.body,
                        data: { csrf_backend: token, card_array: item },
                        success: function(otvet){
                            otvet = JSON.parse(otvet);
                            if (otvet.status =="success"){
                                console.log(otvet);
                                new PNotify({
                                    title: 'Сохранение',
                                    text: 'Карточка #'+otvet.id+' успешно сохранена',
                                    type: 'success',
                                    styling: 'bootstrap3'
                                });
                            }else{
                                console.log(otvet);
                                new PNotify({
                                    title: 'Сохранение',
                                    text: 'Не удалось сохранить карточку #'+otvet.id,
                                    type: 'error',
                                    styling: 'bootstrap3'
                                });
                            }
                        }
                    });
                }
            });
        });

        $(function () {
            $('td').click(function (e) {
                //ловим элемент, по которому кликнули
                var t = e.target || e.srcElement;

                //получаем название тега
                var elm_name = t.tagName.toLowerCase();
                //если это инпут - ничего не делаем

                if (elm_name == 'textarea' || elm_name == 'button'|| elm_name=='a') {
                    return false;
                }
                console.log(elm_name);
                var val = $(this).html();
                console.log(val);
                if( val.indexOf("span") != -1 || val.indexOf("button") != -1 || val.indexOf("select") != -1){
                    return false;
                }
                var code = '<textarea  id="edit" style="width: 400px" rows="15" cols="5" name="text">'+val+'</textarea>';
                $(this).empty().append(code);
                $('#edit').focus();
                $('#edit').blur(function () {
                    var val = $(this).val();
                    $(this).parent().empty().html(val);
                });
            });
        });
        $(window).keydown(function (event) {
            //ловим событие нажатия клавиши
            if (event.keyCode == 13) {	//если это Enter
                $('#edit').blur();	//снимаем фокус с поля ввода
            }
        });
    });
</script>