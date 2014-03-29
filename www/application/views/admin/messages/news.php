<?=HTML::style('adm/css/listeners.css')?>
<style type="text/css">
    .loader
    {
        float: right;
        margin-right: 5px;
    }

    .thisnews
    {
        /* @todo: fix l_info well size */
        height: 130px !important;
    }
    .thisnews h2
    {
        margin: 0 0 10px 0;
        line-height: 10px;
        font-size: 13pt;
        color: #4e4e4e;
    }
    .thisnews p
    {
        display: block;
        height: 80px;
    }

    .thisnews .bottom
    {
        border-top: 1px solid darkgray;
        padding: 5px 0 5px 0;
        height: 20px;
    }
    .form-horizontal .controls
    {
        margin-left: 90px;
    }
    .form-horizontal .control-label
    {
        width: 10px;
    }
</style>
<div class="container">

    <div class="row">
        <div class="span4">
            <h1><small>Новости для групп</small></h1>
        </div>
    </div>

    <div class="row">
        <div class="span3 l_select_group">
            <div class="well" style="height: 760px;">
                <h5 class="header_block">Список групп</h5>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div style="overflow-y: auto" id="groups" data-url="<?=URL::site('admin/news/get_news')?>">
                    <?=View::factory('admin/html/groups', compact('list_groups'))?>
                </div>
            </div>
        </div>

        <script type="text/javascript">
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
                                //list_news.append('<div id="thisnews"><legend>Тема: '+response.data.title+' </legend><p>'+response.data.message+'</p><hr style="border: 1px solid #e5e5e5"/></div>');
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

                //@todo: перенести это чадо в global.js, чтобы юзать во всей админке
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


            });
        </script>
        <div class="span9 l_info">
            <div class="well" style="height: 190px">
                <a href="#" id="group_name" title="это группа" class="badge badge-info pull-right">01-14</a>
                <h5 class="header_block">Оповестить слушателей</h5>
                <form class="form-horizontal" id="add_news" action="<?=Route::to('admin', 'news#create')?>" method="post" accept-charset="utf-8" novalidate>
                    <div class="control-group">
                        <label class="control-label" for="title">Заголовок</label>
                        <div class="controls">
                            <input type="text" class="span6" name="title" id="title"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="admin_msg">Текст</label>
                        <div class="controls">
                            <textarea name="message" id="admin_msg" style="height: 44px; width: 483px; resize: none"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div class="row">
                                <div class="span2">
                                    <input type="hidden" name="group_id" id="group_id"/>
                                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                    <button id="btn_loader" style="display: none;" class="btn btn-success" disabled><i class="icon-refresh icon-spin icon-small"></i> &nbsp;Секунду...</button>
                                    <input type="submit" class="btn btn-success" name="submit" value="Отправить"/>
                                </div>
                                <div class="span4">
                                    <label class="checkbox">
                                        <input type="checkbox" name="email_send" checked/>
                                        Рассылка уведомлений по email
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="list_news" style="overflow-y: auto; height: 550px">
                <!-- тута новостеньки ^___^-->
            </div>

        </div>
    </div>

</div>