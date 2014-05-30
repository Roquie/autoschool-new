<!--css-->
<?=HTML::style('global/css/stylizationForm.css')?>

<?=HTML::style('main/css/statement.css')?>
<?=HTML::style('main/css/chosen.css')?>
<?=HTML::script('adm/js/createdocs.js')?>

<div class="container">
    <div class="row">
        <div class="span7">
            <h1><small>Добавить в БД или создать документы</small></h1>
        </div>
    </div>
    <div class="well well-small form-block">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Заявление</a></li>
                <li><a href="#tab2" data-toggle="tab">Договор</a></li>
            </ul>
            <div class="tab-content" style="overflow: hidden">
                <!-- section statement -->
                <div class="tab-pane active" id="tab1">
                        <form id="f_statement" action="<?=URL::site('admin/createdocs')?>" data-next-url="<?=URL::site('admin/createdocs/next')?>" method="post" accept-charset="utf-8" novalidate>
                            <div class="row">
                                <div class="span5" style="width: 425px">
                                    <label for="famil">Фамилия</label>
                                    <input type="text" class="input-medium" name="statement[famil]" id="famil" />
                                    <br/>
                                    <label for="imya">Имя</label>
                                    <input type="text" class="input-medium" name="statement[imya]" id="imya" />
                                    <br/>
                                    <label for="otch">Отчество</label>
                                    <input type="text" class="input-medium" name="statement[otch]" id="otch" />
                                    <br/>
                                    <label for="tel">Моб. телефон</label>
                                    <input type="text" class="input-medium telephone" name="statement[tel]" id="tel" placeholder="8 (926) 123-45-67" />
                                    <br/>
                                    <label for="email">Email</label>
                                    <input type="email" class="input-medium" name="statement[email]" id="email" placeholder="example@gmail.com" />
                                    <br/>
                                    <label for="data_rojdeniya">Дата рождения</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker_adm" name="statement[data_rojdeniya]" id="data_rojdeniya" style="width: 385px" >
                                        <span class="add-on btn" style="margin-top: 0" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                    <br/>
                                    <label for="sex">Пол</label>
                                    <select style="width: 100%" name="statement[sex]" id="sex">
                                        <option value="1">Мужской</option>
                                        <option value="0">Женский</option>
                                    </select>
                                    <br/>
                                    <label for="grajdanstvo">Гражданство</label>
                                    <select style="width: 100%" name="statement[nationality_id]" id="grajdanstvo">
                                        <?if(!empty($national)):?>
                                            <?foreach($national as $k => $v):?>
                                                <option value="<?=$v->id?>"><?=$v->name?></option>
                                            <?endforeach?>
                                        <?endif?>
                                    </select>
                                    <br/>
                                    <label for="document_data_vydachi">Дата выдачи</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker_adm" name="statement[document_data_vydachi]" id="document_data_vydachi" style="width: 385px" >
                                        <span class="add-on btn" style="margin-top: 0" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>

                                </div>
                                <div class="span5" style="width: 425px; margin-left: 25px">
                                    <label for="type_document">Тип документа</label>
                                    <select style="width: 447px" name="statement[document_id]" id="type_document">
                                        <?if(!empty($type_doc)):?>
                                            <?foreach($type_doc as $k => $v):?>
                                                <option value="<?=$v->id?>"><?=$v->name?></option>
                                            <?endforeach?>
                                        <?endif?>
                                    </select>
                                    <br/>
                                    <div class="row">
                                        <div class="span3" style="width: 207px">
                                            <label for="document_seriya">Серия документа</label>
                                            <input type="text" class="input-medium" name="statement[document_seriya]" id="document_seriya" />
                                        </div>
                                        <div class="span2">
                                            <label for="document_nomer">Номер документа</label>
                                            <input type="text" style="width: 207px" class="input-medium" name="statement[document_nomer]" id="document_nomer" />
                                        </div>
                                    </div>
                                    <label for="document_kem_vydan">Кем выдан документ</label>
                                    <input type="text" style="width: 102%" name="statement[document_kem_vydan]" id="document_kem_vydan" />
                                    <label for="mesto_rojdeniya">Место рождения</label>
                                    <input type="text" style="width: 102%" name="statement[mesto_rojdeniya]" id="mesto_rojdeniya" />
                                    <br/>

                                    <div class="row">
                                        <div class="span3" style="width: 207px">
                                            <label for="region">Регион</label>
                                            <input type="text" class="input-medium" name="statement[region]" id="region" />
                                        </div>
                                        <div class="span2">
                                            <label for="street">Улица</label>
                                            <input type="text" style="width: 207px" class="input-medium" name="statement[street]" id="street" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span6">
                                            <div class="span2" style="margin-left: 0; width: 207px">
                                                <label for="rion">Район</label>
                                                <input type="text" class="input-medium" name="statement[rion]" id="rion" />
                                            </div>
                                            <div class="span1">
                                                <label for="dom">Дом</label>
                                                <input type="text" style="width: 40px" name="statement[dom]" id="dom" />
                                            </div>
                                            <div class="span1">
                                                <label for="korpys">Корп.</label>
                                                <input type="text" style="width: 30px" name="statement[korpys]" id="korpys" />
                                            </div>
                                            <div class="span1">
                                                <label for="kvartira">Кв.</label>
                                                <input type="text" style="width: 47px" name="statement[kvartira]" id="kvartira" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span3" style="width: 207px">
                                            <label for="nas_pynkt">Насел. пункт</label>
                                            <input type="text"  class="input-medium" name="statement[nas_pynkt]" id="nas_pynkt" />
                                        </div>
                                        <div class="span2" style="margin-left: 20px; width: 190px; margin-top: 20px">
                                            <label for="vrem_reg"><input style="width: 16px; margin-bottom: 5px" type="checkbox" name="statement[vrem_reg]" id="vrem_reg"/> У слушателя временная регистрация</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="span3" style="width: 207px">
                                            <label for="education">Образование</label>
                                            <select style="width: 207px" name="statement[education_id]" id="education">
                                                <?if(!empty($edu)):?>
                                                    <?foreach($edu as $k => $v):?>
                                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                                    <?endforeach?>
                                                <?endif?>
                                            </select>
                                        </div>
                                        <div class="span2">
                                            <label for="mesto_raboty">Место работы</label>
                                            <input type="text" style="width: 207px" class="input-medium" name="statement[mesto_raboty]" id="mesto_raboty" />
                                        </div>
                                    </div>
                                    <label for="about">Как вы узнали о нас</label>
                                    <input type="text" style="width: 102%" name="statement[about]" id="about" />
                                    <input type="hidden" name="statement[is_individual]" value="1"/>
                                    <input type="hidden" name="statement[csrf]" value="<?=Security::token()?>"/>


                                </div>
                            </div>
                            <div class="line"></div>
                            <input type="submit" class="btn btn-success pull-right" style="margin-top: 0; width: 180px;" value="&dArr; Скачать заявление &dArr;"/>
                        </form>
                </div>

                <!-- section contract -->
                <div class="tab-pane" id="tab2">

                    <label for="is_individual"><input type="checkbox" style="width: 16px; margin-bottom: 5px" name="is_individual" id="is_individual" /> Заказчик, тот, кто писал заявление</label>
                    <div class="line"></div>
                    <form id="f_contract" action="<?=Route::to('admin.createdocs', 'index#contract')?>"  method="post" accept-charset="utf-8" novalidate>
                        <div class="row">
                            <div class="span5" style="width: 425px">
                                <label for="famil">Фамилия</label>
                                <input type="text" class="input-medium" name="contract[famil]" id="famil" />
                                <br/>
                                <label for="imya">Имя</label>
                                <input type="text" class="input-medium" name="contract[imya]" id="imya" />
                                <br/>
                                <label for="otch">Отчество</label>
                                <input type="text" class="input-medium" name="contract[otch]" id="otch" />
                                <br/>
                                <label for="tel">Моб. телефон</label>
                                <input type="text" class="input-medium telephone" name="contract[tel]" id="tel" placeholder="8 (926) 123-45-67" />
                            </div>
                            <div class="span5" style="width: 425px">
                                <div class="row">
                                    <div class="span3" style="width: 215px">
                                        <label for="type_document">Тип документа</label>
                                        <select style="width: 215px" name="contract[document_id]" id="type_document">
                                            <?if(!empty($type_doc)):?>
                                                <?foreach($type_doc as $k => $v):?>
                                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                                <?endforeach?>
                                            <?endif?>
                                        </select>
                                    </div>
                                    <div class="span2">
                                        <label for="document_data_vydachi">Дата выдачи</label>
                                        <div class="input-append">
                                            <input type="text" class="datepicker_adm" name="contract[document_data_vydachi]" id="document_data_vydachi" style="width: 181px; margin-left: -9px" >
                                            <span class="add-on btn" style="margin-top: 0" id="calendar"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span3" style="width: 207px">
                                        <label for="document_seriya">Серия документа</label>
                                        <input type="text" class="input-medium" name="contract[document_seriya]" id="document_seriya" />
                                    </div>
                                    <div class="span2">
                                        <label for="document_nomer">Номер документа</label>
                                        <input type="text" style="width: 207px" class="input-medium" name="contract[document_nomer]" id="document_nomer" />
                                    </div>
                                </div>

                                <label for="document_kem_vydan">Кем выдан документ</label>
                                <input type="text" style="width: 102%" name="contract[document_kem_vydan]" id="document_kem_vydan" />

                                <div class="row">
                                    <div class="span3" style="width: 207px">
                                        <label for="region">Регион</label>
                                        <input type="text" class="input-medium" name="contract[region]" id="region" />
                                    </div>
                                    <div class="span2">
                                        <label for="street">Улица</label>
                                        <input type="text" style="width: 207px" class="input-medium" name="contract[street]" id="street" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span6">
                                        <div class="span2" style="margin-left: 0; width: 207px">
                                            <label for="rion">Район</label>
                                            <input type="text" class="input-medium" name="contract[rion]" id="rion" />
                                        </div>
                                        <div class="span1">
                                            <label for="dom">Дом</label>
                                            <input type="text" style="width: 40px" name="contract[dom]" id="dom" />
                                        </div>
                                        <div class="span1">
                                            <label for="korpys">Корп.</label>
                                            <input type="text" style="width: 30px" name="contract[korpys]" id="korpys" />
                                        </div>
                                        <div class="span1">
                                            <label for="kvartira">Кв.</label>
                                            <input type="text" style="width: 47px" name="contract[kvartira]" id="kvartira" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span2" style="width: 207px">
                                        <label for="nas_pynkt">Насел. пункт</label>
                                        <input type="text"  class="input-medium" name="contract[nas_pynkt]" id="nas_pynkt" />
                                    </div>
                                    <div class="span2" style="margin-left: 20px; width: 190px; margin-top: 20px; float: right">
                                        <label for="vrem_reg"><input style="width: 16px; margin-bottom: 5px" type="checkbox" name="contract[vrem_reg]" id="vrem_reg"> У заказчика временная регистрация</label>
                                    </div>
                                </div>


                                <input type="hidden" name="contract[csrf]" value="<?=Security::token()?>"/>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="row pull-right">
                            <div class="span3">
                                <a href="#" style="margin-top: 0;" id="generateContract" class="btn btn-success pull-right" name="contract[ok]">&dArr; Скачать договор &dArr;</a>
                            </div>
                            <div class="span3" style="width: 160px">
                                <button id="btn_loader" style="display: none; margin-top: 0" class="btn btn-info" disabled><i class="icon-refresh icon-spin icon-small"></i> &nbsp;Секунду...</button>
                                <a href="#" style="margin-top: 0;" class="btn btn-info" id="save_to_db" data-url="<?=URL::site('admin/createdocs/save_to_db')?>"> Сохранить в базе &raquo;</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
