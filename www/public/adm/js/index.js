/**
 * Created by mac on 12.04.14.
 */
$(function() {

    var body = $('body');

    body
        .on('click', '.btns > a', function() {
            var data = $('.l_data'),
                listeners = $('.l_fio');
            $('.btns').find('a').removeClass('active');
            $(this).addClass('active');
            if ($(this).attr('href') == '#tab2') {
                data.css({'height' : '744px'});
                listeners.css({'height' : '584px'});
            } else {
                data.css({'height' : '1464px'});
                listeners.css({'height' : '1304px'});
            }
        });

});

function fn_callback(response, $this, f_statement, f_contract, listeners) {
    if (response.status == 'success')
    {
        $.each(response.data.listener, function(key, value) {
            field = f_statement.find('[name="'+key+'"]');
            if (key == 'is_individual') {
                $('#is_individual').val(value);
            }
            if (key == 'id') {
                $('#listener_id').val(value);
            }
            if (field.attr('type') == 'checkbox') {
                (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
            } else {
                field.val(value);
            }
        });
        $.each(response.data.contract, function(key, value) {
            field = f_contract.find('[name="'+key+'"]');
            if (field.attr('type') == 'checkbox') {
                (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
            } else {
                field.val(value);
            }
        });
        $('.selected_listener').find('p').text($this.next('span').text());
    }
    if (response.status == 'error')
    {
    }
    listeners.prev('input').val(response.csrf);
    listeners.find('.loader').remove();
}