<? if ($messages->count()) : ?>
        <? foreach($messages as $line) : ?>
            <? $datetime = strtotime($line->datetime); ?>
            <li class="<?=($profile) ? ((!$line->admin) ? 'right' : 'left') : ((!$line->admin) ? 'left' : 'right')?> clearfix">
                <span class="chat-img <?=($profile) ? (($line->admin) ? 'pull-left' : 'pull-right') : ((!$line->admin) ? 'pull-left' : 'pull-right')?>">
                    <?=HTML::image((!$line->admin) ? $listener->user->photo : $admin_avatar, array('class' => 'img-circle', 'style' => 'box-shadow: 0 1px 1px rgba(0,0,0,0.2);'))?>
                </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="<?=($profile) ? (($line->admin) ? null : 'pull-right') : ((!$line->admin) ? null : 'pull-right')?>"><?=(!$line->admin) ? $listener->famil . ' '.$listener->imya : 'Администратор'?></strong>
                        <small class="<?=($profile) ? ((!$line->admin) ? null : 'pull-right') : (($line->admin) ? null : 'pull-right')?> muted"><span class="icon-time"></span> <?=date('d.m.Y H:i:s', $datetime)?></small>
                    </div>
                    <p>
                        <?=$line->message?>
                    </p>
                </div>
            </li>
        <? endforeach; ?>
            <? if (count($messages) == 10) : ?>
                <a href="#" class="btn btn-info load" data-url="<?=($profile) ? URL::site('profile/load_message') : URL::site('admin/messages/load_message')?>" style="width: 96%">Загрузить предыдущие сообщения</a>
            <? endif;
    else : ?>

    <div class="text-center" id="clear-block"><i class="icon-frown icon-large"></i> Переписка пуста</div>

<? endif; ?>