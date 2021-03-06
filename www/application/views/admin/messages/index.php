<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::style('global/css/messages.css')?>
<?=HTML::script('adm/js/listener.js')?>
<?=HTML::script('adm/js/help.js')?>
<?=HTML::script('global/js/messages.js')?>

<div class="container">

    <div class="row">
        <div class="span4">
            <h1><small>Сообщения</small></h1>
        </div>

    </div>

    <div class="row">
        <div class="span3 l_select_group">
            <div class="well" style="height: 142px">
                <h5 class="header_block">Номер группы</h5>
                <label for="">Выберите:</label>
                <input type="hidden" value="<?=Security::token()?>"/>
                <select name="select2" id="select2" data-url="<?=Request::$current->url().'/users_by_group'?>">
                    <option value="0" selected="selected">Все ...</option>
                    <?foreach($list_groups as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>
            </div>
        </div>
        <div class="span9 l_sort">
            <div class="well">
                <h5 class="header_block">Отправить сообщение слушателю</h5>
                <form class="form-horizontal" action="<?=URL::site('admin/messages/add_message')?>" id="send" method="post" accept-charset="utf-8" novalidate>
                    <div class="row">
                        <div class="span1">
                           <img style="box-shadow: 0 1px 1px rgba(0,0,0,0.2); height: 60px; width: 60px" class="img-circle" src="<?=URL::site('public/img/admin/admin_avatar.png')?>" alt="admin_logo"/>
                        </div>
                        <div class="span7">
                            <textarea name="message" id="admin_msg" style="height: 65px; resize: none" class="input-block-level" placeholder="Введите сообщение"></textarea>
                            <input type="hidden" name="listener_id" class="user_id"/>
                            <input type="hidden" name="csrf" class="csrf" value="<?=Security::token()?>"/>
                            <button type="submit" style="margin-top: 12px" class="btn btn-success">Отправить</button>
                            <!--<input style="margin-top: 12px" type="submit" class="btn btn-success" name="submit"/>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span3">
            <div class="well l_fio" style="height: 980px">
                <h5 class="header_block">Слушатели</h5>
                <input type="hidden" id="user_id"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="wrap" id="listeners" data-url="<?=URL::site('admin/messages/get_messages')?>">
                    <?=View::factory('admin/html/listeners', compact('list_users'))?>
                </div>
            </div>
        </div>
        <div class="span9 l_info">
            <input type="hidden" value="<?=Security::token()?>"/>
            <div class="well" style="padding-right: 0" id="data" data-url="<?=Request::$current->url().'/get_messages'?>">
                <h5 class="header_block">Переписка с <span class="current_listener"></span></h5>
                <div class="chat-block">
                    <ul class="chat"></ul>
                </div>
            </div>
        </div>
    </div>

</div>