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
});