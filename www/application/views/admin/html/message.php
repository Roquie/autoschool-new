<li class="right clearfix">
    <span class="chat-img pull-right">
        <?=HTML::image($admin_avatar, array('class' => 'img-circle'))?>
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="pull-right">Администратор</strong>
            <small class="muted"><span class="icon-time"></span> <?=date('d.m.Y H:i:s')?></small>
        </div>
        <p>
            <?=$post['message']?>
        </p>
    </div>
</li>