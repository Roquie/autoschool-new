/**
 * Created by mac on 12.04.14.
 */

var ok = '<i class="icon-ok"></i> ',
    cancel = '<i class="icon-remove"></i> ';

$(function() {

    var body = $('body');

    body
        .on('click', '#l_statement, #l_contract', function(e) {
            e.preventDefault();
            var data = $('.data'),
                listeners = $('.listeners');
            $('.btns').find('a').removeClass('active');
            $(this).addClass('active');
            if ($(this).attr('href') == '#tab2') {
                data.css({'height' : '764px'});
                listeners.css({'height' : '924px'});
            } else {
                data.css({'height' : '924px'});
                listeners.css({'height' : '1084px'});
            }
        })
        .on('click', '.d_status > a', function(e) {
            e.preventDefault();
        })
        //изменение статуса
        .on('click', '.click', function(e) {
            e.preventDefault();

            var btn = $('.click').index(this),
                status = $('.d_status').find('a'),
                progress = $('.bar'),
                $this = $(this),
                increase = $this.data('increase'),
                listeners = $('#listeners');

            $.ajax({
                type : 'POST',
                url  : $this.data('url'),
                data : {
                    csrf : listeners.prev('input').val(),
                    user_id : $('#listener_id').val(),
                    status : $this.data('status')
                },
                dataType : 'json',
                beforeSend : function() {
                    un_message();
                    status.addClass('disabled').removeClass('click');
                },
                success : function(response) {

                    if (response.status == 'success') {
                        status.find('i').remove();
                        status.addClass('disabled').removeClass('click').data('increase', false);

                        switch (btn) {
                            case 0 :
                                $this.addClass('click');
                                if (increase) {
                                    progress.animate({ width: $this.data('width') }, 0);
                                    $this.prepend(ok).data('increase', false).data('status', 0).removeClass('disabled');
                                    status.eq(1).addClass('click').removeClass('disabled').prepend(cancel).data('increase', true).data('status', 2);
                                } else {
                                    progress.animate({ width: '1%' }, 0);
                                    $this.removeClass('disabled').prepend(cancel).data('increase', true).data('status', 1);
                                }
                                break;
                            case 1 :
                                if (increase) {
                                    status.removeClass('disabled').addClass('click');
                                    progress.animate({ width: $this.data('width') }, 0);
                                    $this.prepend(ok).data('increase', false).data('status', 1);
                                    status.first().prepend(ok).data('increase', false).data('status', 0);
                                    status.last().data('increase', true).data('status', 3);
                                } else {
                                    progress.animate({ width: status.first().data('width') }, 0);
                                    $this.removeClass('disabled').addClass('click').prepend(cancel).data('increase', true).data('status', 2);
                                    status.first().removeClass('disabled').addClass('click').prepend(ok).data('increase', false).data('status', 0);
                                }
                                break;
                            case 2 :
                                if (increase) {
                                    progress.animate({ width: $this.data('width') }, 0);
                                    $this.prepend(ok).data('increase', false);
                                    listeners.find('label[id="'+$('#listener_id').val()+'"]').remove();
                                    listeners.find('input:checkbox').first().trigger('click');
                                }
                                break;
                        }
                    }

                    if (response.status == 'success' || response.status == 'error') {
                        message($('.container'), response.msg, response.status);
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

        })
        //удаление слушателя
        .on('click', '.enb_dis', function(e) {
            e.preventDefault();

            var listeners = $('#listeners'),
                $this = $(this),
                f_statement = $('#statement'),
                f_contract = $('#contract');

            $.ajax({
                type : 'POST',
                url  : $this.data('url'),
                data : {
                    csrf : listeners.prev('input').val(),
                    user_id : $('#del_id').val()
                },
                dataType : 'json',
                beforeSend : function() {
                    un_message();
                },
                success : function(response) {
                    if (response.status == 'success') {
                        listeners.find('label[id="'+$('#listener_id').val()+'"]').remove();
                        if (listeners.find('label').length == 0) {
                            f_statement.find('input,select').each(function() {
                                if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                                    if ($(this).attr('type') == 'checkbox')
                                        $(this).prop("checked", false);
                                    else
                                        $(this).val('');
                            });

                            f_contract.find('input,select').each(function() {
                                if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                                    if ($(this).attr('type') == 'checkbox')
                                        $(this).prop("checked", false);
                                    else
                                        $(this).val('');
                            });
                            listeners.html('<div class="text-center">Слушателей нет</div>');
                            $('.bar').animate({ width: '0%' }, 0);
                            $('.d_status').find('a').addClass('disabled').find('i').remove();
                        }
                        else
                            listeners.find('input:checkbox').first().trigger('click');
                    }

                    if (response.status == 'success' || response.status == 'error') {
                        message($('.container'), response.msg, response.status);
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
        })
        //галочка кто будет заказчиком
        .on('click', '#is_individual', function() {
            var $this = $(this),
                form = $this.parent().parent();

            $('.is_individual').val($this.is(':checked') ? 0 : 1);

            $.ajax({
                type : 'POST',
                url  : form.attr('action'),
                data : form.serialize(),
                dataType : 'json',
                beforeSend : function() {
                    un_message();
                },
                success : function(response) {
                    if (response.status == 'success' || response.status == 'error')
                    {
                        message($('.container'), response.msg, response.status);
                    }
                    if (response.status == 'success')
                        $('#listeners').find('input:checkbox:checked').prop('checked', false).trigger('click');
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

    $('#add_desc_status').on('submit', function(e) {
        e.preventDefault();

        var $this = $(this),
            btn = $this.find('button[type="submit"]');

        $.ajax({
            type : 'POST',
            url  : $this.attr('action'),
            dataType : 'json',
            data : {
                csrf : $('#listeners').prev('input').val(),
                user_id : $('#listener_id').val(),
                description_status : $('#description_status').val()
            },
            beforeSend : function() {
                un_message();
                wait(btn);
            },
            success : function(response) {
                if (response.status == 'success') {
                    message($('.modal-body'), response.msg, response.status);
                }
                if (response.status == 'error') {
                    var errors = '';
                    $.each(response.data, function(key, value) {
                        errors += value + '<br>';
                    });
                    message($('.modal-body'), errors, response.status);
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

});

function fn_callback(response, $this, f_statement, f_contract, listeners) {
    if (response.status == 'success')
    {

        var status = $('.d_status').find('a'),
            progress = $('.bar'),
            field = '';

        status.find('i').remove();
        status.removeClass('disabled').data('increase', false);

        switch (response.data.listener.status) {
            case '0' :
                progress.animate({ width: '1%' }, 0);
                status.removeClass('click').addClass('disabled');
                status.first().addClass('click').removeClass('disabled').prepend(cancel);
                status.first().data('increase', true).data('status', 1);
                break;

            case '1' :
                progress.animate({ width: status.first().data('width') }, 0);
                status.last().removeClass('click').addClass('disabled');
                status.first().addClass('click').prepend(ok).data('status', 0);
                status.eq(1).data('increase', true).addClass('click').prepend(cancel).data('status', 2);
                break;

            case '2' :
                progress.animate({ width: status.eq(1).data('width') }, 0);
                status.addClass('click');
                status.first().prepend(ok).data('status', 0);
                status.eq(1).prepend(ok).data('status', 1);
                status.last().prepend(cancel).data('increase', true).data('status', 3);

                break;
        }

        $.each(response.data.listener, function(key, value) {
            field = f_statement.find('[name="'+key+'"]');
            if (key == 'is_individual') {
                $('.is_individual').val(value);
                if (value == 0) {
                    $('#is_individual').prop('checked', true);
                    f_contract.hide();
                } else {
                    $('#is_individual').prop('checked', false);
                    f_contract.show();
                }
            }
            if (key == 'id') {
                $('#listener_id').val(value);
            }
            if (key == 'description_status') {
                $('#description_status').val(value);
            }
            if (field.attr('type') == 'checkbox') {
                (value == 0) ? field.prop("checked", false) : field.prop("checked", true);
            } else {
                field.val(value);
            }
        });

        $('.user_id').val($('#del_id').val());

        $.each(response.data.contract, function(key, value) {
            field = f_contract.find('[name="'+key+'"]');
            if (field.attr('type') != 'hidden')
                if (field.attr('type') == 'checkbox') {
                    (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
                } else {
                    field.val(value);
                }
        });
        $('.selected_listener').find('p').text($this.next('span').text());
        $('#listener_slctd').text($this.next('span').text());
        $('.group_slctd').text('---');
    }
    if (response.status == 'error')
    {
    }
    listeners.prev('input').val(response.csrf);
    listeners.find('.loader').remove();
}