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
    <?if($status < 3):?>
    <form action="<?=Route::to('profile', 'profile#contract_check')?>" method="post" name="contract_check">
        <?if(Auth::instance()->get_user()->listener->is_individual == 0):?>
            <label for="customer"><input onclick="document.contract_check.submit()" style="margin-bottom: 5px" type="checkbox" name="customer" id="customer" checked/> Заказчиком буду я</label>
        <?else:?>
            <label for="customer"><input onclick="document.contract_check.submit()" style="margin-bottom: 5px" type="checkbox" name="customer" id="customer"/> Заказчиком буду я</label>
        <?endif?>
        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
    </form>
    <?endif?>
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
    <?if(Auth::instance()->get_user()->listener->is_individual):?>
        <form action="<?=Route::to('profile', 'profile#contract')?>" method="post" accept-charset="utf-8" novalidate>
            <legend>Анкетные данные</legend>
            <div class="row">
                <div class="span4">
                    <div class="row">
                        <div class="span4">
                            <label for="famil">Фамилия</label>
                            <input type="text" class="span4" name="famil" id="famil" value="<?=$contract['famil']?>"/>
                        </div>
                        <div class="span4">
                            <label for="otch">Отчество</label>
                            <input type="text" class="span4" name="otch" id="otch" value="<?=$contract['otch']?>"/>
                        </div>
                    </div>
                </div>
                <div class="span4 pull-right">
                    <div class="row">
                        <div class="span4">
                            <label for="imya">Имя</label>
                            <input type="text" class="span4" name="imya" id="imya" value="<?=$contract['imya']?>"/>
                        </div>
                        <div class="span4">
                            <label for="tel">Телефон</label>
                            <input type="text" class="span4 telephone" name="tel" id="tel" placeholder="8 (926) 123-45-67" value="<?=$contract['tel']?>"/>
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
                            <input type="text" class="span4" name="region" id="region" value="<?=$contract['region']?>"/>
                        </div>
                        <div class="span4">
                            <label for="rion">Район</label>
                            <input type="text" class="span4" name="rion" id="rion" value="<?=$contract['rion']?>"/>
                        </div>
                        <div class="span4">
                            <label for="nas_pynkt">Населенный пункт</label>
                            <input type="text" class="span4" name="nas_pynkt" id="nas_pynkt" value="<?=$contract['nas_pynkt']?>"/>
                        </div>
                    </div>
                </div>
                <div class="span4 pull-right">
                    <div class="row">
                        <div class="span4">
                            <label for="street">Улица</label>
                            <input type="text" class="span4" name="street" id="street" value="<?=$contract['street']?>"/>
                        </div>
                        <div class="span4">
                            <div class="row">
                                <div class="span1">
                                    <label for="dom">Дом</label>
                                    <input type="text" class="span1" name="dom" id="dom" value="<?=$contract['dom']?>"/>
                                </div>
                                <div class="span1">
                                    <label for="korpys">Корпус</label>
                                    <input type="text" class="span1" name="korpys" id="korpys" value="<?=$contract['korpys']?>"/>
                                </div>
                                <div class="span2">
                                    <label for="kvartira">Квартира</label>
                                    <input type="text" class="span2" name="kvartira" id="kvartira" value="<?=$contract['kvartira']?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="span4" style="margin-top: 30px">
                            <label class="checkbox" for="vrem_reg">
                                <input type="checkbox" name="vrem_reg" style="margin-bottom: 5px" id="vrem_reg" <?=($contract['vrem_reg'] == 1) ? 'checked' : null?>>
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
                            <option value="<?=$item->id?>" <?=($item->id == $contract['document_id']) ? 'selected' : null?>><?=$item->name?></option>
                        <?endforeach?>
                    </select>
                </div>
                <div class="pull-right">
                    <div class="span2">
                        <label for="document_seriya">Серия</label>
                        <input type="text" class="span2" name="document_seriya" id="document_seriya" value="<?=$contract['document_seriya']?>"/>
                    </div>
                    <div class="span2">
                        <label for="document_nomer">Номер</label>
                        <input type="text" class="span2" name="document_nomer" id="document_nomer" value="<?=$contract['document_nomer']?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="span6">
                    <label for="document_kem_vydan">Выдано</label>
                    <input type="text" class="span6" name="document_kem_vydan" id="document_kem_vydan" value="<?=$contract['document_kem_vydan']?>"/>
                </div>
                <div class="span2 pull-right">
                    <label for="document_data_vydachi">Дата</label>
                    <div class="input-append">
                        <input type="text" class="datepicker" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%" value="<?=$contract['document_data_vydachi']?>">
                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                    </div>
                </div>
            </div>

            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
            <?if($status < 3):?>
                <?if(!$contract_exists):?>
                    <input type="submit" class="btn btn-success span3" style="margin-top: 25px" value="Добавить"/>
                <?else:?>
                    <input type="submit" class="btn btn-info span3" style="margin-top: 25px" value="Обновить данные"/>
                <?endif?>
            <?endif?>

        </form>
    <?else:?>
        <p>Вы сами себе заказчик, ваши данные уже используются при формирования документа договора</p>
    <?endif?>

</div>




