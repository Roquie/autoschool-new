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
                <div style="overflow-y: auto">
                    <?=View::factory('admin/html/groups', compact('list_groups'))?>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                $('#add_news').on('submit', function(e) {
                    e.preventDefault();

                    $.post(
                        $(this).closest('form').attr('action'),
                        $(this).serialize(),
                        function(response)
                        {
                            if (response.status == 'success')
                            {
                                $('#success_msg').find('p').html(response.msg);
                                $('#success_msg').show();
                            }
                            if (response.status == 'error')
                            {
                                $('#error_msg').find('p').html(response.msg);
                                $('#error_msg').show();
                            }
                        },
                        'json'
                    );
                });
            });
        </script>
        <div class="span9 l_info">
            <div id="error_msg" class="alert alert-danger" style="display: none">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p></p>
            </div>
            <div id="success_msg" class="alert alert-success" style="display: none">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p></p>
            </div>
            <div class="well" style="height: 130px">
                <h5 class="header_block">Оповестить слушателей группы 01-14</h5>
                <form id="add_news" action="<?=Route::to('admin', 'news#create')?>" method="post" accept-charset="utf-8" novalidate>
                    <input type="text" name="title" id="title" placeholder="Заголовок новости"/>
                    <textarea name="msg" id="admin_msg" style="height: 44px; width: 483px; resize: none" placeholder="Введите новость..."></textarea>
                    <input type="hidden" name="group_id" id="group_id"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <input type="submit" style="margin: 12px 0  0 40px" class="btn btn-success" name="submit"/>
                </form>
            </div>
            <div class="well" style="height: 600px">


            </div>
        </div>
    </div>

</div>