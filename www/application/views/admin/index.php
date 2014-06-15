<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::style('global/css/datepicker.css')?>
<?=HTML::script('adm/js/index.js')?>
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
                <select name="select2" id="select2" style="width: 136px" data-url="<?=URL::site('admin/listeners/users_by_group')?>">
                    <option value="0" selected="selected">Все ...</option>
                    <?foreach($list_groups as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>
                <a class="btn" href="<?=URL::site('admin/other/group')?>" rel="tooltip" title="Перейти на страницу добавления групп" data-toggle="modal" style="margin: -10px 0 0 0"><i class="icon-plus"></i></a>
                <!--<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Modal header</h3>
                    </div>
                    <div class="modal-body">
                        <p>One fine body…</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
                </div>-->
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

                    <!-- Данные слушателя -->
                    <div class="tab-pane active" id="tab1">
                        <form action="<?=URL::site('admin/listeners/update_user')?>" method="post" id="statement" style="margin-bottom: 0">
                            <div class="row">
                                <div class="span3 data">
                                    <label for="number_contract">Номер договора</label>
                                    <input type="text" name="number_contract" id="number_contract" style="width: 103%">
                                </div>
                                <div class="span3 data">
                                    <label for="date_contract">Договор от</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker_adm" name="date_contract" id="date_contract" style="width: 95%">
                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="span3 data">
                                    <label>Группа №</label>
                                    <select name="group_id" id="group_id">
                                        <option value="" selected="selected"> --- </option>
                                        <?foreach($list_groups as $item):?>
                                            <option value="<?=$item->id?>"><?=$item->name?></option>
                                        <?endforeach?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="span3 data">
                                    <label>Водитель-инструктор</label>
                                    <select name="staff_id" id="staff_id" style="width: 110%">
                                        <option value="" selected="selected"> --- </option>
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
                                                        <input type="text" class="datepicker_adm" name="data_rojdeniya" id="data_rojdeniya" style="width: 75%">
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
                                        <input type="text" class="datepicker_adm" name="data_med" id="data_med" style="width: 95%">
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
                                        <div class="span4" style="margin-top: 30px">
                                            <label class="checkbox">
                                                <input type="checkbox" name="vrem_reg">
                                                У меня временная регистрация
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <legend>Удостоверение личности</legend>
                            <div class="row">
                                <div class="span4">
                                    <label>Тип</label>
                                    <select name="document_id" class="span4">
                                        <option value="NULL"> --- </option>
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
                                        <input type="text" class="datepicker_adm" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%">
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
                                            <label for="mark_to">Устройство и ТО</label>
                                            <select name="mark_to" id="mark_tos" class="span4">
                                                <option> --- </option>
                                                <option value="5">Отлично</option>
                                                <option value="4">Хорошо</option>
                                                <option value="3">Удовлетворительно</option>
                                                <option value="2">Неудовлетворительно</option>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <label for="mark_pdd">ПДД</label>
                                            <select name="mark_pdd" id="mark_pdd" class="span4">
                                                <option> --- </option>
                                                <option value="5">Отлично</option>
                                                <option value="4">Хорошо</option>
                                                <option value="3">Удовлетворительно</option>
                                                <option value="2">Неудовлетворительно</option>
                                            </select>
                                        </div>
                                        <div class="span4">
                                            <label for="mark_drive">Практическое вождение</label>
                                            <select name="mark_drive" id="mark_drive" class="span4">
                                                <option> --- </option>
                                                <option value="5">Отлично</option>
                                                <option value="4">Хорошо</option>
                                                <option value="3">Удовлетворительно</option>
                                                <option value="2">Неудовлетворительно</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="user_id"/>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <button type="submit" class="btn btn-block btn-info" id="button" style="margin-top: 20px">
                                Сохранить
                            </button>

                        </form>
                    </div>

                    <!-- Данные заказчика -->
                    <div class="tab-pane" id="tab2">
                        <form action="<?=URL::site('admin/listeners/update_ind')?>" method="post" id="contract" style="margin-bottom: 0">
                            <legend>Анкетные данные</legend>
                            <div class="row">
                                <div class="span4">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="famil">Фамилия</label>
                                            <input type="text" class="span4" name="famil" id="famil"/>
                                        </div>
                                        <div class="span4">
                                            <label for="otch">Отчество</label>
                                            <input type="text" class="span4" name="otch" id="otch"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4 pull-right">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="imya">Имя</label>
                                            <input type="text" class="span4" name="imya" id="imya"/>
                                        </div>
                                        <div class="span4">
                                            <label for="tel">Телефон</label>
                                            <input type="text" class="span4 telephone" name="tel" id="tel"/>
                                        </div>
                                    </div>
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
                                        <div class="span4" style="margin-top: 30px">
                                            <label class="checkbox">
                                                <input type="checkbox" name="vrem_reg">
                                                У меня временная регистрация
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <legend>Удостоверение личности</legend>
                            <div class="row">
                                <div class="span4">
                                    <label>Тип</label>
                                    <select name="document_id" class="span4">
                                        <option value=""> --- </option>
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
                                        <input type="text" class="datepicker_adm" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%">
                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="listener_id" id="listener_id"/>
                            <input type="hidden" name="is_individual" id="is_individual"/>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <button type="submit" class="btn btn-block btn-info" id="button" style="margin-top: 20px">
                                Сохранить
                            </button>
                        </form>
                    </div>

                </div>

                <div class="clearfix"></div>

            </div>

        </div>

    </div>
</div>