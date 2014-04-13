<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::style('global/css/datepicker.css')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>

<script type="text/javascript">
    $(function()
    {
        "use strict";

        /*
        *
        * РАЗРАБОТЧИК ПРЕДУПРЕЖДАЕТ!!!
        *
        * ЭТО КОНЧЕННЫЙ ГОВНОКОД (SPECIAL FOR MPT), НЕ ПЫТАТЬСЯ ПОНЯТЬ, НЕ ТРОГАТЬ!
        * ВСЕ БЫЛО ТАК ЗАДУМАНО!
        *
        * */

        var list_staff = $('#staffs'),
            f_staff = $('#staff'),
            create_staff =  $('#create_staff');



        create_staff.on('click', function(e)
        {
            e.preventDefault();
            var save = $('#save_data'),
                create =  $('#create_data'),
                $this = $(this);

            if ($this.hasClass('active'))
            {
                if ($('#update_staff_id').val() == 0)
                {
                    list_staff.find('input:checkbox').first().trigger('click');
                }
                else
                {
                    list_staff.find('input[type=checkbox][value='+$('#update_staff_id').val()+']').trigger('click');
                }

                f_staff.attr('action', save.data('url'));
                $this.html('Режим добавления');
                $this.removeClass('active');
                create.hide();
                save.show();
            }
            else
            {
                $('#update_staff_id').val(0);
                $('#position_filter').trigger('change');
                f_staff.attr('action', create.data('url'));
                $this.html('Режим просмотра/редакт.');
                $this.addClass('active');
                save.hide();
                create.show();
            }

        });

        $('#create_data').on('click', function(e)
        {
            e.preventDefault();

            var btn_submit = $('#create_data'),
                btn_loader = $('#btn_loader');

            $.ajax({
                type : 'POST',
                url  : $(this).closest('form').attr('action'),
                data : f_staff.serialize() + '&position_id=' + $('#position_filter').val(),
                dataType : 'json',
                beforeSend : function()
                {
                    btn_submit.hide();
                    btn_loader.show();
                },
                success : function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#position_filter').trigger('change');
                    }

                    if (response.status == 'success' || response.status == 'error')
                    {
                        message($('.container'), response.msg, response.status);
                    }

                    btn_loader.hide();
                    btn_submit.show();
                },
                error : function(request)
                {
                    if (request.status == '200') {
                        console.log('Исключение: ' + request.responseText);
                    } else {
                        console.log(request.status + ' ' + request.statusText);
                    }
                }
            });
        });


        $('#remove_staff').on('click', function(e)
        {
            e.preventDefault();

            var $this = $(this);

            $.ajax({
                type : 'POST',
                url  : $this.data('url'),
                data :
                {
                    staff_id : $('#update_staff_id').val(),
                    csrf :  $this.data('csrf')
                },
                dataType : 'json',
                beforeSend : function()
                {
                    $this.attr('disabled', true);
                    $this.html('<div class="loader"><i class="icon-refresh icon-spin icon-small"></i></div>');
                },
                success : function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#position_filter').trigger('change');
                        list_staff.find('input:checkbox').first().trigger('click');
                    }

                    if (response.status == 'success' || response.status == 'error')
                    {
                        message($('.container'), response.msg, response.status);
                    }

                    $this.attr('disabled', false);
                    $this.html(' <i class="icon-trash"></i>');
                },
                error : function(request)
                {
                    if (request.status == '200') {
                        console.log('Исключение: ' + request.responseText);
                    } else {
                        console.log(request.status + ' ' + request.statusText);
                    }
                }
            });
        });


        list_staff.on('click', 'input:checkbox', function()
        {
            if ($(this).is(":checked")) {
                var group = "input:checkbox[name='" + $(this).attr("name") + "']";
                $(group).prop("checked", false);
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", true);
                return;
            }

            $('#update_staff_id').val($(this).val());

            if (create_staff.hasClass('active'))
            {
                $('#create_staff').trigger('click');
            }


            var $this = $(this),
                field;

            $.ajax({
                type : 'POST',
                url  : list_staff.data('url'),
                data : {
                    csrf : list_staff.prev('input').val(),
                    staff_id : $this.val()
                },
                dataType : 'json',
                beforeSend : function()
                {
                    list_staff.find('.loader').remove();
                    $this.parent().append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

                    f_staff.find('input, select').each(function()
                    {
                        if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                            if ($(this).attr('type') == 'checkbox')
                                $(this).prop("checked", false);
                            else
                                $(this).val('');
                    });
                },
                success : function(response)
                {
                    if (response.status == 'success')
                    {
                        $.each(response.data, function(key, value)
                        {
                            field = f_staff.find('[name="'+key+'"]');

                            if (key == 'id') {
                                $('#update_staff_id').val(value);
                            }
                            if (field.attr('type') == 'checkbox')
                            {
                                (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
                            }
                            else
                            {
                                field.val(value);
                            }
                        });


                    }
                    if (response.status == 'error')
                    {

                    }
                    list_staff.prev('input').val(response.csrf);
                    list_staff.find('.loader').remove();
                },
                error : function(request)
                {
                    if (request.status == '200') {
                        console.log('Исключение: ' + request.responseText);
                    } else {
                        console.log(request.status + ' ' + request.statusText);
                    }
                }
            });

        });





        $('#position_filter').on('change', function()
        {
            var $this = $(this);

            $.ajax({
                type : 'POST',
                url  : $this.data('url'),
                data : {
                    csrf : list_staff.prev('input').val(),
                    position_id : $this.val()
                },
                dataType : 'json',
                beforeSend : function() {
                    list_staff.html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

                    f_staff.find('input, select').each(function() {
                        if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                            $(this).val('');
                    });

                },
                success : function(response)
                {
                    list_staff.html('');
                    if (response.status == 'success')
                    {
                        if (response.data == '')
                        {
                            if (!create_staff.hasClass('active'))
                            {
                                $('#create_staff').trigger('click');
                            }
                                $('#create_staff').attr('disabled', true);
                            $('#remove_staff').attr('disabled', true);
                            list_staff.html('<div class="text-center">Сотрудников нет <br/><p><strong>Включен Режим добавления</strong></p></div>');
                        }
                        else
                        {
                            $('#create_staff').attr('disabled', false);
                            $('#remove_staff').attr('disabled', false);
                            list_staff.html(response.data);

                            if (!create_staff.hasClass('active'))
                            {
                                if (list_staff.find('input[type=checkbox][value='+$('#update_staff_id').val()+']').length)
                                {
                                    list_staff.find('input[type=checkbox][value='+$('#update_staff_id').val()+']').trigger('click');
                                }
                                else
                                {
                                    list_staff.find('input:checkbox').first().trigger('click');
                                }
                            }
                        }
                    }
                    if (response.status == 'error')
                    {
                        message($('.container'), response.msg, response.status);
                    }
                    list_staff.prev('input').val(response.csrf);
                },
                error : function(request)
                {
                    if (request.status == '200') {
                        console.log('Исключение: ' + request.responseText);
                    } else {
                        console.log(request.status + ' ' + request.statusText);
                    }
                }
            });

        });

        $('#save_data').on('click', function(e)
        {
            e.preventDefault();

            var btn_submit = $('#save_data'),
                btn_loader = $('#btn_loader'),
                f_staff = $('#staff');


            $.ajax({
                type : 'POST',
                url  : $(this).closest('form').attr('action'),
                data : f_staff.serialize(),
                dataType : 'json',
                beforeSend : function()
                {
                    btn_submit.hide();
                    btn_loader.show();
                },
                success : function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#position_filter').trigger('change');
                    }

                    if (response.status == 'success' || response.status == 'error')
                    {
                        message($('.container'), response.msg, response.status);
                    }

                    btn_loader.hide();
                    btn_submit.show();
                },
                error : function(request)
                {
                    if (request.status == '200') {
                        console.log('Исключение: ' + request.responseText);
                    } else {
                        console.log(request.status + ' ' + request.statusText);
                    }
                }
            });
        });


        //$('#create_staff').trigger('click');


        list_staff.find('input:checkbox').first().trigger('click');
        function message(block, msg, type) {
            var html =  '<div class="alert alert-' + type + '">' +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<span>' + msg + '</span>' +
                '</div>';

            block.prepend(html);

            $('html, body').animate({scrollTop:0}, 'slow');

            setTimeout(function() {
                $('.alert').animate({opacity:0}, 'slow', function() {
                    $(this).remove();
                });
            }, 3000);
        }


    });
