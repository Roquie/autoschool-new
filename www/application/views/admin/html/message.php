<? if ($messages->count()) : ?>
        <? foreach($messages as $line) : ?>
            <? $datetime = strtotime($line->datetime); ?>
            <li class="<?=(!$line->admin) ? 'left' : 'right'?> clearfix">
            <span class="chat-img <?=(!$line->admin) ? 'pull-left' : 'pull-right'?>">
                <?=HTML::image((!$line->admin) ? $listener->user->photo : $admin_avatar, array('class' => 'img-circle'))?>
            </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="<?=(!$line->admin) ? null : 'pull-right'?>"><?=(!$line->admin) ? $listener->famil . ' '.$listener->imya : 'Администратор'?></strong>
                        <small class="<?=($line->admin) ? null : 'pull-right'?> muted"><span class="icon-time"></span> <?=date('d.m.Y H:i:s', $datetime)?></small>
                    </div>
                    <p>
                        <?=$line->message?>
                    </p>
                </div>
            </li>
        <? endforeach; ?>
            <? if (count($messages) == 10) : ?>
                <a href="#" class="btn span8 load" data-url="<?=URL::site('lk/ajax/load_message')?>">Загрузить предыдущие сообщения</a>
            <? endif;
    else : ?>

    <div class="text-center" id="clear-block"><i class="icon-frown icon-large"></i> Переписка пуста</div>

<? endif; ?>