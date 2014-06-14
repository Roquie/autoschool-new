/**
 * Created by mac on 13.03.14.
 */
$(function() {

    $('#reset').on('click', function() {
        $('form').find('.input-block-level').each(function() {
            $(this).removeAttr('value');
        });
    });

    //$("#telephone_1, #telephone_2").mask("8 (999) 999 99 99");



    $('#check_google').on('click', function()
    {
        if ($(this).is(':checked'))
        {
            $('#google_drive').find('input:lt(2)').prop('disabled', false);
        }
        else
        {
            $('#google_drive').find('input:lt(2)').prop('disabled', true);
        }
    });
});