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
                            <form action="<?=URL::site('admin/settings/notification')?>" method="post" accept-charset="utf-8" class="form-horizontal">
                                <div class="span12">
                                    <legend>Уведомления о новых слушателях</legend>
                                    <p>
                                        Выберите вариант оповещения о новых пользователях. Можно выбрать оба варианта или отключить любые оповещения.
                                    </p><br/>
                                </div>

                                <div class="row">
                                    <div class="span12">
                                        <div class="span5">
                                            <h5 class="header_block">Варианты уведомлений</h5>
                                            <label class="checkbox">
                                                <input type="checkbox" name="sms_ok" <?=$settings->get('notification_sms') ? 'checked' : null?>/> Отправлять отчет на телефон (sms)
                                            </label>
                                        </div>
                                        <div class="span6">
                                            <h5 class="header_block">Данные для отправки уведомлений</h5>
                                            <div class="control-group">
                                                <label class="control-label" for="phone">Телефон</label>
                                                <div class="controls">
                                                    <input type="text" id="phone" name="phone" class="telephone" placeholder="+7 (999) 999-99-99" value="<?=$settings->get('notification_phone')?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="span12">
                                        <div class="span5">
                                            <label class="checkbox">
                                                <input type="checkbox" name="email_ok" <?=$settings->get('notification_email') ? 'checked' : null?>/> Отправлять отчет на почту (email)
                                            </label>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label" for="phone">E-mail</label>
                                                <div class="controls">
                                                    <input type="text" id="phone" name="email" placeholder="example@gmail.com" value="<?=$settings->get('notification_email_address')?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="span11">
                                        <div class="span11" style="margin-left: 35px">
                                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                            <input type="submit" class="btn btn-success btn-block" style="margin-top: 8px" value="Сохранить"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>