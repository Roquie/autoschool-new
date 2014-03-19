/**
 * Created by mac on 13.03.14.
 */
$(function() {

    $('#reset').on('click', function() {
        $('form').find('.input-block-level').each(function() {
            $(this).removeAttr('value');
        });
    });

    $("#telephone_1, #telephone_2").mask("+7 (999) 999 99 99");


});