<?=HTML::style('css/lk/chat.css')?>
<?=HTML::script('js/lk/help.js')?>

<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li class="active"><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<div class="span8">
    <div class="write">
        <button class="btn btn-info newmsg togl"><i class="icon-pencil"></i> Написать</button>
        <div class="row sendmsg hide togl">
            <div class="span8">
                <h2>Написать сообщение</h2>
                <div class="span1">
                    <?=HTML::image($user['photo'], array('class' => 'imgsend', 'width' => '60px', 'height' => '60px'))?>
                </div>
                <div class="span7">
                    <form action="<?=URL::site('lk/ajax/addMessage')?>" class="_lk_form" method="POST" data-callback="add_message">
                        <textarea name="message" id="message" cols="10" rows="5" placeholder="текст сообщения"></textarea>
                        <br>
                        <input type="hidden" name="csrf" class="csrf" value="<?=Security::token()?>"/>
                        <input type="submit" value="Отправить" class="btn btn-info"/>
                        <a class="btn btn-primary hidemsg" href="#">Скрыть</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="messages">
        <?
        if ($messages) :
            ?>
            <? foreach($messages as $line) : ?>
            <? $datetime = strtotime($line->datetime); ?>
            <div class="row">
                <div class="span8 allmsg">
                    <div class="span1">
                        <?=HTML::image((!$line->admin) ? $line->user->photo : $admin_avatar, array('class' => 'imgsend', 'width' => '60px', 'height' => '60px'))?>
                    </div>
                    <div class="text span5"><?=$line->message?></div>
                    <small class="muted span2" style="text-align: center"><?=date('d.m.Y H:i:s', $datetime)?></small>
                </div>
            </div>
        <? endforeach; ?>
            <? if (count($messages) == 10) : ?>
            <a href="#" class="btn span8 load" data-url="<?=URL::site('lk/ajax/load_message')?>">Загрузить предыдущие сообщения</a>
        <?
        endif;
        else :
            ?>
            <div class="text-center" id="clear-block"><i class="icon-frown icon-large"></i> Переписка пуста</div>
        <? endif; ?>
    </div>
</div>


