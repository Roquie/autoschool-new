
$(function() {

    $('#select2').on('change', function() {
        $('.chat').html('');
    });

});

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