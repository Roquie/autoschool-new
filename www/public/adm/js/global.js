/**
 * Developer: V. Melnikov
 * Date: 27.02.14
 * Time: 11:05
 */
$(function() {


    $('.datepicker_adm').datepicker({
        nextText: "&raquo;",
        prevText: "&laquo;",
        yearRange: "1950:<?=date('Y')?>",
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true
    }).mask('99.99.9999');

    /*$(".sms_sender").inputmask({ "mask": "8 (999) 999-99-99, ", "repeat": 100, "greedy": false });

    $('#many_tels').autosize();*/



    var body = $('body'),
        maxLength = 140;

    $('#user_name').popupWin({
        edgeOffset : 30,
        delay : 400
    });

    $('#sendsms_modal').on('click', function()
    {
        $.ajax({
            type : 'GET',
            url  : $('#sms_wrap').data('url'),
            dataType : 'json',
            beforeSend : function() {},
            success : function(response)
            {
                $('#sms_wrap').html(response.data);
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

        $('#sendsms_balance').trigger('click');
    });

    $('#sendsms_balance').on('click', function(e)
    {
        e.preventDefault();

        var $this = $(this),
            sum = $('#sum_sendsms_balance');

        $.ajax({
            type : 'GET',
            url  : $this.data('url'),
            dataType : 'json',
            beforeSend : function() {},
            success : function(response)
            {
                sum.html(response.msg);
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

    $('.sms_list_listeners').on('click', '#sms_clicked_all', function()
    {
        //$('input[name=listeners_sms_names]:checkbox').not(this).prop('checked', this.checked);
        $('input[name=listeners_sms_names]:checkbox').trigger('click');
    });

    $('.sms_list_listeners').on('click', 'input[name=listeners_sms_names]', function()
    {
        var tel = $(this).data('tel'),
            id_listener = $(this).val(),
            send_to = $('#sendsms_tels');


        if ($(this).prop('checked'))
        {
            send_to.append(
                '<span class="sms-listener-'+ id_listener +'">' + $(this).parent().find('span').text() + ' ( ' + tel + ' ), <br></span>'
            );

            var height = send_to[0].scrollHeight;
            send_to.scrollTop(height);
        }
        else
        {
            $('#sendsms_tels').find('.sms-listener-' + id_listener).remove();
        }


    });

    $('#send_sms_form').on('submit', function(e) {
        e.preventDefault();

        var $this = $(this),
            btn = $this.find('button[type="submit"]');

        $this.find('input[name=to]').val($('#sendsms_tels').text());

        $.ajax({
            type : 'POST',
            url  : $this.attr('action'),
            dataType : 'json',
            data : $this.serialize(),
            beforeSend : function() {
                un_message();
                wait(btn);
            },
            success : function(response) {
                if (response.status == 'success') {
                    message($('.modal-body'), response.msg, response.status);
                    $this[0].reset();
                    $('.message').html('');

                    setInterval(function()
                    {
                        $('#sendsms_balance').trigger('click');

                    }, 800);
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

    $('#add_tweet').on('submit', function(e) {
        e.preventDefault();

        var $this = $(this),
            btn = $this.find('button[type="submit"]');

        $.ajax({
            type : 'POST',
            url  : $this.attr('action'),
            dataType : 'json',
            data : $this.serialize(),
            beforeSend : function() {
                un_message();
                wait(btn);
            },
            success : function(response) {
                if (response.status == 'success') {
                    message($('.modal-body'), response.msg, response.status);
                    $this[0].reset();
                    $('.message').html('');
                    $('#sendsms_balance').trigger('click');
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

    $('.modal')
        .on('show', function() {
            body.css({'overflow-y' : 'hidden'});
        })
        .on('hide', function() {
            body.css({'overflow-y' : 'scroll'});
        });

    $('#add_tweet > .message')
        .on('keydown', function() {
            var curLength = $(this).val().length,
                remaning = maxLength - curLength,
                counter = $('.tweet-counter');

            if (remaning < 0) remaning = 0;

            if (remaning >= 0)
                counter.text(remaning);
        }).on('keyup', function() {
            $(this).trigger('keydown');
        });

});