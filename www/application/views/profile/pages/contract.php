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
                <label for="phone">Телефон</label>
                <input type="tel" class="input-medium" name="phone" id="phone" value="<?=$contract['phone']?>"/>
            </div>
            <div class="span4">
                <label for="adres_reg_po_pasporty">Адрес регистрации по паспорту</label>
                <input type="text" class="span5" name="adres_reg_po_pasporty" id="adres_reg_po_pasporty" value="<?=$contract['adres_reg_po_pasporty']?>"/>
                <br/>
                <div class="row">
                    <div class="span2">
                        <label for="pasport_seriya">Паспорт серия</label>
                        <input type="text" class="input-small" name="pasport_seriya" id="pasport_seriya" value="<?=$contract['pasport_seriya']?>"/>
                    </div>
                    <div class="span2">
                        <label for="pasport_nomer">Паспорт номер</label>
                        <input type="text" class="input-large" name="pasport_nomer" id="pasport_nomer" value="<?=$contract['pasport_nomer']?>"/>
                    </div>
                </div>
                <label for="pasport_kem_vydan">Кем выдан паспорт</label>
                <input type="text" class="span5" name="pasport_kem_vydan" id="pasport_kem_vydan" value="<?=$contract['pasport_kem_vydan']?>"/>
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
</div>




