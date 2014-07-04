<?=HTML::style('adm/css/settings.css')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>
<?=HTML::script('adm/js/settings.js')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li><a href="<?=URL::site('admin/settings/upload')?>">Замена шаблонов</a></li>
            <li><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
            <li><a href="<?=URL::site('admin/settings/sync')?>">Синх.</a></li>
            <li><a href="<?=URL::site('admin/settings/backup')?>">Резервные копии</a></li>
            <li class="active"><a href="<?=URL::site('admin/settings/notification')?>">Уведомления</a></li>
        </ul>
        <div class="tab-content">

            <?=View::factory('errors/msg')?>

            <div class="row" style="overflow-x: hidden">
                <div class="span12">
                    <div class="well">
                        <div class="row">
                            <form action="<?=URL::site('admin/settings/backup')?>" method="post" accept-charset="utf-8">
                                <div class="span11">
                                    <legend>Уведомления о новых слушателях</legend>
                                    <?=$settings->get('notification_sms')?>
                                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                    <?if($settings->get('backup')):?>
                                        <input type="submit" class="btn btn-success" style="width: 100%; margin-top: 8px" value="Вкл. резервное копирование"/>
                                        <input type="hidden" name="backup_status" value="0"/>
                                    <?else:?>
                                        <input type="submit" class="btn btn-danger" style="width: 100%; padding-left: 9px; margin-top: 8px" value="Выкл. резервное копирование"/>
                                        <input type="hidden" name="backup_status" value="1"/>
                                    <?endif?>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>