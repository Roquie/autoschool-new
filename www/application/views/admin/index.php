<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::style('global/css/datepicker.css')?>
<?=HTML::script('adm/js/listener.js')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>

<div class="container">
    <div class="row">

        <div class="span4">
            <h1><small>Слушатели</small></h1>
        </div>

        <div class="span8 btn_actions">
            <a href="<?=URL::site('/admin/createdocs')?>" class="btn btn-warning pull-right" data-placement="bottom" rel="tooltip" title="Добавить слушателя (или создать документы без добавления данных в БД)">Добавить</a>
            <a href="<?=URL::site('/admin/listeners/distrib')?>" class="btn btn-success pull-right" data-placement="bottom" rel="tooltip" title="Распределение слушателей подавших заявку по группам">Подавшие заявку</a>
        </div>

    </div>

    <div class="row">

        <div class="span3">
            <div class="well l_select_group">
                <h5 class="header_block">Номер группы</h5>
                <label for="">Выберите:</label>
                <select name="select2" id="selected2" data-url="<?=URL::site('admin/users_by_group')?>">
                    <option value="0" selected="selected">Все ...</option>
                    <?foreach($list_groups as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>
            </div>
            <div class="well l_fio">
                <h5 class="header_block">Фамилия И.О.</h5>
                <input type="hidden" id="user_id"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="wrap" id="listeners" data-url="<?=URL::site('admin/listeners/getUser')?>">
                    <?=View::factory('admin/html/listeners', compact('list_users'))?>
                </div>
            </div>
        </div>

        <div class="span9">

            <div class="well l_data">


                <h5 class="header_block pull-left">Данные по слушателю <strong></strong></h5>
                <div class="btns pull-right">
                    <!-- меняй класс active у кнопок + менять href'ы у кнопок редактирования и удаления (для того чтобы понять что удалять) statement_or_contract -->
                    <a id="l_statement" href="#tab1" class="btn active" data-toggle="tab">Слушатель</a>
                    <a id="l_contract" href="#tab2" class="btn" data-toggle="tab">Заказчик</a>
                </div>

                <div style="margin-top: 50px;" class="tab-content">

                    <div class="tab-pane active" id="tab1">
                        <form action="" method="post" id="statement" style="margin-bottom: 0">
                            <div class="row">
                                <div class="span3 data">
                                    <label for="date_contract">Договор от</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker" name="date_contract" id="date_contract" style="width: 95%">
                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="span3 data">
                                    <label>Группа №</label>
                                    <select name="group_id" id>
                                        <option value="0" selected="selected"> --- </option>
                                        <?foreach($list_groups as $item):?>
                                            <option value="<?=$item->id?>"><?=$item->name?></option>
                                        <?endforeach?>
                                    </select>
                                </div>
                                <div class="span3 data">
                                    <label>Водитель-инструктор</label>
                                    <select name="staff_id">
                                        <option value="0" selected="selected"> --- </option>
                                        <?/*foreach($list_groups as $item):*/?><!--
                                        <option value="<?/*=$item->id*/?>"><?/*=$item->name*/?></option>
                                        --><?/*endforeach*/?>
                                    </select>
                                </div>
                            </div>

                            <legend>Анкетные данные</legend>
                            <div class="row">
                                <div class="span4">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="famil">Фамилия</label>
                                            <input type="text" class="span4" name="famil" id="famil"/>
                                        </div>
                                        <div class="span4">
                                            <label for="imya">Имя</label>
                                            <input type="text" class="span4" name="imya" id="imya"/>
                                        </div>
                                        <div class="span4">
                                            <label for="otch">Отчество</label>
                                            <input type="text" class="span4" name="otch" id="otch"/>
                                        </div>
                                        <div class="span4">
                                            <label for="tel">Телефон</label>
                                            <input type="text" class="span4 telephone" name="tel" id="tel"/>
                                        </div>
                                        <div class="span4">
                                            <label for="mesto_raboty">Место работы</label>
                                            <input type="text" class="span4" name="mesto_raboty" id="mesto_raboty"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4 pull-right">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="mesto_rojdeniya">Место рождения</label>
                                            <input type="text" class="span4" name="mesto_rojdeniya" id="mesto_rojdeniya"/>
                                        </div>
                                        <div class="span4">
                                            <label>Гражданство</label>
                                            <select name="nationality_id" class="span4">
                                                <option> --- </option>
                                                <?foreach($national as $item):?>
                                                    <option value="<?=$item->id?>"><?=$item->name?></option>
                                                <?endforeach?>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <label>Образование</label>
                                            <select name="education_id" class="span4">
                                                <option> --- </option>
                                                <?foreach($edu as $item):?>
                                                    <option value="<?=$item->id?>"><?=$item->name?></option>
                                                <?endforeach?>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <div class="row">
                                                <div class="span2">
                                                    <label for="data_rojdeniya">Дата рождения</label>
                                                    <div class="input-append">
                                                        <input type="text" class="datepicker" name="data_rojdeniya" id="data_rojdeniya" style="width: 75%">
                                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <label>Пол</label>
                                                    <select name="sex" class="span2">
                                                        <option> --- </option>
                                                        <option value="1">Мужской</option>
                                                        <option value="0">Женский</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <legend>Медсправка</legend>
                            <div class="row">
                                <div class="span3">
                                    <label for="seriya_med">Серия</label>
                                    <input type="text" class="span3" name="seriya_med" id="seriya_med"/>
                                </div>
                                <div class="span3">
                                    <label for="nomer_med">Номер</label>
                                    <input type="text" class="span3" name="nomer_med" id="nomer_med"/>
                                </div>
                                <div class="span2">
                                    <label for="data_med">Дата</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker" name="data_med" id="data_med" style="width: 95%">
                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span8">
                                    <label for="kem_vydana_med">Кем выдана</label>
                                    <input type="text" class="span8" name="kem_vydana_med" id="kem_vydana_med"/>
                                </div>
                            </div>

                            <legend>Место жительства</legend>
                            <div class="row">
                                <div class="span4">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="region">Регион</label>
                                            <input type="text" class="span4" name="region" id="region"/>
                                        </div>
                                        <div class="span4">
                                            <label for="rion">Район</label>
                                            <input type="text" class="span4" name="rion" id="rion"/>
                                        </div>
                                        <div class="span4">
                                            <label for="nas_pynkt">Населенный пункт</label>
                                            <input type="text" class="span4" name="nas_pynkt" id="nas_pynkt"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4 pull-right">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="street">Улица</label>
                                            <input type="text" class="span4" name="street" id="street"/>
                                        </div>
                                        <div class="span4">
                                            <div class="row">
                                                <div class="span1">
                                                    <label for="dom">Дом</label>
                                                    <input type="text" class="span1" name="dom" id="dom"/>
                                                </div>
                                                <div class="span1">
                                                    <label for="korpys">Корпус</label>
                                                    <input type="text" class="span1" name="korpys" id="korpys"/>
                                                </div>
                                                <div class="span2">
                                                    <label for="kvartira">Квартира</label>
                                                    <input type="text" class="span2" name="kvartira" id="kvartira"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <legend>Удостоверение личности</legend>
                            <div class="row">
                                <div class="span4">
                                    <label>Тип</label>
                                    <select name="document_id" class="span4">
                                        <option> --- </option>
                                        <?foreach($type_doc as $item):?>
                                            <option value="<?=$item->id?>"><?=$item->name?></option>
                                        <?endforeach?>
                                    </select>
                                </div>
                                <div class="pull-right">
                                    <div class="span2">
                                        <label for="document_seriya">Серия</label>
                                        <input type="text" class="span2" name="document_seriya" id="document_seriya"/>
                                    </div>
                                    <div class="span2">
                                        <label for="document_nomer">Номер</label>
                                        <input type="text" class="span2" name="document_nomer" id="document_nomer"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span6">
                                    <label for="document_kem_vydan">Выдано</label>
                                    <input type="text" class="span6" name="document_kem_vydan" id="document_kem_vydan"/>
                                </div>
                                <div class="span2 pull-right">
                                    <label for="document_data_vydachi">Дата</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%">
                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <legend>Данные об окончании автошколы</legend>
                            <div class="row">
                                <div class="span4">
                                    Свидетельство обокончании обучения
                                    <div class="row">
                                        <div class="span4">
                                            <div class="row">
                                                <div class="span2">
                                                    <label for="certificate_seriya">Серия</label>
                                                    <input type="text" class="span2" name="certificate_seriya" id="certificate_seriya"/>
                                                </div>
                                                <div class="span2">
                                                    <label for="certificate_nomer">Номер</label>
                                                    <input type="text" class="span2" name="certificate_nomer" id="certificate_nomer"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4 pull-right">
                                    <br>
                                    <div class="row">
                                        <div class="span4">
                                            <label>Устройство и ТО</label>
                                            <select name="mark_to" class="span4">
                                                <option> --- </option>
                                                <option>Отлично</option>
                                                <option>Хорошо</option>
                                                <option>Удовлетворительно</option>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <label for="">ПДД</label>
                                            <select name="" id="" class="span4">
                                                <option> --- </option>
                                                <option>Отлично</option>
                                                <option>Хорошо</option>
                                                <option>Удовлетворительно</option>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <label for="">Практическое вождение</label>
                                            <select name="" id="" class="span4">
                                                <option> --- </option>
                                                <option>Отлично</option>
                                                <option>Хорошо</option>
                                                <option>Удовлетворительно</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" class="btn btn-block btn-info" value="Сохранить"/>

                        </form>

                    </div>

                    <div class="tab-pane" id="tab2">

                    </div>

                </div>

                <div class="clearfix"></div>

            </div>

        </div>

    </div>
</div>