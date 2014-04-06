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


    $(".telephone").mask("8 (999) 999-99-99");
});