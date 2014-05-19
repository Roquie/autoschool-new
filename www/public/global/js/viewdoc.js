$(function() {
    /**
     * post запрос на создание временного документа
     * -
     * формирование ссылки для просмотра документа в браузере
     */
    $('.view_doc_createtmpfile').on('click', function() {
        $.post(
            $(this).data('url'),
            function(response)
            {
                $('#docs_viewer').attr('src', "http://view.officeapps.live.com/op/view.aspx?src="+response.data.url+"/"+response.data.file);
            },
            'json'
        );
    });

    /**
     * Перенос модального окна за пределы видимости div#wrap
     */
    $('#view_doc_modal').appendTo($('body'));

    var type_lookjs = getParameterByName('lookjs');

    if(type_lookjs)
    {
        setTimeout(function()
        {
            $('[data-type='+type_lookjs+']').trigger('click');
        }, 600);
    }


});