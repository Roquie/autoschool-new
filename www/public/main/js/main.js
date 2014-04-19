$(function() {

    var cnt_click = 0;

    /**
     * выезжающая панель "Новости"
     */
    $("#slide-left").pageSlide({
        width : '260px'
    }).on('click', function(e) {
        e.preventDefault();
        if (!$(this).data('load')) {
            var action = $(this).data('url');
            $('#pageslide-content').load(action);
            $(this).data('load', true);
        }
    });

    /**
     * Обновление новостей
     */
    $('body').on('click', '#update-slide', function(e) {
        var action = $('#slide-left').data('url'),
            obj = $('#slide-left').attr('href');
        if (cnt_click < 5) {
            $('#pageslide-content').html($(obj).html()).load(action);
            $('#slide-left').data('load', true);
            cnt_click++;
        }
        return false;
    }).on('click', '#close-slide', function(e) { // Кнопка закрыть боковую панель новостей
        $("#slide-left").pageSlide('close');
        return false;
    }).on('click', '#forgot', function(e) {
        e.preventDefault();
        $(this).closest('#popup').find('form').toggle();
    });

    /**
     * увеличил скорость загрузки главной, петем замены карты на картинку.
     * при клике на картинку, подгружается реальная/живая карта гугла.
     * @type {string}
     */
    var mapframe = '<iframe src="https://mapsengine.google.com/map/embed?mid=zKAGAuy1eND8.kCKg1x6jjPxk" width="100%" height="330" frameborder="0"></iframe>',
        wrap = $('#google_map');

    $(wrap).on('click', function()
    {
        wrap.html('');
        wrap.html(mapframe);
    });

});
