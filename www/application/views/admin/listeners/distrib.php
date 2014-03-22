<?=HTML::style('adm/css/distrib.css')?>
<script>
    $(function() {
        $("input:checkbox").click(function() {
            if ($(this).is(":checked")) {
                var group = "input:checkbox[name='" + $(this).attr("name") + "']";
                $(group).prop("checked", false);
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
        });
    });
</script>

<div class="container">
<div class="row">
    <div class="span7">
        <h1><small>Неутвержденные слушатели</small></h1>
    </div>
    <div class="span5 btn_actions">
        <!-- btn's maybe create ...-->
    </div>
</div>

<div class="row">
    <div class="span3 d_fio">
        <div class="well">
            <h5 class="header_block">Фамилия И.О.</h5>
            <div class="wrap">
                <?=View::factory('admin/html/listeners', compact('list_users'))?>
            </div>

        </div>
    </div>
    <div class="span9">
        <div class="well d_status">
            <h5 class="header_block">Статус</h5>
            <div class="progress">
                <!-- status 0 -->
                <!--<div class="bar bar-danger" style="width: 2%;"></div>-->
                <!--остальное так-->
                <div class="bar" style="width: 63%;"></div>
            </div>
            <a href="#" class="btn"><i class="icon-ok"></i> Информация верна</a>
            <a href="#" class="btn" style="margin-left: 50px"> <i class="icon-ok"></i> Все документы сданы</a>
            <a href="#" class="btn pull-right"><i class="icon-remove"></i> Зачислен(а) в автошколу</a>


        </div>
        <div class="well d_info">
            <div class="header-wrap">
                <h5 class="header_block pull-left">Информация</h5>
                <div class="btns pull-right">
                    <!-- меняй класс active у кнопок + менять href'ы у кнопок редактирования и удаления (для того чтобы понять что удалять) statement_or_contract -->
                    <a id="l_statement" href="#tab1" class="btn active" data-toggle="tab">Заявление</a>
                    <a id="l_contract" href="#tab2" class="btn" data-toggle="tab">Договор</a>
                    <div class="btn-group">
                        <a id="l_edit" href="#statement_or_contract" data-url="<?=URL::site('')?>" class="enb_dis btn btn-info" rel="tooltip" title="Режим редактирования"><i class="icon-pencil"></i></a>
                        <a id="l_delete" href="#statement_or_contract" data-url="<?=URL::site('')?>" class="enb_dis btn btn-danger" rel="tooltip" title="Удалить слушателя"><i class="icon-trash"></i></a>
                    </div>

                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1" style="overflow: hidden">
                    <form action="<?=Route::to('admin', 'listeners#distrib')?>" method="post" accept-charset="utf-8" novalidate>
                        <div class="row">
                            <div class="span3" style="line-height: 40px;">
                                <label for="famil">Фамилия</label>
                                <input type="text" class="input-medium" name="famil" id="famil" value="<?//=$statement['famil']?>"/>
                                <br/>
                                <label for="imya">Имя</label>
                                <input type="text" class="input-medium" name="imya" id="imya" value="<?//=$statement['imya']?>"/>
                                <br/>
                                <label for="otch">Отчество</label>
                                <input type="text" class="input-medium" name="otch" id="otch" value="<?//=$statement['otch']?>"/>
                                <br/>
                                <label for="tel">Моб. телефон</label>
                                <input type="text" class="input-medium" name="tel" id="tel" value="<?//=$statement['tel']?>"/>
                                <br/>
                                <label for="data_rojdeniya">Дата рождения</label>
                                <input type="date" class="input-medium" name="data_rojdeniya" id="data_rojdeniya" value="<?//=$statement['data_rojdeniya']?>"/>

                                <br/>
                                <label for="sex">Пол</label>
                                <select style="width: 165px" name="sex" id="sex">
                                    <?//if($statement['sex'] == 1):?>
                                        <option value="1">Мужской</option>
                                        <option value="0">Женский</option>
                                    <?//else:?>
                                        <option value="0">Женский</option>
                                        <option value="1">Мужской</option>
                                    <?//endif?>
                                </select>
                                <br/>
                                <label for="grajdanstvo">Гражданство</label>
                                <select style="width: 165px" name="nationality_id" id="grajdanstvo">
                                    <?//if(!empty($national)):?>
                                        <?//foreach($national as $k => $v):?>
                                            <?//if($v->id == $statement['nationality_id']):?>
                                                <option value="<?//=$v->id?>" selected><?//=$v->name?></option>
                                            <?//else:?>
                                                <option value="<?//=$v->id?>"><?//=$v->name?></option>
                                            <?//endif?>
                                        <?//endforeach?>
                                    <?//endif?>
                                </select>
                                <label for="type_document">Тип документа</label>
                                <select style="width: 165px" name="document_id" id="type_document">
                                    <?//if(!empty($type_doc)):?>
                                        <?//foreach($type_doc as $k => $v):?>
                                            <?//if($v->id == $statement['document_id']):?>
                                                <option value="<?//=$v->id?>" selected><?//=$v->name?></option>
                                            <?//else:?>
                                                <option value="<?//=$v->id?>"><?//=$v->name?></option>
                                            <?//endif?>
                                        <?//endforeach?>
                                    <?//endif?>
                                </select>
                                <br/>
                                <label for="document_data_vydachi">Дата выдачи</label>
                                <input type="date" class="input-medium" name="document_data_vydachi" id="document_data_vydachi" value="<?//=$statement['document_data_vydachi']?>"/>
                            </div>

                                <div class="span5" style="margin-right: 0; padding-right: 0; ">
                                    <div class="row">
                                        <div class="span3">
                                            <label for="document_seriya">Серия документа</label>
                                            <input type="text" class="input-medium" name="document_seriya" id="document_seriya" value="<?//=$statement['document_seriya']?>"/>
                                        </div>
                                        <div class="span2">
                                            <label for="document_nomer">Номер документа</label>
                                            <input type="text" class="input-medium" name="document_nomer" id="document_nomer" value="<?//=$statement['document_nomer']?>"/>
                                        </div>
                                    </div>
                                    <label for="mesto_rojdeniya">Место рождения</label>
                                    <input type="text" style="width: 102%" name="mesto_rojdeniya" id="mesto_rojdeniya" value="<?//=$statement['mesto_rojdeniya']?>"/>
                                    <br/>
                                    <label>Адрес регистрации (Место жительства)</label>
                                    <div class="row">
                                        <div class="span3">
                                            <label for="region">Регион</label>
                                            <input type="text" class="input-medium" name="region" id="region" value="<?//=$statement['region']?>"/>
                                        </div>
                                        <div class="span2">
                                            <label for="street">Улица</label>
                                            <input type="text" class="input-medium" name="street" id="street" value="<?//=$statement['street']?>"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span6">
                                            <div class="span2" style="margin-left:  0;">
                                                <label for="rion">Район</label>
                                                <input type="text" class="input-medium" name="rion" id="rion" value="<?//=$statement['rion']?>"/>
                                            </div>
                                            <div style="display: table-cell; padding-left: 40px">
                                                <div class="span1">
                                                    <label for="dom">Дом</label>
                                                    <input type="text" style="width: 40px" name="dom" id="dom" value="<?//=$statement['dom']?>"/>
                                                </div>
                                                <div class="span1">
                                                    <label for="korpys">Корп.</label>
                                                    <input type="text" style="width: 30px" name="korpys" id="korpys" value="<?//=$statement['korpys']?>"/>
                                                </div>
                                                <div class="span1">
                                                    <label for="kvartira">Кв.</label>
                                                    <input type="text" style="width: 30px" name="kvartira" id="kvartira" value="<?//=$statement['kvartira']?>"/>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="span3" style="width: 200px">
                                            <label for="nas_pynkt">Насел. пункт</label>
                                            <input type="text"  class="input-medium" name="nas_pynkt" id="nas_pynkt" value="<?//=$statement['nas_pynkt']?>"/>
                                        </div>
                                        <div class="span2" style="margin-left: 0; width: 180px; margin-top: 20px">
                                            <?//if($statement['vrem_reg'] == 1):?>
                                                <label for="vrem_reg"><input style="margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg" checked/> У меня временная регистрация</label>
                                            <?//else:?>
                                                <label for="vrem_reg"><input style="margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg"/> У меня временная регистрация</label>
                                            <?//endif?>
                                        </div>
                                    </div>
                                    <label for="document_kem_vydan">Кем выдан документ</label>
                                    <input type="text" style="width: 102%" name="document_kem_vydan" id="document_kem_vydan" value="<?//=$statement['document_kem_vydan']?>"/>

                                    <div class="row">
                                        <div class="span3">
                                            <label for="education">Образование</label>
                                            <select style="width: 165px" name="education_id" id="education">
                                                <?//if(!empty($edu)):?>
                                                    <?//foreach($edu as $k => $v):?>
                                                        <?//if($v->id == $statement['education_id']):?>
                                                            <option value="<?//=$v->id?>" selected><?//=$v->name?></option>
                                                        <?//else:?>
                                                            <option value="<?//=$v->id?>"><?//=$v->name?></option>
                                                        <?//endif?>
                                                    <?//endforeach?>
                                                <?//endif?>
                                            </select>
                                        </div>
                                        <div class="span2">
                                            <label for="mesto_raboty">Место работы</label>
                                            <input type="text" class="input-medium" name="mesto_raboty" id="mesto_raboty" value="<?//=$statement['mesto_raboty']?>"/>
                                        </div>
                                    </div>
                                    <label for="about">Как вы узнали о нас</label>
                                    <input type="text" style="width: 102%" name="about" id="about" value="<?//=$statement['about']?>"/>
                                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                    <?//if($status < 3):?>
                                        <input type="submit" class="btn btn-info span3" style="margin-top: 14px" value="Обновить данные"/>
                                    <?//endif?>
                                </div>

                        </div>

                    </form>
                </div>

                <div class="tab-pane" id="tab2">

                    <table class="table table-striped contract">

                        <tbody>

                        <tr>
                            <td>Фамилия</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="famil" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">Петрова</a></td>
                        </tr>
                        <tr>
                            <td>Имя</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="imya" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">Анастасия</a></td>
                        </tr>
                        <tr>
                            <td>Отчество</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" -name="ot4estvo" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">Агафьевна</a></td>
                        </tr>
                        <tr>
                            <td>Адрес регистрации по паспорту</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="adres_reg_po_pasporty" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">г. Москва, ул. Петросяна, д.13, к.9</a></td>
                        </tr>
                        <tr>
                            <td>Паспорт серия</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="pasport_seriya" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">4382</a></td>
                        </tr>
                        <tr>
                            <td>Паспорт номер</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="pasport_nome" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">20934820</a></td>
                        </tr>
                        <tr>
                            <td>Кем выдан паспорт</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="pasport_kem_vydan" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">ОВД Г.КАЗАНИ 2</a></td>
                        </tr>
                        <tr>
                            <td>Мобильный телефон</td>
                            <td><a href="#" data-url="http://autoschool.ru/lk/ajax/changeContract/21" data-name="phone" data-type="text" data-pk="" class="editable editable-click editable-disabled" tabindex="-1">+79261195550</a></td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

</div>

