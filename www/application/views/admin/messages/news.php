<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::script('adm/js/news.js')?>
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