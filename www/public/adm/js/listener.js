$(function() {

    var body = $('body');

    /**
     *  Загрузка данных слушателя
     */
    $('#listeners').on('click', 'input:checkbox', function() {

        if ($(this).is(":checked")) {
            var group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(group).prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", true);
            return;
        }

        $('#user_id').val($(this).val());

        var f_statement = $('#statement'),
            f_contract = $('#contract'),
            listeners = $('#listeners'),
            $this = $(this);

        $.ajax({
            type : 'POST',
            url  : listeners.data('url'),
            data : {
                csrf : listeners.prev('input').val(),
                user_id : $this.val()
            },
            dataType : 'json',
            beforeSend : function() {
                listeners.find('.loader').remove();
                $this.parent().append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

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

            },
            success : function(response) {
                fn_callback(response, $this, f_statement, f_contract, listeners);
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

    if ($('#listeners').find('label').length == 0)
        $('#listeners').html('<div class="text-center">Слушателей нет</div>');
    else
        $('#listeners').find('input:checkbox').first().trigger('click');



    $('#select2').on('change', function() {

        var $this = $(this),
            block = $('#listeners'),
            f_statement = $('#statement'),
            f_contract = $('#statement');

        $.ajax({
            type : 'POST',
            url  : $this.data('url'),
            data : {
                csrf : block.prev('input').val(),
                group_id : $this.val()
            },
            dataType : 'json',
            beforeSend : function() {
                block.html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

                f_statement.find('input,select').each(function() {
                    if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                        $(this).val('');
                });

                f_contract.find('input,select').each(function() {
                    if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                        $(this).val('');
                });
            },
            success : function(response){
                block.html('');
                if (response.status == 'success')
                {
                    if (response.data == '') {
                        block.html('<div class="text-center">Слушателей нет</div>');
                    } else {
                        block.html(response.data);
                        $('#listeners').find('input:checkbox').first().trigger('click');
                    }
                }
                if (response.status == 'error')
                {
                    message($('.container'), response.msg, response.status);
                }
                block.prev('input').val(response.csrf);
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

    $('#statement, #contract').on('submit', function(e) {
        e.preventDefault();
        var $this = $(this),
            btn = $this.find('#button');

        btn.html(btn.text() + '&nbsp;<i class="icon-refresh icon-spin"></i>');

        $.ajax({
            type : 'POST',
            url  : $this.attr('action'),
            data : $this.serialize(),
            dataType : 'json',
            beforeSend : function() {
                $('.alert').remove();
            },
            success : function(response) {
                if (response.status == 'success' || response.status == 'error')
                {
                    message($('.container'), response.msg, response.status);
                }
                if (response.status == 'success') {
                    $('#select2').trigger('change');
                }
                btn.find('i').remove();
            },
            error : function(request) {
                if (request.status == '200') {
                    console.log('Исключение: ' + request.responseText);
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
                btn.find('i').remove();
            }
        });
    });

});

