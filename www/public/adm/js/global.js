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
                data.css({'height' : '1444px'});
                listeners.css({'height' : '1284px'});
            }
        });

});