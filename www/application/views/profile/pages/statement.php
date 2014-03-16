<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li class="active"><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<div class="span8" style="margin-top: 30px">
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
    <form action="<?=Route::to('profile', 'profile#statement')?>" method="post" accept-charset="utf-8" novalidate>
        <div class="row">
            <div class="span3" style="line-height: 40px; width: 200px">
                <label for="famil">Фамилия</label>
                <input type="text" class="input-medium" name="famil" id="famil" value="<?=$statement['famil']?>"/>
                <br/>
                <label for="imya">Имя</label>
                <input type="text" class="input-medium" name="imya" id="imya" value="<?=$statement['imya']?>"/>
                <br/>
                <label for="otch">Отчество</label>
                <input type="text" class="input-medium" name="otch" id="otch" value="<?=$statement['otch']?>"/>
                <br/>
                <label for="tel">Моб. телефон</label>
                <input type="text" class="input-medium" name="tel" id="tel" value="<?=$statement['tel']?>"/>
                <br/>
                <label for="data_rojdeniya">Дата рождения</label>
                <input type="date" class="input-medium" name="data_rojdeniya" id="data_rojdeniya" value="<?=$statement['data_rojdeniya']?>"/>

                <br/>
                <label for="sex">Пол</label>
                <select style="width: 165px" name="sex" id="sex">
                    <option value="1">Мужской</option>
                    <option value="0">Женский</option>
                </select>
                <br/>
                <label for="grajdanstvo">Гражданство</label>
                <select style="width: 165px" name="nationality_id" id="grajdanstvo">
                    <?if(!empty($national)):?>
                        <?foreach($national as $k => $v):?>
                            <?if($v->id == $statement['nationality_id']):?>
                                <option value="<?=$v->id?>" selected><?=$v->name?></option>
                            <?else:?>
                                <option value="<?=$v->id?>"><?=$v->name?></option>
                            <?endif?>
                        <?endforeach?>
                    <?endif?>
                </select>
                <label for="type_document">Тип документа</label>
                <select style="width: 165px" name="document_id" id="type_document">
                    <?if(!empty($type_doc)):?>
                        <?foreach($type_doc as $k => $v):?>
                            <?if($v->id == $statement['document_id']):?>
                                <option value="<?=$v->id?>" selected><?=$v->name?></option>
                            <?else:?>
                                <option value="<?=$v->id?>"><?=$v->name?></option>
                            <?endif?>
                        <?endforeach?>
                    <?endif?>
                </select>
                <br/>
                <label for="document_data_vydachi">Дата выдачи</label>
                <input type="date" class="input-medium" name="document_data_vydachi" id="document_data_vydachi" value="<?=$statement['document_data_vydachi']?>"/>

            </div>
            <div class="span5">
                <div class="row">
                    <div class="span3">
                        <label for="document_seriya">Серия документа</label>
                        <input type="text" class="input-medium" name="document_seriya" id="document_seriya" value="<?=$statement['document_seriya']?>"/>
                    </div>
                    <div class="span2">
                        <label for="document_nomer">Номер документа</label>
                        <input type="text" class="input-medium" name="document_nomer" id="document_nomer" value="<?=$statement['document_nomer']?>"/>
                    </div>
                </div>
                <label for="mesto_rojdeniya">Место рождения</label>
                <input type="text" style="width: 102%" name="mesto_rojdeniya" id="mesto_rojdeniya" value="<?=$statement['mesto_rojdeniya']?>"/>
                <br/>
                <label>Адрес регистрации (Место жительства)</label>
                <div class="row">
                    <div class="span3">
                        <label for="region">Регион</label>
                        <input type="text" class="input-medium" name="region" id="region" value="<?=$statement['region']?>"/>
                    </div>
                    <div class="span2">
                        <label for="street">Улица</label>
                        <input type="text" class="input-medium" name="street" id="street" value="<?=$statement['street']?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="span6">
                        <div class="span2" style="margin-left:  0;">
                            <label for="rion">Район</label>
                            <input type="text" class="input-medium" name="rion" id="rion" value="<?=$statement['rion']?>"/>
                        </div>
                        <div style="display: table-cell; padding-left: 40px">
                            <div class="span1">
                                <label for="dom">Дом</label>
                                <input type="text" style="width: 40px" name="dom" id="dom" value="<?=$statement['dom']?>"/>
                            </div>
                            <div class="span1">
                                <label for="korpys">Корп.</label>
                                <input type="text" style="width: 30px" name="korpys" id="korpys" value="<?=$statement['korpys']?>"/>
                            </div>
                            <div class="span1">
                                <label for="kvartira">Кв.</label>
                                <input type="text" style="width: 30px" name="kvartira" id="kvartira" value="<?=$statement['kvartira']?>"/>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="span3" style="width: 200px">
                        <label for="nas_pynkt">Насел. пункт</label>
                        <input type="text"  class="input-medium" name="nas_pynkt" id="nas_pynkt" value="<?=$statement['nas_pynkt']?>"/>
                    </div>
                    <div class="span2" style="margin-left: 0; width: 180px; margin-top: 20px">
                        <label for="vrem_reg"><input style="margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg"/> У меня временная регистрация</label>
                    </div>
                </div>
                <label for="document_kem_vydan">Кем выдан документ</label>
                <input type="text" style="width: 102%" name="document_kem_vydan" id="document_kem_vydan" value="<?=$statement['document_kem_vydan']?>"/>

                <div class="row">
                    <div class="span3">
                        <label for="education">Образование</label>
                        <select style="width: 165px" name="education_id" id="education">
                            <?if(!empty($edu)):?>
                                <?foreach($edu as $k => $v):?>
                                    <?if($v->id == $statement['education_id']):?>
                                        <option value="<?=$v->id?>" selected><?=$v->name?></option>
                                    <?else:?>
                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <?endif?>
                                <?endforeach?>
                            <?endif?>
                        </select>
                    </div>
                    <div class="span2">
                        <label for="mesto_raboty">Место работы</label>
                        <input type="text" class="input-medium" name="mesto_raboty" id="mesto_raboty" value="<?=$statement['mesto_raboty']?>"/>
                    </div>
                </div>
                <label for="about">Как вы узнали о нас</label>
                <input type="text" style="width: 102%" name="about" id="about" value="<?=$statement['about']?>"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <?if($status < 3):?>
                    <input type="submit" class="btn btn-info span3" style="margin-top: 14px" value="Обновить данные"/>
                <?endif?>
            </div>
        </div>

    </form>
</div>
