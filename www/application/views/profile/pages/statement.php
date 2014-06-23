<div class="span3 menu">
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
            <?=is_array($errors) ? array_shift($errors) : $errors?>
        </div>
    <?endif?>
    <?if(isset($success)):?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?=$success?>
        </div>
    <?endif?>
    <form action="<?=Route::to('profile', 'profile#statement')?>" method="post" accept-charset="utf-8" novalidate>
        <legend>Анкетные данные</legend>
        <div class="row">
            <div class="span4">
                <div class="row">
                    <div class="span4">
                        <label for="famil">Фамилия</label>
                        <input type="text" class="span4" name="famil" id="famil" value="<?=$statement['famil']?>"/>
                    </div>
                    <div class="span4">
                        <label for="imya">Имя</label>
                        <input type="text" class="span4" name="imya" id="imya" value="<?=$statement['imya']?>"/>
                    </div>
                    <div class="span4">
                        <label for="otch">Отчество</label>
                        <input type="text" class="span4" name="otch" id="otch" value="<?=$statement['otch']?>"/>
                    </div>
                    <div class="span4">
                        <label for="tel">Мобильный телефон</label>
                        <input type="text" class="span4 telephone" name="tel" id="tel" placeholder="8 (926) 123-45-67" value="<?=$statement['tel']?>"/>
                    </div>
                    <div class="span4">
                        <label for="mesto_raboty">Место работы</label>
                        <input type="text" class="span4" name="mesto_raboty" id="mesto_raboty" value="<?=$statement['mesto_raboty']?>"/>
                    </div>
                </div>
            </div>
            <div class="span4 pull-right">
                <div class="row">
                    <div class="span4">
                        <label for="mesto_rojdeniya">Место рождения</label>
                        <input type="text" class="span4" name="mesto_rojdeniya" id="mesto_rojdeniya" value="<?=$statement['mesto_rojdeniya']?>"/>
                    </div>
                    <div class="span4">
                        <label>Гражданство</label>
                        <select name="nationality_id" class="span4">
                            <option> --- </option>
                            <?foreach($national as $item):?>
                                <option value="<?=$item->id?>" <?=($statement['nationality_id'] == $item->id) ? 'selected' : null?> ><?=$item->name?></option>
                            <?endforeach?>
                        </select>
                    </div>
                    <div class="span4">
                        <label>Образование</label>
                        <select name="education_id" class="span4">
                            <option> --- </option>
                            <?foreach($edu as $item):?>
                                <option value="<?=$item->id?>" <?=($statement['education_id'] == $item->id) ? 'selected' : null?> ><?=$item->name?></option>
                            <?endforeach?>
                        </select>
                    </div>
                    <div class="span4">
                        <div class="row">
                            <div class="span2">
                                <label for="data_rojdeniya">Дата рождения</label>
                                <div class="input-append">
                                    <input type="text" class="datepicker" name="data_rojdeniya" id="data_rojdeniya" style="width: 75%" value="<?=$statement['data_rojdeniya']?>">
                                    <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="span2">
                                <label>Пол</label>
                                <select name="sex" class="span2">
                                    <?if($statement['sex'] == 1):?>
                                        <option value="1">Мужской</option>
                                        <option value="0">Женский</option>
                                    <?else:?>
                                        <option value="0">Женский</option>
                                        <option value="1">Мужской</option>
                                    <?endif?>
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
                        <input type="text" class="span4" name="region" id="region" value="<?=$statement['region']?>"/>
                    </div>
                    <div class="span4">
                        <label for="rion">Район</label>
                        <input type="text" class="span4" name="rion" id="rion" value="<?=$statement['rion']?>"/>
                    </div>
                    <div class="span4">
                        <label for="nas_pynkt">Населенный пункт</label>
                        <input type="text" class="span4" name="nas_pynkt" id="nas_pynkt" value="<?=$statement['nas_pynkt']?>"/>
                    </div>
                </div>
            </div>
            <div class="span4 pull-right">
                <div class="row">
                    <div class="span4">
                        <label for="street">Улица</label>
                        <input type="text" class="span4" name="street" id="street" value="<?=$statement['street']?>"/>
                    </div>
                    <div class="span4">
                        <div class="row">
                            <div class="span1">
                                <label for="dom">Дом</label>
                                <input type="text" class="span1" name="dom" id="dom" value="<?=$statement['dom']?>"/>
                            </div>
                            <div class="span1">
                                <label for="korpys">Корпус</label>
                                <input type="text" class="span1" name="korpys" id="korpys" value="<?=$statement['korpys']?>"/>
                            </div>
                            <div class="span2">
                                <label for="kvartira">Квартира</label>
                                <input type="text" class="span2" name="kvartira" id="kvartira" value="<?=$statement['kvartira']?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="span4" style="margin-top: 30px">
                        <label class="checkbox">
                            <input type="checkbox" name="vrem_reg" id="vrem_reg" style="margin-bottom: 5px" <?=($statement['vrem_reg'] == 1) ? 'checked' : null?>>
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
                        <option value="<?=$item->id?>" <?=($item->id == $statement['document_id']) ? 'selected' : null?>><?=$item->name?></option>
                    <?endforeach?>
                </select>
            </div>
            <div class="pull-right">
                <div class="span2">
                    <label for="document_seriya">Серия</label>
                    <input type="text" class="span2" name="document_seriya" id="document_seriya" value="<?=$statement['document_seriya']?>"/>
                </div>
                <div class="span2">
                    <label for="document_nomer">Номер</label>
                    <input type="text" class="span2" name="document_nomer" id="document_nomer" value="<?=$statement['document_nomer']?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span6">
                <label for="document_kem_vydan">Выдано</label>
                <input type="text" class="span6" name="document_kem_vydan" id="document_kem_vydan" value="<?=$statement['document_kem_vydan']?>"/>
            </div>
            <div class="span2 pull-right">
                <label for="document_data_vydachi">Дата</label>
                <div class="input-append">
                    <input type="text" class="datepicker_adm" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%" value="<?=$statement['document_data_vydachi']?>">
                    <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                </div>
            </div>
        </div>

        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
        <?if($status < 3):?>
            <input type="submit" class="btn btn-info span3" style="margin-top: 14px" value="Обновить данные"/>
        <?endif?>

    </form>
</div>
