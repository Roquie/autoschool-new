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
        })
        .on('click', 'input:checkbox', function(){


            if ($(this).is(":checked")) {
                var group = "input:checkbox[name='" + $(this).attr("name") + "']";
                $(group).prop("checked", false);
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", true);
                return;
            }


        });

});