<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li class="active"><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<div class="span8" style="margin-top: 30px" >
    <form action="<?=Route::to('profile', 'profile#contract_check')?>" method="post" name="contract_check">
        <?if(Auth::instance()->get_user()->listener->is_individual):?>
            <label for="customer"><input onclick="document.contract_check.submit()" style="margin-bottom: 5px" type="checkbox" name="customer" id="customer" checked/> Заказчиком буду я</label>
        <?else:?>
            <label for="customer"><input onclick="document.contract_check.submit()" style="margin-bottom: 5px" type="checkbox" name="customer" id="customer"/> Заказчиком буду я</label>
        <?endif?>
        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
    </form>
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
    <?if(!Auth::instance()->get_user()->listener->is_individual):?>
        <form action="<?=Route::to('profile', 'profile#contract')?>" method="post" accept-charset="utf-8" novalidate>
            <div class="row">
                <div class="span3">
                    <label for="famil">Фамилия</label>
                    <input type="text" class="input-medium" name="famil" id="famil" value="<?=$contract['famil']?>"/>
                    <br/>
                    <label for="imya">Имя</label>
                    <input type="text" class="input-medium" name="imya" id="imya" value="<?=$contract['imya']?>"/>
                    <br/>
                    <label for="otch">Отчество</label>
                    <input type="text" class="input-medium" name="otch" id="otch" value="<?=$contract['otch']?>"/>
                    <br/>
                    <label for="tel">Телефон</label>
                    <input type="tel" class="input-medium" name="tel" id="tel" value="<?=$contract['tel']?>" placeholder="8 (909) 123-45-67"/>
                    <br/>
                </div>
                <div class="span5">
                    <div class="row">
                        <div class="span3" style="width: 180px">
                            <label for="type_document">Тип документа</label>
                            <select style="width: 165px" name="document_id" id="type_document">
                                <?if(!empty($type_doc)):?>
                                    <?foreach($type_doc as $k => $v):?>
                                        <?if($v->id == $contract['document_id']):?>
                                            <option value="<?=$v->id?>" selected><?=$v->name?></option>
                                        <?else:?>
                                            <option value="<?=$v->id?>"><?=$v->name?></option>
                                        <?endif?>
                                    <?endforeach?>
                                <?endif?>
                            </select>
                        </div>
                        <div class="span2">
                            <label for="document_data_vydachi">Дата выдачи</label>
                            <input type="date" style="width: 190px" class="input-medium" name="document_data_vydachi" id="document_data_vydachi" value="<?=$contract['document_data_vydachi']?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span3" style="width: 180px">
                            <label for="document_seriya">Серия документа</label>
                            <input type="text" class="input-medium" name="document_seriya" id="document_seriya" value="<?=$contract['document_seriya']?>"/>
                        </div>
                        <div class="span2">
                            <label for="document_nomer">Номер документа</label>
                            <input type="text" style="width: 190px" class="input-medium" name="document_nomer" id="document_nomer" value="<?=$contract['document_nomer']?>"/>
                        </div>
                    </div>

                    <label>Адрес регистрации (Место жительства)</label>
                    <div class="row">
                        <div class="span3" style="width: 180px">
                            <label for="region">Регион</label>
                            <input type="text" class="input-medium" name="region" id="region" value="<?=$contract['region']?>"/>
                        </div>
                        <div class="span2">
                            <label for="street">Улица</label>
                            <input type="text" style="width: 190px" class="input-medium" name="street" id="street" value="<?=$contract['street']?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span6">
                            <div class="span2" style="margin-left:  0;">
                                <label for="rion">Район</label>
                                <input type="text" class="input-medium" name="rion" id="rion" value="<?=$contract['rion']?>"/>
                            </div>
                            <div style="display: table-cell; padding-left: 40px">
                                <div class="span1">
                                    <label for="dom">Дом</label>
                                    <input type="text" style="width: 40px" name="dom" id="dom" value="<?=$contract['dom']?>"/>
                                </div>
                                <div class="span1">
                                    <label for="korpys">Корп.</label>
                                    <input type="text" style="width: 30px" name="korpys" id="korpys" value="<?=$contract['korpys']?>"/>
                                </div>
                                <div class="span1">
                                    <label for="kvartira">Кв.</label>
                                    <input type="text" style="width: 30px" name="kvartira" id="kvartira" value="<?=$contract['kvartira']?>"/>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="span3" style="width: 200px">
                            <label for="nas_pynkt">Насел. пункт</label>
                            <input type="text"  class="input-medium" name="nas_pynkt" id="nas_pynkt" value="<?=$contract['nas_pynkt']?>"/>
                        </div>
                        <div class="span2" style="margin-left: 0; width: 180px; margin-top: 20px">
                            <?if($contract['vrem_reg'] == 1):?>
                                <label for="vrem_reg"><input style="margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg" checked/> У меня временная регистрация</label>
                            <?else:?>
                                <label for="vrem_reg"><input style="margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg"/> У меня временная регистрация</label>
                            <?endif?>
                        </div>
                    </div>
                    <label for="document_kem_vydan">Кем выдан документ</label>
                    <input type="text" style="width: 102%" name="document_kem_vydan" id="document_kem_vydan" value="<?=$contract['document_kem_vydan']?>"/>



                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <?if($status < 3):?>
                        <?if(!$contract_exists->loaded()):?>
                            <input type="submit" class="btn btn-success span3" style="margin-top: 25px" value="Добавить"/>
                        <?else:?>
                            <input type="submit" class="btn btn-info span3" style="margin-top: 25px" value="Обновить данные"/>
                        <?endif?>
                    <?endif?>
                </div>
            </div>

        </form>
    <?else:?>
        <p>Вы сами себе заказчик, ваши данные уже используются при формирования документа договора</p>
    <?endif?>

</div>




