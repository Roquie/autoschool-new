<?=HTML::style('adm/css/listeners.css')?>

<div class="container">

    <div class="row">
        <div class="span4">
            <h1><small>Новости для групп</small></h1>
        </div>
    </div>

    <div class="row">
        <div class="span3 l_select_group">
            <div class="well" style="height: 760px">
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

                add_news.on('submit', function(e) {
                    e.preventDefault();
                    $.post(
                        $(this).closest('form').attr('action'),
                        $(this).serialize(),
                        function(response)
                        {
                            if (response.status == 'success')
                            {
                                list_news.append('<div id="thisnews"><legend>Тема: '+response.data.title+' </legend><p>'+response.data.message+'</p><hr style="border: 1px solid #e5e5e5"/></div>');

                                add_news.trigger('reset');

                                message($('.container'), response.msg, response.status);
                            }
                            if (response.status == 'error')
                            {
                                message($('.container'), response.msg, response.status);
                            }
                        },
                        'json'
                    );
                });




                $(groups).on('click', 'input:checkbox', function(){

                    $('#label_add').html('Оповестить слушателей группы '+$(this).next().html());

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
                            groups.append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

                        },
                        success : function(response) {
                            if (response.status == 'success')
                            {
                                list_news.html('');
                                $.each(response.data, function(key, value){
                                    list_news.append('<div id="thisnews"><legend>Тема: '+value.title+' </legend><p>'+value.message+'</p><hr style="border: 1px solid #e5e5e5"/></div>');
                                });

                            }
                            if (response.status == 'error')
                            {
                                list_news.html('');
                                list_news.append('<p style="text-align: center">'+response.msg+'</p>');
                            }
                            groups.prev('input').val(response.csrf);
                            groups.find('.loader').remove();
                        },
                        error : function(request)
                        {
                            if (request.status == '200')
                            {
                                console.log('Исключение: ' + request.responseText);
                            }
                            else
                            {
                                console.log(request.status + ' ' + request.statusText);
                            }
                        }
                    });

                });

                $('#groups').find('input:checkbox').first().trigger('click');


                function message(block, msg, type) {
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
            <div class="well" style="height: 130px">
                <h5 id="label_add" class="header_block">Оповестить слушателей группы</h5>
                <form id="add_news" action="<?=Route::to('admin', 'news#create')?>" method="post" accept-charset="utf-8" novalidate>
                    <input type="text" name="title" id="title" placeholder="Заголовок новости"/>
                    <textarea name="message" id="admin_msg" style="height: 44px; width: 483px; resize: none" placeholder="Введите новость..."></textarea>
                    <input type="hidden" name="group_id" id="group_id"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <input type="submit" style="margin: 12px 0  0 40px" class="btn btn-success" name="submit"/>
                </form>
            </div>
            <div class="well" style="height: 600px">
                <div id="list_news" class="wrapper" style="overflow-y: auto; height: 600px">

                </div>
            </div>
        </div>
    </div>

</div>