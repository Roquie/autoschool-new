/**
 * Developer: V. Melnikov
 * Date: 27.02.14
 * Time: 11:05
 */
$(function() {



    $(".sms_sender").inputmask({ "mask": "8 (999) 999-99-99, ", "repeat": 100, "greedy": false });

    $('#many_tels').autosize();



    var body = $('body'),
        maxLength = 140;

    $('#user_name').popupWin({
        edgeOffset : 30,
        delay : 400
    });

    $('#sendsms_modal').on('click', function()
    {
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



    $('#add_tweet, #send_sms_form').on('submit', function(e) {
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