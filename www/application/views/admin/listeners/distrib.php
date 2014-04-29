<?=HTML::style('adm/css/distrib.css')?>
<?=HTML::script('adm/js/distrib.js')?>
<?=HTML::script('adm/js/listener.js')?>

<div class="container">
<div class="row">
    <div class="span7">
        <h1><small>Неутвержденные слушатели</small></h1>
    </div>
</div>

<div class="row">

    <div class="span3 d_fio">
        <div class="well listeners">
            <h5 class="header_block">Фамилия И.О.</h5>
            <input type="hidden" id="user_id"/>
            <input type="hidden" name="distrib" class="distrib"/>
            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
            <div class="wrap" id="listeners" data-url="<?=URL::site('admin/listeners/getUser')?>">
                <?=View::factory('admin/html/listeners', compact('list_users'))?>
            </div>
        </div>
    </div>
    <div class="span9">
        <div class="well d_status">
            <h5 class="header_block">Статус</h5>
            <div class="progress">
                <div class="bar" style="width: 0%;"></div>
            </div>
            <a href="#" class="btn disabled" data-url="<?=URL::site('admin/listeners/change_status/')?>" data-width="33%">Информация верна</a>
            <a href="#" class="btn disabled" data-url="<?=URL::site('admin/listeners/change_status/')?>" data-width="66%" style="margin-left: 50px">Все документы сданы</a>
            <a href="#" class="btn disabled pull-right" data-url="<?=URL::site('admin/listeners/change_status/')?>" data-width="100%">Зачислен(а) в автошколу</a>
        </div>
        <div class="well data">
            <div class="header-wrap">
                <h5 class="header_block pull-left">Информация</h5>
                <div class="btns pull-right">
                    <a id="l_statement" href="#tab1" class="btn active" data-toggle="tab">Заявление</a>
                    <a id="l_contract" href="#tab2" class="btn" data-toggle="tab">Договор</a>
                    <button id="l_delete" data-url="<?=URL::site('admin/listeners/delete')?>" class="btn btn-danger <?=empty($list_users) ? 'disabled' : 'enb_dis'?>" rel="tooltip" title="Удалить слушателя"><i class="icon-trash"></i></button>
                    <div class="btn-group">

                        <button id="l_delete" data-url="<?=URL::site('admin/listeners/delete')?>" class="btn btn-danger <?=empty($list_users) ? 'disabled' : 'enb_dis'?>" rel="tooltip" title="Удалить слушателя"><i class="icon-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <form action="<?=URL::site('admin/listeners/update_user')?>" method="post" id="statement" style="margin-bottom: 0">

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

                    <input type="hidden" name="user_id" id="del_id"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <button type="submit" class="btn btn-block btn-info" id="button" style="margin-top: 20px">
                        Сохранить
                    </button>

                    </form>
                </div>

                <div class="tab-pane" id="tab2">

                    <form action="<?=URL::site('admin/listeners/contract_check')?>" method="post">
                        <label class="checkbox">
                            <input type="checkbox" name="customer" id="is_individual">
                            Заказчиком буду я
                        </label>
                        <input type="hidden" name="user_id" class="user_id"/>
                        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    </form>

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

                        <input type="hidden" name="listener_id" id="listener_id"/>
                        <input type="hidden" name="is_individual" class="is_individual"/>
                        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                        <button type="submit" class="btn btn-block btn-info" id="button" style="margin-top: 20px">
                            Сохранить
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</div>

