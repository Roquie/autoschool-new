$(function() {

    var groups = $('#groups'),
        list_news = $('#list_news'),
        add_news = $('#add_news');

    list_news.on('click', '#remove_news', function(e)
    {
        var $this = $(this);

        e.preventDefault();
        $.post(
            $this.data('url'),
            {
                csrf: $this.data('csrf'),
                news_id: $this.data('id-news')
            },
            function(response)
            {
                if (response.status == 'success')
                {

                    $this.closest('.thisnews').remove();
                }

                message($('.container'), response.msg, response.status);
            },
            'json'
        );
    });

    add_news.on('submit', function(e)
    {
        e.preventDefault();

        var btn_submit = $('input[name="submit"]'),
            btn_loader = $('#btn_loader');

        btn_submit.hide();
        btn_loader.show();

        $.post(
            $(this).closest('form').attr('action'),
            $(this).serialize(),
            function(response)
            {
                if (response.status == 'success')
                {
                    list_news.prepend(response.data);
                    list_news.find('#empty_news').remove();
                    add_news.trigger('reset');

                    message($('.container'), response.msg, response.status);
                }
                if (response.status == 'error')
                {
                    message($('.container'), response.msg, response.status);
                }

                btn_loader.hide();
                btn_submit.show();
            },
            'json'
        );
    });



    $(groups).on('click', 'input:checkbox', function(){
        var $this = $(this);

        $('#group_name').html($(this).next().html());

        $('#group_id').val($(this).val());

        if ($(this).is(":checked"))
        {
            var checkbox_group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(checkbox_group).prop("checked", false);
            $(this).prop("checked", true);
        }
        else
        {
            $(this).prop("checked", true);
            return;
        }

        $.ajax({
            type : 'POST',
            url  : groups.data('url'),
            data : {
                csrf : groups.prev('input').val(),
                group_id : $(this).val()
            },
            dataType : 'json',
            beforeSend : function() {
                groups.find('.loader').remove();
                $this.parent().append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');
            },
            success : function(response) {
                if (response.status == 'success')
                {
                    list_news.html('');
                    list_news.append(response.data);
                }
                if (response.status == 'error')
                {
                    list_news.html('');
                    list_news.append('<div id="empty_news" class="well" style="height: 170px"><p>'+response.msg+'</p></div>');
                    message($('.container'), response.msg, response.status);
                }
                groups.prev('input').val(response.csrf);
                groups.find('.loader').remove();
            }
        });

    });

    groups.find('input:checkbox').first().trigger('click');

});