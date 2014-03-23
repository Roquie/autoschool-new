<ul id="tabs" class="nav nav-tabs">
    <li><a href="<?=URL::site('admin/createdocs')?>">Заявление</a></li>
    <li class="active"><a href="<?=URL::site('admin/createdocs/contract')?>">Договор</a></li>
</ul>

<script type="text/javascript">
    $(function(){
        $('#is_individual').on('click', function()
        {
            var f_contract = $('#f_contract');
            if($(this).is(':checked'))
            {
                $.post(
                    $(this).closest('form').attr('action'),
                    $('#contract_check').serialize(),
                    function(response)
                    {
                        if (response.status == 'success')
                        {
                            $.each(response.data, function(key, value)
                            {
                                if (response.data.vrem_reg)
                                {
                                    f_contract.find('[name="'+key+'"]').prop('checked', true);
                                }
                                f_contract.find('[name="'+key+'"]').val(value);
                            });
                        }
                    },
                    'json'
                );
            }
            else
            {
                f_contract.trigger('reset');
            }
        });
    });
</script>
<?if(Session::instance()->get('st_createdocs')):?>
    <form action="<?=Route::to('admin.createdocs', 'index#contract_check')?>" method="post" id="contract_check">
        <label for="is_individual"><input type="checkbox" style="width: 16px; margin-bottom: 5px" name="is_individual" id="is_individual" /> Заказчик, тот, кто писал заявление</label>
        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
    </form>

    <div class="line"></div>
<?endif?>

<form id="f_contract" action="<?=Route::to('admin.createdocs', 'index#contract')?>" method="post" accept-charset="utf-8" novalidate>
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
        </div>
        <div class="span5" style="width: 425px">
            <div class="row">
                <div class="span3" style="width: 215px">
                    <label for="type_document">Тип документа</label>
                    <select style="width: 215px" name="document_id" id="type_document">
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
                        <input type="text" class="datepicker" name="document_data_vydachi" id="document_data_vydachi" style="width: 181px; margin-left: -9px" >
                        <span class="add-on btn" style="margin-top: 0" id="calendar"><i class="icon-calendar"></i></span>
                    </div>
                </div>
            </div>
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
                <div class="span2" style="width: 207px">
                    <label for="nas_pynkt">Насел. пункт</label>
                    <input type="text"  class="input-medium" name="nas_pynkt" id="nas_pynkt" />
                </div>
                <div class="span2" style="margin-left: 20px; width: 180px; margin-top: 20px; float: right">
                    <label for="vrem_reg"><input style="width: 16px; margin-bottom: 5px" type="checkbox" name="vrem_reg" id="vrem_reg"> У слушателя временная регистрация</label>
                </div>
            </div>
            <label for="document_kem_vydan">Кем выдан документ</label>
            <input type="text" style="width: 102%" name="document_kem_vydan" id="document_kem_vydan" />

            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
        </div>
    </div>
<div class="line"></div>
<div class="row pull-right">
    <div class="span3">
        <input type="submit" style="margin-top: 0;" id="generateContract" class="btn btn-success pull-right" name="ok" value="&dArr; Скачать договор &dArr;"/>
    </div>
    <div class="span3">
        <input type="button" style="margin-top: 0" class="btn btn-info" id="send" value="Сохранить в базе &raquo;" data-url="<?=URL::site('admin/listeners/g_add')?>">
    </div>
</div>
</form>
