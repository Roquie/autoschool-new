<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::style('global/css/datepicker.css')?>
<?=HTML::script('adm/js/staff.js')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>


<div class="container">
    <div class="row">
        <div class="span4">
            <h1><small>Сотрудники</small></h1>
        </div>
        <div class="span8 btn_actions">
            <button id="remove_staff" href="#" data-csrf="<?=Security::token()?>" data-url="<?=URL::site('/admin/staff/remove')?>" class="btn btn-danger pull-right" data-placement="bottom" rel="tooltip" title="Удалить сотрудника"> <i class="icon-trash"></i></button>
            <button style="margin-right: 5px" id="create_staff" href="#" data-url="<?=URL::site('/admin/staff/create')?>" class="btn btn-warning pull-right" data-placement="bottom" rel="tooltip" title="Добавить сотрудника в БД">Режим добавления</button>
        </div>
    </div>

    <div class="row">
        <!-- левая часть -->
        <div class="span3">
            <div class="well l_select_group">
                <h5 class="header_block">Должность</h5>
                <label for="">Выберите:</label>
                <select name="position_id" id="position_filter" data-url="<?=URL::site('admin/staff/position_filter')?>">
                    <option value="0" selected="selected">Все ...</option>
                    <?foreach($positions as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>
            </div>
            <div class="well l_fio" style="height: 630px;">
                <h5 class="header_block">Фамилия И.О.</h5>
                <input type="hidden" id="staff_id"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="wrap" id="staffs" data-url="<?=URL::site('admin/staff/get_info')?>">
                    <?if(!empty($list_staff)):?>
                        <?=View::factory('admin/html/staff', compact('list_staff'))?>
                    <?else:?>
                        <p style="text-align: center">Сотрудники не найдены.</p>
                        <p style="text-align: center">Добавьте кого-нить используя кнопку сверху справа.</p>
                    <?endif?>
                </div>
            </div>
        </div>

        <!-- правая часть -->
        <div class="span9">
            <div class="well l_data" style="height: 792px">
                <h5 class="header_block pull-left">Данные по сотруднику <strong></strong></h5>

                <!-- Данные сотрудника -->
                <form action="<?=URL::site('admin/staff/to_update')?>" method="post" id="staff" style="margin: 37px 0 0 0">
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
                                <div class="span4">
                                    <label>Пол</label>
                                    <select name="sex" class="span4">
                                        <option> --- </option>
                                        <option value="1">Мужской</option>
                                        <option value="0">Женский</option>
                                    </select>
                                </div>
                                <div class="span4">
                                    <label>Должность</label>
                                    <select name="office_staff_id" class="span4">
                                        <option> --- </option>
                                        <?foreach($positions as $item):?>
                                            <option value="<?=$item->id?>"><?=$item->name?></option>
                                        <?endforeach?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span4 pull-right">
                            <div class="row">
                                <div class="span4">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="imya">Имя</label>
                                            <input type="text" class="span4" name="imya" id="imya"/>
                                        </div>
                                        <div class="span4">
                                            <label for="tel">Телефон</label>
                                            <input type="text" class="span4 telephone" name="tel" id="tel"/>
                                        </div>
                                        <div class="span4">
                                            <label for="nomer_prav">Номер прав</label>
                                            <input type="text" class="span4" name="nomer_prav" id="nomer_prav"/>
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
                            <label for="document_data_vydachi">Дата выдачи</label>
                            <div class="input-append">
                                <input type="text" class="datepicker" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%">
                                <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
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
                                        Временная регистрация
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="update_staff_id" name="update_staff_id"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <button class="btn btn-block" id="btn_loader" style="margin-top: 20px; display: none" disabled>
                        <div class="loader"><i class="icon-refresh icon-spin"></i>&nbsp;Обработка</div>
                    </button>
                    <button data-url="<?=URL::site('/admin/staff/create')?>" type="submit" class="btn btn-block btn-success" id="create_data" style="margin-top: 20px; display: none">
                        Добавить
                    </button>
                    <button data-url="<?=URL::site('/admin/staff/to_update')?>"  type="submit" class="btn btn-block btn-info" id="save_data" style="margin-top: 20px">
                        Сохранить
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>