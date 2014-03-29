<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<style type="text/css">
    .wrap
    {
        width: 660px;
        overflow-y: auto;
        height: 560px;
        padding-right: 10px;
    }
    .msg
    {
        margin: 20px 0 0 0;
        padding: 5px;
        border: 1px solid #cdcdcd;
    }
    .msg p
    {
        font-size: 12pt;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .msg h2
    {
        margin: 0;
        line-height: 25px;
        color: #424242;
        font-size: 12pt;
        font-weight: bold;
    }
    .msg .bottom
    {
        width: 95%;
        border-top: 1px solid gray;
        padding-top: 5px;
    }
    .msg span
    {
        margin-bottom: 7px;
    }
    .not_found
    {
        font-weight: 400;
        text-align: center;
        margin-top: 50px;
    }
</style>
<div class="span8 wrap">
    <?if($news->count() > 0):?>
        <?foreach($news as $msg):?>
            <div class="row msg">
                <div class="span4">
                    <h2><?=$msg->title?></h2>
                </div>
                <div class="span8">
                    <p><?=$msg->message?></p>
                    <div class="bottom">
                        <span class="datetime pull-left"><i class="icon-calendar"></i> добавлено <?=date('d.m.Y', strtotime($msg->timestamp))?> в <?=date('H:i', strtotime($msg->timestamp))?></span>
                    </div>
                </div>
            </div>
        <?endforeach?>
    <?else:?>
        <p class="not_found">Не найдены :( <br/>Как только появятся новости, мы вас оповестим по почте.</p>
    <?endif?>
</div>

