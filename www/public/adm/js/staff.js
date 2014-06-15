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
        create_staff =  $('#create_staff'),
        cnt_select = 1;


    $('body')
        /**
         * Добавление селекта с выбором должности
         */
        .on('click', '.add_office', function(e) {
            e.preventDefault();
            var $this = $(this),
                cur = $this.closest('.input-append'),
                select = cur.clone();

            if (cnt_select < 5)
            {
                $('.l_data').height($('.l_data').height() + 40);
                $('.l_fio').height($('.l_fio').height() + 40);
                select.find('a').remove();
                select.addClass('new_slct');
                select.append('<a href="#" class="btn btn-danger del_office" style="margin-left: 15px"><i class="icon-remove"></i></a>').insertAfter(cur);
                cnt_select++;
            }
            else
            {
                alert('На группу можно не больше 5 инструкторов');
            }

        })
    /**
     * Удаление селекта с должностью
     */
        .on('click', '.del_office', function(e) {
            e.preventDefault();
            $(this).closest('.input-append').remove();
            $('.l_data').height($('.l_data').height() - 40);
            $('.l_fio').height($('.l_fio').height() - 40);
            cnt_select--;
        });



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
            $('.instructors_slct').find('.new_slct').remove();
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
                    create_staff.trigger('click');
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
                btn_loader.hide();
                btn_submit.show();

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
            field,
            btn_del_staff = $('.del_staff');

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
                    var first_inst = $('.instructors_slct').find('.input-append').first();

                    $('.instructors_slct').find('.new_slct').remove();

                    btn_del_staff.attr('href', btn_del_staff.data('url')+$this.val());


                    $.each(response.data, function(key, value)
                    {
                        field = f_staff.find('[name="'+key+'"]');

                        if (key == 'id') {
                            $('#update_staff_id').val(value);
                        }
                        else if (field.attr('type') == 'checkbox')
                        {
                            (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
                        }
                        else
                        {
                            if (key == 'offices')
                            {
                                var new_slct,
                                    i = 0;
                                cnt_select = 1;

                                $('.l_data').height(792);
                                $('.l_fio').height(630);

                                $.each(value, function(k, v)
                                {
                                    if (i == 0)
                                    {
                                        first_inst.find('select').val(v);
                                    }
                                    else
                                    {
                                        $('.l_data').height($('.l_data').height() + 40);
                                        $('.l_fio').height($('.l_fio').height() + 40);
                                        new_slct = first_inst.clone();
                                        new_slct.find('a').remove();
                                        new_slct.addClass('new_slct').append('<a href="#" class="btn btn-danger del_office" style="margin-left: 15px"><i class="icon-remove"></i></a>').find('select').val(v);
                                        new_slct.insertAfter(first_inst);
                                        cnt_select++;
                                    }
                                    i++;
                                });
                            }
                            else
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
                btn_loader.hide();
                btn_submit.show();

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