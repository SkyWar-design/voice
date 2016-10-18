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
/* @var $dataProvider */

//для выгрузки
use app\common\GridViewEditable;
use yii\helpers\html;
use yii\helpers\ArrayHelper;
use common\models\CardVoice;
use common\models\Category;
use yii\helpers\VarDumper;
use common\models\Page;
use kartik\export\ExportMenu;
$this->title = 'Страницы';

?>
<div class="col-md-12 col-xs-12">
    <div id="w0" class="x_panel">
        <div class="x_content">
            <div class="x_title"><h2>Фильтры</h2><div class="clearfix"></div></div>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default radio_filtr <?php if (empty($filter) or $filter==3){ echo 'active';} ?>" id="3">
                    <input type="radio" name="options3" > Все страницы
                </label>
                <label class="btn btn-default radio_filtr <?php if ($filter == 1){ echo 'active';} ?>" id="1">
                    <input  type="radio" name="options" > Активные
                </label>
                <label class="btn btn-default radio_filtr <?php if ($filter == 2){ echo 'active';} ?>"  id="2">
                    <input type="radio" name="options"> Неактивные
                </label>
            </div>
            <div class="btn-group" data-toggle="buttons">
                <?php $gridColumns = [
                    'id','description','keywords','title','text_h1','card_id'
                ];
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns
                ]); ?>
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
            'pager' => [
                'firstPageLabel' => 'Первая страница',
                'lastPageLabel'  => 'Последняя страница'
            ],
            'columns' => [
                'id',
                'description',
                'keywords',
                'title',
                'text_h1',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Статус страницы',
                    'template' => '{link}',
                    'buttons' => [
                        'link' => function ($url,$model,$key) {
                            return Html::activeDropDownList($model, 'status', $model->DropStatus,['class'=>'status_'.$model->id]);
                        },

                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Карточка',
                    'template' => '{link}',
                    'buttons' => [
                        'link' => function ($url,$model,$key) {
                            return Html::a('Карточка #'.$model->card_id, 'edit_card?card_edit'.$model->card_id, $options = ['id' => 'url_link']);
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
            goPage('edit_page?page_edit='+id);
        });

        $('.radio_filtr').click(function (e) {
            var id = $(this).attr("id");
            var category = $("#category").val();
            goPage('pages?filter='+id);
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
//                    var value_status = $("#cardvoice-status.status_"+val).val();
//                    item.splice(5,1,value_status);
                    console.log(item);
                    $.ajax({
                        type: "POST",
                        url: "/update_page",
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

                if (elm_name == 'textarea' || elm_name == 'button') {
                    return false;
                }
                console.log(elm_name);
                var val = $(this).html();
                console.log(val);
                if( val.indexOf("span") != -1 || val.indexOf("button") != -1 || val.indexOf("select") != -1){
                    return false;
                }
                if(val.indexOf("a") != -1){
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