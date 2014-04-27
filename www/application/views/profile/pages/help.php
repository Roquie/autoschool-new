<?=HTML::style('global/css/messages.css')?>
<?=HTML::style('profile/css/help.css')?>
<?=HTML::script('profile/js/help.js')?>
<?=HTML::script('global/js/messages.js')?>

<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li class="active"><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>

<div class="span9">
    <form class="form-horizontal" action="<?=URL::site('profile/add_message')?>" id="send" method="post" accept-charset="utf-8" novalidate>
        <div class="row">
            <div class="span1">
                <img style="box-shadow: 0 1px 1px rgba(0,0,0,0.2); height: 60px; width: 60px" class="img-circle" src="<?=(strpos($user->photo, 'public')) ? URL::site($user->photo) : $user->photo?>" alt="admin_logo"/>
            </div>
            <div class="span7">
                <textarea name="message" id="admin_msg" style="height: 65px; resize: none" class="input-block-level" placeholder="Введите сообщение"></textarea>
                <input type="hidden" name="csrf" class="csrf" value="<?=Security::token()?>"/>
                <button type="submit" style="margin-top: 12px" class="btn btn-success">Отправить</button>
                <!--<input style="margin-top: 12px" type="submit" class="btn btn-success" name="submit"/>-->
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <div class="chat-block">
        <ul class="chat"><?=View::factory('admin/html/messages', compact('messages', 'listener', 'profile', 'admin_avatar'))?></ul>
    </div>
</div>





