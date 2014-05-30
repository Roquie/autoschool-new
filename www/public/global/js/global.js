/**
 * Created by mac on 06.04.14.
 */
$(function() {
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
    $('body')
        .on('click', '#calendar', function() {
            $(this).closest('.input-append').find('input').datepicker( "show" );
        });

    $("[rel='tooltip']").tooltip({
        container: 'body'
    });


    $(".telephone").inputmask("+7 (999) 999-99-99");
});

function getParameterByName(name)
{
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function message(block, msg, type)
{
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

function un_message() {
    $('.alert').remove();
}

function wait(btn)
{
    btn.html('<i class="icon-refresh icon-spin"></i> ' + btn.text()).prop('disabled', true);
}

function after_wait(btn)
{
    btn.prop('disabled', false).find('i').remove();
}