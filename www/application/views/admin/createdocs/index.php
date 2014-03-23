<ul id="tabs" class="nav nav-tabs">
    <li class="active"><a href="<?=URL::site('admin/createdocs')?>">Заявление</a></li>
    <li><a href="<?=URL::site('admin/createdocs/contract')?>">Договор</a></li>
</ul>


    <div class="container" style="width: 890px">
        <?if(isset($errors)):?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?=array_shift($errors)?>
            </div>
        <?endif?>
        <?if(isset($success)):?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?=$success?>
            </div>
        <?endif?>
        <script type="text/javascript">
            /* говнокод :) */
            $(function(){
                $('#next').on('click', function(e){
                    e.preventDefault();
                    var link = $('#statement_form').data('next-url');
                    $('#statement_form').attr('action', link).submit();
                });
            });
        </script>
        <form id="statement_form" action="<?=URL::site('admin/createdocs')?>" data-next-url="<?=URL::site('admin/createdocs/next')?>" method="post" accept-charset="utf-8" novalidate>
            <div class="row">
                <div class="span5" style="width: 425px">
                    <label for="famil">Фамилия</label>
                    <input type="text" class="input-medium" name="famil" id="famil" />
                    <br/>
                    <label for="imya">Имя</label>
                    <input type="text" class="input-medium" name="imya" id="imya" />
                    <br/>
                    <label for="otch">Отчество</label>
                    <input type="text" class="input-medium" name="otch" id="otch" />
                    <br/>
                    <label for="tel">Моб. телефон</label>
                    <input type="text" class="input-medium telephone" name="tel" id="tel" placeholder="8 (926) 123-45-67" />
                    <br/>
                    <label for="data_rojdeniya">Дата рождения</label>
                    <div class="input-append">
                        <input type="text" class="datepicker" name="data_rojdeniya" id="data_rojdeniya" style="width: 385px" value="<?=date('d.m.Y')?>">
                        <span class="add-on btn" style="margin-top: 0" id="calendar"><i class="icon-calendar"></i></span>
                    </div>
                    <br/>
                    <label for="sex">Пол</label>
                    <select style="width: 100%" name="sex" id="sex">
                            <option value="1">Мужской</option>
                            <option value="0">Женский</option>
                    </select>
                    <br/>
                    <label for="grajdanstvo">Гражданство</label>
                    <select style="width: 100%" name="nationality_id" id="grajdanstvo">
                        <?if(!empty($national)):?>
                            <?foreach($national as $k => $v):?>
                                <option value="<?=$v->id?>"><?=$v->name?></option>
                            <?endforeach?>
                        <?endif?>
                    </select>
                    <label for="type_document">Тип документа</label>
                    <select style="width: 100%" name="document_id" id="type_document">
                        <?if(!empty($type_doc)):?>
                            <?foreach($type_doc as $k => $v):?>
                                <option value="<?=$v->id?>"><?=$v->name?></option>
                            <?endforeach?>
                        <?endif?>
                    </select>
                    <br/>
                    <label for="document_data_vydachi">Дата выдачи</label>
                    <div class="input-append">
                        <input type="text" class="datepicker" name="document_data_vydachi" id="document_data_vydachi" style="width: 385px" value="<?=date('d.m.Y')?>">
                        <span class="add-on btn" style="margin-top: 0" id="calendar"><i class="icon-calendar"></i></span>
                    </div>

                </div>
                <div class="span5" style="width: 425px">
                    <div class="row">
                        <div class="span3" style="width: 207px">
                            <label for="document_seriya">Серия документа</label>
                            <input type="text" class="input-medium" name="document_seriya" id="document_seriya" />
                        </div>
                        <div class="span2">
                            <label for="document_nomer">Номер документа</label>
                            <input type="text" style="width: 207px" class="input-medium" name="document_nomer" id="document_nomer" />
                        </div>
                    </div>
                    <label for="mesto_rojdeniya">Место рождения</label>
                    <input type="text" style="width: 102%" name="mesto_rojdeniya" id="mesto_rojdeniya" />
                    <br/>

                    <div class="row">
                        <div class="span3" style="width: 207px">
                            <label for="region">Регион</label>
                            <input type="text" class="input-medium" name="region" id="region" />
                        </div>
                        <div class="span2">
                            <label for="street">Улица</label>
                            <input type="text" style="width: 207px" class="input-medium" name="street" id="street" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="span6">
                            <div class="span2" style="margin-left: 0; width: 207px">
                                <label for="rion">Район</label>
                                <input type="text" class="input-medium" name="rion" id="rion" />
                            </div>
                            <div class="span1">
                                <label for="dom">Дом</label>
                                <input type="text" style="width: 40px" name="dom" id="dom" />
                            </div>
                            <div class="span1">
                                <label for="korpys">Корп.</label>
                                <input type="text" style="width: 30px" name="korpys" id="korpys" />
                            </div>
                            <div class="span1">
                                <label for="kvartira">Кв.</label>
                                <input type="text" style="width: 47px" name="kvartira" id="kvartira" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span3" style="width: 207px">
                            <label for="nas_pynkt">Насел. пункт</label>
                            <input type="text"  class="input-medium" name="nas_pynkt" id="nas_pynkt" />
                        </div>
                        <div class="span2" style="margin-left: 20px; width: 180px; margin-top: 20px">
                            <label for="vrem_reg"><input style="width: 16px; margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg"/> У слушателя временная регистрация</label>
                        </div>
                    </div>
                    <label for="document_kem_vydan">Кем выдан документ</label>
                    <input type="text" style="width: 102%" name="document_kem_vydan" id="document_kem_vydan" />

                    <div class="row">
                        <div class="span3" style="width: 207px">
                            <label for="education">Образование</label>
                            <select style="width: 207px" name="education_id" id="education">
                                <?if(!empty($edu)):?>
                                    <?foreach($edu as $k => $v):?>
                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <?endforeach?>
                                <?endif?>
                            </select>
                        </div>
                        <div class="span2">
                            <label for="mesto_raboty">Место работы</label>
                            <input type="text" style="width: 207px" class="input-medium" name="mesto_raboty" id="mesto_raboty" />
                        </div>
                    </div>
                    <label for="about">Как вы узнали о нас</label>
                    <input type="text" style="width: 102%" name="about" id="about" />
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>


                </div>
            </div>
                <div class="line"></div>
                <button id="next" class="btn btn-info pull-right" style="margin-top: 14px; width: 160px;">Далее &raquo;</button>
                <input type="submit" class="btn btn-success pull-right" style="margin-top: 14px; width: 180px; margin-right: 20px" value="&dArr; Скачать заявление &dArr;"/>

        </form>
    </div>
