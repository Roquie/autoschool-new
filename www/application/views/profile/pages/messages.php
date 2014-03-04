<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<div class="span8">
    <?foreach($news as $msg):?>
        <div class="row msg">
            <div class="span4">
                <b><?=$msg['title']?></b>
            </div>
            <div class="span8">
                <?=$msg['message']?>
            </div>
        </div>
    <?endforeach?>
</div>

