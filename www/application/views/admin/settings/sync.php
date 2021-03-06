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
            <li class="active"><a href="<?=URL::site('admin/settings/sync')?>">Синх.</a></li>
            <li><a href="<?=URL::site('admin/settings/backup')?>">Резервные копии</a></li>
            <li><a href="<?=URL::site('admin/settings/notification')?>">Уведомления</a></li>
        </ul>
        <div class="tab-content">
            <?=View::factory('errors/msg')?>

            <div class="row" style="overflow-x: hidden">
                <div class="span4">
                    <div class="well">
                        <form action="<?=Request::current()->url()?>" method="post" novalidate>
                            <h5 class="header_block">Включить/Выключить</h5>
                            <p><!--Синхронизация с толстым клиентом.--> <!--<br/>-->
                                Механизм предполагает отправку данных в локальное хранилище, при этом не нагружая сильно систему.
                            </p>
                            <input type="hidden" name="type" value="on_off"/>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <?if(!Kohana::$config->load('settings.sync')):?>
                                <input type="hidden" name="on_off" value="1"/>
                                <input type="submit" class="btn btn-success btn-block" value="Включить синхронизацию" style="margin-top: 35px">
                            <?else:?>
                                <input type="hidden" name="on_off" value="0"/>
                                <input type="submit" class="btn btn-danger btn-block" value="Выключить синхронизацию" style="margin-top: 35px">
                            <?endif?>

                        </form>
                    </div>
                </div>

                <div class="span8">
                    <div class="well">
                        <form action="<?=Request::current()->url()?>" method="post" novalidate>
                            <h5 class="header_block">Запретить доступ для всех адресов кроме</h5>

                            <label for="ip">IP</label>
                            <input name="ip_access" type="text" class="input-medium" id="title" value="<?=isset($data['ip_access']) ? $data['ip_access'] : null?>">
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <p style="margin-top: -10px; font-size: 10pt" class="help-block">Если ничего не указано, доступ разрешен для всех</p>
                            <input type="hidden" name="type" value="ip_edit"/>
                            <input type="submit" class="btn btn-success" value="Сохранить" style="margin-top: 10px">
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>