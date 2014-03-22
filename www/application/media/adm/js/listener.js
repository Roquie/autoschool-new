$(function() {

    var body = $('body');

    $("input:checkbox").on('click', function() {

        if ($(this).is(":checked")) {
            var group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(group).prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", true);
            return;
        }

        $('#user_id').val($(this).val())

        var f_statement = $('#statement'),
            listeners = $('#listeners');

        listeners.find('.loader').remove();
        $(this).parent().append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

        f_statement.find('input,select').each(function() {
            if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                $(this).val('');
        });

        $.post(
            listeners.data('url'),
            {
                csrf : listeners.prev('input').val(),
                user_id : $(this).val()
            },
            function(response)
            {
                if (response.status == 'success')
                {
                    $.each(response.data.listener, function(key, value) {
                        f_statement.find('[name="'+key+'"]').val(value);
                    });
                }
                if (response.status == 'error')
                {

                }
                listeners.prev('input').val(response.csrf);
                listeners.find('.loader').remove();
            },
            'json'
        );

    });

    $('#listeners').find('input:checkbox').first().trigger('click');

    /*
     * Настройки для календаря
     * @type {{monthNames: Array, monthNamesShort: Array, dayNames: Array, dayNamesMin: Array}}
     */
    $.datepicker.regional['ru'] = {
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
            'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
    };

    $.datepicker.setDefaults($.datepicker.regional['ru']);

    $('.datepicker').datepicker({
        maxDate: "+0D",
        nextText: "&raquo;",
        prevText: "&laquo;",
        yearRange: "1950:<?=date('Y')?>",
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true
    }).mask('99.99.9999');

    // Отображение календаря при нажатии на иконку календаря
    body
        .on('click', '#calendar', function() {
            $(this).closest('.input-append').find('input').datepicker( "show" );
        })
        .on('click', '.btns > a', function() {
            $('.btns').find('a').removeClass('active');
            $(this).addClass('active');
        });

    $(".telephone").mask("8 (999) 999-99-99");

/*
    $('#select2').on('change', function() {

        var $this = $(this),
            block = $('#listeners');

        block.html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

        $.post(
            $this.data('url'),
            {
                csrf : $this.prev('input').val(),
                group_id : $this.val()
            },
            function(response)
            {
                if (response.status == 'success')
                {
                    block.html(response.data);
                }
                if (response.status == 'error')
                {

                }
                $this.prev('input').val(response.csrf);
            },
            'json'
        );

    });

    $('#select3').on('change', function() {

        var $this = $(this),
            block = $('#listeners');

        block.html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

        $.post(
            $this.data('url'),
            {
                csrf : $this.prev('input').val(),
                group_id : $this.val()
            },
            function(response)
            {
                if (response.status == 'success')
                {
                    block.html(response.data);
                }
                if (response.status == 'error')
                {

                }
                $this.prev('input').val(response.csrf);
            },
            'json'
        );

    });*/
});