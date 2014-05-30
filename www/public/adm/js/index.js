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
                data.css({'height' : '1530'});
                listeners.css({'height' : '1369'});
            }
        });

});

function fn_callback(response, $this, f_statement, f_contract, listeners) {
    if (response.status == 'success')
    {
        var field = '',
            slct = $('#staff_id');

        slct.empty();


        if (typeof response.data.instructors != 'undefined')
        {
            $.each(response.data.instructors, function(key, value) {
                slct.prepend("<option value='"+key+"'>"+value+"</option>");
            });
        }
        else
        {
            slct.prepend("<option value='' selected='selected'> --- </option><option value=''>Добавьте группе инструкторов</option>");
        }

        $.each(response.data.listener, function(key, value) {
            field = f_statement.find('[name="'+key+'"]');
            if (key == 'is_individual') {
                $('.is_individual').val(value);
            }
            else if (key == 'id') {
                $('.listener_id').val(value);
            }
            else if (field.attr('type') == 'checkbox') {
                (value == '0') ? field.prop("checked", false) : field.prop("checked", true);
            } else {
                field.val(value);
            }
        });
        $.each(response.data.contract, function(key, value) {
            field = f_contract.find('[name="'+key+'"]');
            if (field.attr('type') == 'checkbox') {
                (value == 0) ? field.prop("checked", false) : field.prop("checked", true);
            } else {
                field.val(value);
            }
        });
        $('.selected_listener').find('p').text($this.next('span').text());
        $('#listener_slctd').text($this.next('span').text());
        $('#group_slctd').text($('#group_id :selected').text());
    }
    if (response.status == 'error')
    {
    }
    listeners.prev('input').val(response.csrf);
    listeners.find('.loader').remove();
}