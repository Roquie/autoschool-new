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
        <div class="alert alert-danger"><?=array_shift($errors)?></div>
    <?endif?>
    <?if(isset($success)):?>
        <div class="alert alert-success"><?=$success?></div>
    <?endif?>
    <form action="<?=Route::to('profile', 'profile#statement')?>" method="post" accept-charset="utf-8" novalidate>
        <div class="row">
            <div class="span3" style="line-height: 45px; width: 200px">
                <label for="famil">Фамилия</label>
                <input type="text" class="input-medium" name="famil" id="famil" value="<?=$statement['famil']?>"/>
                <br/>
                <label for="imya">Имя</label>
                <input type="text" class="input-medium" name="imya" id="imya" value="<?=$statement['imya']?>"/>
                <br/>
                <label for="ot4estvo">Отчество</label>
                <input type="text" class="input-medium" name="ot4estvo" id="ot4estvo" value="<?=$statement['ot4estvo']?>"/>
                <br/>
                <label for="data_rojdeniya">Дата рождения</label>
                <input type="date" class="input-medium" name="data_rojdeniya" id="data_rojdeniya" value="<?=$statement['data_rojdeniya']?>"/>

                <br/>
                <label for="grajdanstvo">Гражданство</label>
                <select style="width: 165px" name="nationality_id" id="grajdanstvo">
                    <?if(!empty($national)):?>
                        <?foreach($national as $k => $v):?>
                            <?if($v->id == $statement['nationality_id']):?>
                                <option value="<?=$v->id?>" selected><?=$v->grajdanstvo?></option>
                            <?else:?>
                                <option value="<?=$v->id?>"><?=$v->grajdanstvo?></option>
                            <?endif?>
                        <?endforeach?>
                    <?endif?>
                </select>


            </div>
            <div class="span5">
                <label for="mesto_rojdeniya">Место рождения</label>
                <input type="text" style="width: 102%" name="mesto_rojdeniya" id="mesto_rojdeniya" value="<?=$statement['mesto_rojdeniya']?>"/>
                <br/>
                <label for="adres_reg_po_pasporty">Адрес регистрации по паспорту</label>
                <input type="text" style="width: 102%" name="adres_reg_po_pasporty" id="adres_reg_po_pasporty" value="<?=$statement['adres_reg_po_pasporty']?>"/>
                <label for="vrem_reg"><input style="margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg"/> У меня временная регистрация</label>
                <div class="row">
                    <div class="span3">
                        <label for="pasport_seriya">Паспорт серия</label>
                        <input type="text" class="input-medium" name="pasport_seriya" id="pasport_seriya" value="<?=$statement['pasport_seriya']?>"/>
                    </div>
                    <div class="span2">
                        <label for="pasport_nomer">Паспорт номер</label>
                        <input type="text" class="input-medium" name="pasport_nomer" id="pasport_nomer" value="<?=$statement['pasport_nomer']?>"/>
                    </div>
                </div>
                <label for="pasport_kem_vydan">Кем выдан паспорт</label>
                <input type="text" style="width: 102%" name="pasport_kem_vydan" id="pasport_kem_vydan" value="<?=$statement['pasport_kem_vydan']?>"/>
                <div class="row">
                    <div class="span3">
                        <label for="pasport_data_vyda4i">Дата выдачи</label>
                        <input type="date" class="input-medium" name="pasport_data_vyda4i" id="pasport_data_vyda4i" value="<?=$statement['pasport_data_vyda4i']?>"/>
                    </div>
                    <div class="span2">
                        <label for="mob_tel">Моб. телефон</label>
                        <input type="text" class="input-medium" name="mob_tel" id="mob_tel" value="<?=$statement['mob_tel']?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="span3">
                        <label for="education">Образование</label>
                        <select style="width: 165px" name="education_id" id="education">
                            <?if(!empty($edu)):?>
                                <?foreach($edu as $k => $v):?>
                                    <?if($v->id == $statement['education_id']):?>
                                        <option value="<?=$v->id?>" selected><?=$v->obrazovanie?></option>
                                    <?else:?>
                                        <option value="<?=$v->id?>"><?=$v->obrazovanie?></option>
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
                    <input type="submit" class="btn btn-info span3" style="margin-top: 9px" value="Обновить данные"/>
                <?endif?>
            </div>
        </div>

    </form>
</div>
