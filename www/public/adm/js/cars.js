/**
 * Created by mac on 15.06.14.
 */
$(function() {

    var body = $('body'),
        cars = $('#cars'),
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

            var cars = $('#cars'),
                form = $('#car_form');

            if ($(this).hasClass('add'))
            {
                cars.find('input').prop('disabled', true);

                form.find('input,select').each(function() {
                    if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                        if ($(this).attr('type') == 'checkbox')
                            $(this).prop("checked", false);
                        else
                            $(this).val('');
                });
                form.find('#button').data('action', 'add');
            }
            else if ($(this).hasClass('edit'))
            {
                cars.find('input').prop('disabled', false);
                cars.find('input:checkbox:checked').prop('checked', false).trigger('click');
                form.find('#button').data('action', 'edit');
            }
            form.attr('action', $(this).data('url'));

        });

    /**
     * Отправка формы изменение/добавление данных
     */
    $('#car_form').on('submit', function(e) {
        e.preventDefault();

        var $this = $(this),
            btn = $this.find('#button'),
            cars = $('#cars');

        $.ajax({
            type : 'POST',
            url  : $this.attr('action'),
            data : $this.serialize(),
            dataType : 'json',
            beforeSend : function() {
                console.log($this.serialize());
                un_message();
                wait(btn);
            },
            success : function(response) {
                if (response.status == 'success' || response.status == 'error')
                {
                    message($('.wrap_car'), response.msg, response.status);
                }
                if (response.status == 'success')
                {
                    if (btn.data('action') == 'add')
                    {
                        cars.append(
                            '<label class="checkbox">' +
                                '<input type="checkbox" value="'+response.data.id+'" name="group_name"/>' +
                                '<span class="pull-left">'+response.data.name+'</span>' +
                                '</label>'
                        );
                    }
                    else
                    {
                        cars.find('input:checkbox:checked').next().text($this.find('[name="name"]').val());
                    }
                    $('.edit').trigger('click');
                }
                after_wait(btn);
            },
            error : function(request) {
                if (request.status == '200') {
                    console.log('Исключение: ' + request.responseText);
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
                after_wait(btn);
            }
        });
    });

    /**
     * Выбор группы из списка и подгрузка ее данных
     */
    cars.on('click', 'input:checkbox', function() {

        var group_block = $('#cars'),
            $this = $(this),
            form = $('#car_form'),
            btn = form.find('#button'),
            btn_del_group = $('.del_car');

        if ($(this).is(":checked")) {
            var group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(group).prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", true);
            return;
        }

        $('#car_id').val($this.val());

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
                    var field = null;

                    btn_del_group.attr('href', btn_del_group.data('url')+group_block.find('input:checkbox:checked').val());

                    $.each(response.data, function(key, value) {
                        field = form.find('[name="'+key+'"]');
                        if (field.attr('type') == 'checkbox') {
                            (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
                        } else {
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

    if (cars.find('label').length == 0) {
        cars.html('<div class="text-center">Машин нет</div>');
    }
    else
        cars.find('input:checkbox').first().trigger('click');

});