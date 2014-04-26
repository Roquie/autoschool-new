/**
 * Created by mac on 26.04.14.
 */
function fn_success(response)
{
    message($('.container'), response.msg, response.status);
}

function fn_before()
{
    $('.chat').html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');
}

function fn_callback(response, $this, f_statement, f_contract, listeners)
{
    if (response.status == 'success')
    {
        $('.chat').html(response.data);
        $('.current_listener').text($this.parent().text());
    }
    if (response.status == 'error')
    {
    }
    listeners.find('.loader').remove();
}