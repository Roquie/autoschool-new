$(function() {

    var body = $('body'),
        groups = $('#groups'),
        cnt_instructors = 1,
        cnt_lessons = 1;

    body
    /**
     * Кнопки редактировать/добавить
     */
        .on('click', '.btn-change', function(e) {
            e.preventDefault();
            $('.btn-change').removeClass('active');
            $(this).addClass('active');
            $('.instructors_slct').find('.new_slct').remove();

            var groups = $('#groups'),
                form = $('#group_form');

            if ($(this).hasClass('add'))
            {
                groups.find('input').prop('disabled', true);

                form.find('input,select').each(function() {
                    if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                        if ($(this).attr('type') == 'checkbox')
                            $(this).prop("checked", false);
                        else
                            $(this).val('');
                });
            }
            else if ($(this).hasClass('edit'))
            {
                groups.find('input').prop('disabled', false);
                groups.find('input:checkbox:checked').prop('checked', false).trigger('click');
            }
        })
    /**
     * Доблавние селекта с выбором инструктора
     */
        .on('click', '.add_instructor', function(e) {
            e.preventDefault();
            var $this = $(this),
                cur = $this.closest('.input-append'),
                select = cur.clone();

            if (cnt_instructors < 5)
            {
                select.find('a').remove();
                select.addClass('new_slct');
                select.append('<a href="#" class="btn btn-danger del_instructor" style="margin-left: 15px"><i class="icon-remove"></i></a>').insertAfter(cur);
                cnt_instructors++;
            }
            else
            {
                alert('На группу можно не больше 5 инструкторов');
            }

        })
    /**
     * Удаление селекта с инструкторами
     */
        .on('click', '.del_instructor', function(e) {
            e.preventDefault();
            $(this).closest('.input-append').remove();
            cnt_instructors--;
        })
    /**
     * Добавление строки в таблице с расписанием занятий
     */
        .on('click', '#add_lessons', function(e) {
            e.preventDefault();
            var table = $('.table'),
                tbody = table.find('tbody'),
                tr = tbody.find('tr').first(),
                new_tr = tr.clone();
            alert(cnt_lessons);
            if (cnt_lessons < 5)
            {
                cnt_lessons++;
                new_tr.addClass('new_tr').find('td').last().html('<a href="#" class="btn btn-danger remove_lessons"><i class="icon-remove"></i></a>');
                var inp = new_tr.find('input'),
                    select = new_tr.find('select');
                $.each(inp, function() {
                    $(this).val('').attr('name', 'lessons['+(cnt_lessons)+']['+$(this).attr('class')+']');
                });
                select.val('').attr('name', 'lessons['+(cnt_lessons)+']['+select.attr('class')+']');
                tbody.append(new_tr);
            }
        })
    /**
     * Удаление строки в таблице с расписанием занятий
     */
        .on('click', '.remove_lessons', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();

            var table = $('.table'),
                tbody = table.find('tbody'),
                tr = tbody.find('tr');

            $.each(tr, function(k, v) {

                var field_inp = $(this).find('input'),
                    field_slct = $(this).find('select'),
                    num = ++k;

                field_slct.each(function() {
                    $(this).attr('name', 'lessons['+(num)+']['+$(this).attr('class')+']');
                });

                field_inp.each(function() {
                    $(this).attr('name', 'lessons['+(num)+']['+$(this).attr('class')+']');
                });

            });

            cnt_lessons--;
        });

    /**
     * Отправка формы изменение/добавление данных
     */
    $('#group_form').on('submit', function(e) {
        e.preventDefault();

        var $this = $(this);

        $.ajax({
            type : 'POST',
            url  : $this.attr('action'),
            data : $this.serialize(),
            dataType : 'json',
            beforeSend : function() {
                console.log($this.serialize());
            },
            success : function(response) {
                if (response.status == 'success' || response.status == 'error')
                {
                    message($('.container'), response.msg, response.status);
                    $('#groups').find('input:checkbox:checked').prop('checked', false).trigger('click');
                }
            },
            error : function(request) {
                if (request.status == '200') {
                    console.log('Исключение: ' + request.responseText);
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }
        });
    });

    /**
     * Выбор группы из списка и подгрузка ее данных
     */
    groups.on('click', 'input:checkbox', function() {

        var group_block = $('#groups'),
            $this = $(this),
            form = $('#group_form');

        if ($(this).is(":checked")) {
            var group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(group).prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", true);
            return;
        }

        $('#group_id').val($this.val());

        $.ajax({
            type : 'POST',
            url  : group_block.data('url'),
            data : {
                csrf : group_block.prev('input').val(),
                id : $this.val()
            },
            dataType : 'json',
            beforeSend : function() {
                group_block.find('.loader').remove();
                $this.parent().append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');
                form.find('input,select').each(function() {
                    if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                        if ($(this).attr('type') == 'checkbox')
                            $(this).prop("checked", false);
                        else
                            $(this).val('');
                });
            },
            success : function(response) {
                if (response.status == 'success')
                {
                    var field = '',
                        first_inst = $('.instructors_slct').find('.input-append').first(),
                        first_tr = $('.table').find('tbody').find('tr').first();
                    $('.instructors_slct').find('.new_slct').remove();
                    $('.table').find('.new_tr').remove();
                    $.each(response.data, function(key, value) {
                        field = form.find('[name="'+key+'"]');
                        if (field.attr('type') == 'checkbox') {
                            (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
                        } else {
                            if (key == 'instructors')
                            {
                                var new_slct,
                                    i = 0;
                                cnt_instructors = 1;

                                $.each(value, function(k, v)
                                {
                                    if (i == 0)
                                    {
                                        first_inst.find('select').val(v);
                                    }
                                    else
                                    {
                                        new_slct = first_inst.clone();
                                        new_slct.find('a').remove();
                                        new_slct.addClass('new_slct').append('<a href="#" class="btn btn-danger del_instructor" style="margin-left: 15px"><i class="icon-remove"></i></a>').find('select').val(v);
                                        new_slct.insertAfter(first_inst);
                                        cnt_instructors++;
                                    }
                                    i++;
                                });
                            }
                            else if (key == 'lessons')
                            {
                                var new_tr,
                                    pole,
                                    num;
                                cnt_lessons = 1;
                                $.each(value, function(k, v) {

                                    if (k > 0)
                                    {
                                        new_tr = first_tr.clone();
                                        new_tr.addClass('new_tr').find('td').last().html('<a href="#" class="btn btn-danger remove_lessons"><i class="icon-remove"></i></a>');
                                        $('.table').find('tbody').append(new_tr);
                                        cnt_lessons+=1;
                                        num = ++k;
                                    }

                                    $.each(v, function(index, p) {
                                        if (k == 0)
                                        {
                                            first_tr.find('.'+index).val(p);
                                        }
                                        else if (new_tr.length > 0) {
                                            pole = new_tr.find('.'+index);
                                            pole.attr('name', 'lessons['+(num)+']['+index+']');
                                            pole.val(p);
                                        }
                                    });

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
                $this.parent().find('.loader').remove();
            },
            error : function(request) {
                if (request.status == '200') {
                    console.log('Исключение: ' + request.responseText);
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }
        });

    });

    if (groups.find('label').length == 0) {
        groups.html('<div class="text-center">Групп нет</div>');
    }
    else
        groups.find('input:checkbox').first().trigger('click');

});