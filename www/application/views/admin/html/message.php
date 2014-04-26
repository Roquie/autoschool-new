<li class="right clearfix">
    <span class="chat-img pull-right">
        <?=HTML::image((isset($admin_avatar) ? $admin_avatar : $user->photo), array('class' => 'img-circle', 'style' => 'box-shadow: 0 1px 1px rgba(0,0,0,0.2);'))?>
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="pull-right"><?=(isset($user)) ? ($user->listener->famil . ' '.$user->listener->imya) : 'Администратор'?></strong>
            <small class="muted"><span class="icon-time"></span> <?=date('d.m.Y H:i:s')?></small>
        </div>
        <p>
            <?=$post['message']?>
        </p>
    </div>
</li>