</script>

<div class="container">
    <div class="row">
        <div class="span4">
            <h1><small>Сотрудники</small></h1>
        </div>
        <div class="span8 btn_actions">
            <button id="remove_staff" href="#" data-csrf="<?=Security::token()?>" data-url="<?=URL::site('/admin/staff/remove')?>" class="btn btn-danger pull-right" data-placement="bottom" rel="tooltip" title="Удалить сотрудника"> <i class="icon-trash"></i></button>
            <button style="margin-right: 5px" id="create_staff" href="#" data-url="<?=URL::site('/admin/staff/create')?>" class="btn btn-warning pull-right" data-placement="bottom" rel="tooltip" title="Добавить сотрудника в БД">Режим добавления</button>
        </div>
    </div>

    <div class="row">
        <!-- левая часть -->
        <div class="span3">
            <div class="well l_select_group">
                <h5 class="header_block">Должность</h5>
                <label for="">Выберите:</label>
                <select name="position_id" id="position_filter" data-url="<?=URL::site('admin/staff/position_filter')?>">
                    <option value="0" selected="selected">Все ...</option>
                    <?foreach($positions as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>
            </div>
            <div class="well l_fio" style="height: 569px;">
                <h5 class="header_block">Фамилия И.О.</h5>
                <input type="hidden" id="staff_id"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="wrap" id="staffs" data-url="<?=URL::site('admin/staff/get_info')?>">
                    <?if(!empty($list_staff)):?>
                        <?=View::factory('admin/html/staff', compact('list_staff'))?>
                    <?else:?>
                        <p style="text-align: center">Сотрудники не найдены.</p>
                        <p style="text-align: center">Добавьте кого-нить используя кнопку сверху справа.</p>
                    <?endif?>
                </div>
            </div>
        </div>

        <!-- правая часть -->
        <div class="span9">
            <div class="well l_data" style="height: 730px">
                <h5 class="header_block pull-left">Данные по сотруднику <strong></strong></h5>

                <!-- Данные сотрудника -->
                <form action="<?=URL::site('admin/staff/to_update')?>" method="post" id="staff" style="margin: 37px 0 0 0">
                    <div class="row">
                        <div class="span4">
                            <div class="row">
                                <div class="span4">
                                    <label for="famil">Фамилия</label>
                                    <input type="text" class="span4" name="famil" id="famil"/>
                                </div>
                                <div class="span4">
                                    <label for="otch">Отчество</label>
                                    <input type="text" class="span4" name="otch" id="otch"/>
                                </div>
                                <div class="span4">
                                    <label>Пол</label>
                                    <select name="sex" class="span4">
                                        <option> --- </option>
                                        <option value="1">Мужской</option>
                                        <option value="0">Женский</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span4 pull-right">
                            <div class="row">
                                <div class="span4">
                                    <div class="row">
                                        <div class="span4">
                                            <label for="imya">Имя</label>
                                            <input type="text" class="span4" name="imya" id="imya"/>
                                        </div>
                                        <div class="span4">
                                            <label for="tel">Телефон</label>
                                            <input type="text" class="span4 telephone" name="tel" id="tel"/>
                                        </div>
                                        <div class="span4">
                                            <label for="nomer_prav">Номер прав</label>
                                            <input type="text" class="span4" name="nomer_prav" id="nomer_prav"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <legend>Удостоверение личности</legend>
                    <div class="row">
                        <div class="span4">
                            <label>Тип</label>
                            <select name="document_id" class="span4">
                                <option> --- </option>
                                <?foreach($type_doc as $item):?>
                                        <option value="<?=$item->id?>"><?=$item->name?></option>
                                <?endforeach?>
                            </select>
                        </div>
                        <div class="pull-right">
                            <div class="span2">
                                <label for="document_seriya">Серия</label>
                                <input type="text" class="span2" name="document_seriya" id="document_seriya"/>
                            </div>
                            <div class="span2">
                                <label for="document_nomer">Номер</label>
                                <input type="text" class="span2" name="document_nomer" id="document_nomer"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span6">
                            <label for="document_kem_vydan">Выдано</label>
                            <input type="text" class="span6" name="document_kem_vydan" id="document_kem_vydan"/>
                        </div>
                        <div class="span2 pull-right">
                            <label for="document_data_vydachi">Дата выдачи</label>
                            <div class="input-append">
                                <input type="text" class="datepicker" name="document_data_vydachi" id="document_data_vydachi" style="width: 70%">
                                <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <legend>Место жительства</legend>
                    <div class="row">
                        <div class="span4">
                            <div class="row">
                                <div class="span4">
                                    <label for="region">Регион</label>
                                    <input type="text" class="span4" name="region" id="region"/>
                                </div>
                                <div class="span4">
                                    <label for="rion">Район</label>
                                    <input type="text" class="span4" name="rion" id="rion"/>
                                </div>
                                <div class="span4">
                                    <label for="nas_pynkt">Населенный пункт</label>
                                    <input type="text" class="span4" name="nas_pynkt" id="nas_pynkt"/>
                                </div>
                            </div>
                        </div>
                        <div class="span4 pull-right">
                            <div class="row">
                                <div class="span4">
                                    <label for="street">Улица</label>
                                    <input type="text" class="span4" name="street" id="street"/>
                                </div>
                                <div class="span4">
                                    <div class="row">
                                        <div class="span1">
                                            <label for="dom">Дом</label>
                                            <input type="text" class="span1" name="dom" id="dom"/>
                                        </div>
                                        <div class="span1">
                                            <label for="korpys">Корпус</label>
                                            <input type="text" class="span1" name="korpys" id="korpys"/>
                                        </div>
                                        <div class="span2">
                                            <label for="kvartira">Квартира</label>
                                            <input type="text" class="span2" name="kvartira" id="kvartira"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4" style="margin-top: 30px">
                                    <label class="checkbox">
                                        <input type="checkbox" name="vrem_reg">
                                        Временная регистрация
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="update_staff_id" name="update_staff_id"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <button class="btn btn-block" id="btn_loader" style="margin-top: 20px; display: none" disabled>
                        <div class="loader"><i class="icon-refresh icon-spin"></i>&nbsp;Обработка</div>
                    </button>
                    <button data-url="<?=URL::site('/admin/staff/create')?>" type="submit" class="btn btn-block btn-success" id="create_data" style="margin-top: 20px; display: none">
                        Добавить
                    </button>
                    <button data-url="<?=URL::site('/admin/staff/to_update')?>"  type="submit" class="btn btn-block btn-info" id="save_data" style="margin-top: 20px">
                        Сохранить
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>