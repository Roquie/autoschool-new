/**
 * Developer: V. Melnikov
 * Date: 27.02.14
 * Time: 11:05
 */
$(function() {

    var body = $('body');

    $('#user_name').popupWin({
        edgeOffset : 30,
        delay : 400
    });

});

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