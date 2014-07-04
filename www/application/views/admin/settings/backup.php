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
            <li class="active"><a href="<?=URL::site('admin/settings/backup')?>">Резервные копии</a></li>
            <li><a href="<?=URL::site('admin/settings/notification')?>">Уведомления</a></li>
        </ul>
        <div class="tab-content">

            <?=View::factory('errors/msg')?>

            <div class="row" style="overflow-x: hidden">
                <div class="span12">
                    <div class="well">
                        <div class="row">
                            <form action="<?=URL::site('admin/settings/backup')?>" method="post" accept-charset="utf-8">
                                <div class="span3">
                                    <h5 class="header_block">Резервное копирование <?/*=date('d.m.Y H:i:s')*/?></h5>
                                    <label for="time">Время выполнения</label>
                                    <input id="time" type="time" name="time" value="<?=$settings->get('backup_time')?>" />
                                    <label for="type_task">Когда выполнять</label>
                                    <select name="type_task" id="type_task">
                                        <?foreach($type_tasks as $k => $value):?>
                                            <?if($k == $settings->get('backup_first_type')):?>
                                                <option value="<?=$k?>" selected><?=$value?></option>
                                            <?else:?>
                                                <option value="<?=$k?>"><?=$value?></option>
                                            <?endif?>
                                        <?endforeach?>
                                    </select>
                                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                    <?if($settings->get('backup_email')):?>
                                        <label class="checkbox" style="margin: 7px 0 7px 0">
                                            <input type="checkbox" name="email_ok" checked/> Отправлять отчет на почту
                                        </label>
                                    <?else:?>
                                        <label class="checkbox" style="margin: 7px 0 7px 0">
                                            <input type="checkbox" name="email_ok"/> Отправлять отчет на почту
                                        </label>
                                    <?endif?>
                                    <?if($settings->get('backup')):?>
                                        <input type="submit" class="btn btn-success" style="width: 100%; margin-top: 8px" value="Вкл. резервное копирование"/>
                                        <input type="hidden" name="backup_status" value="0"/>
                                    <?else:?>
                                        <input type="submit" class="btn btn-danger" style="width: 100%; padding-left: 9px; margin-top: 8px" value="Выкл. резервное копирование"/>
                                        <input type="hidden" name="backup_status" value="1"/>
                                    <?endif?>
                                </div>
                                <div class="span8" style="padding-left: 20px" id="google_drive">
                                    <h5 class="header_block">Список созданных резервных архивов</h5>
                                    <?if(count($backup_files) > 0):?>
                                        <table class="table table_files" style="margin-top: -35px;">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 380px">Наименование</th>
                                                <th style="width: 150px">Операции</th>
                                            </tr>
                                            </thead>

                                            <tbody style="height: 180px">
                                                <?$count = count($backup_files); foreach($backup_files as $k => $v):?>
                                                    <tr style="cursor: default; padding-top: 4px">
                                                        <td style="line-height: 26px"><?=$count--?></td>
                                                        <td style="line-height: 26px; width: 420px"><?=$filename = pathinfo($v, PATHINFO_BASENAME)?></td>
                                                        <div class="btn-group" style="height: 25px">
                                                        <td style="line-height: 26px; width: 140px; padding-left: 40px; text-align: left">
                                                            <div class="btn-group" style="height: 25px">
                                                                <a rel="tooltip" title="ОТКАТ НА ЭТУ ВЕРСИЮ БД! ВНИМАЕНИЕ! ОПАСНАЯ ОПЕРАЦИЯ! " class="btn btn-warning" style="padding: 2px 10px 2px 10px;" href="<?=Request::current()->url().'?restore='.$filename.'&csrf='.bin2hex(Security::token())?>"><i class="icon-time"></i></a>
                                                                <a rel="tooltip" title="Скачать архив" class="btn btn-success" style="padding: 2px 10px 2px 10px;" href="<?=URL::site('backup_download/'.$filename)?>"><i class="icon-download"></i></a>
                                                                <a rel="tooltip" title="Удалить архив с сервера" class="btn btn-danger" style="padding: 2px 10px 2px 10px;" href="<?=Request::current()->url().'?remove='.$filename.'&csrf='.bin2hex(Security::token())?>"><i class="icon-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?endforeach?>
                                            </tbody>
                                        </table>
                                    <?else:?>
                                        <div style="text-align: center; font-weight: 700; margin-top: 30px">
                                            <p>На данный момент создание резерной копии выключено или ее создание не подошло к отмеченному времени.</p>
                                        </div>

                                    <?endif?>



                                    <!--<h5 class="header_block">Загружать в GoogleDrive</h5>
                                    <?/*if($settings->get('backup_grive')):*/?>
                                        <label for="g_login">Логин</label>
                                        <input type="text" name="g_login" placeholder="autompt@gmail.com" />
                                        <label for="g_password">Пароль</label>
                                        <input type="password" name="g_password" placeholder="************" />
                                        <label  class="checkbox" style="margin: 5px 0 20px 0">
                                            <input id="check_google" name="google_ok" type="checkbox" checked/> Хочу загружать их в гугл
                                        </label>
                                    <?/*else:*/?>
                                        <label for="g_login">Логин</label>
                                        <input type="text" name="g_login" placeholder="autompt@gmail.com" disabled/>
                                        <label for="g_password">Пароль</label>
                                        <input type="password" name="g_password" placeholder="************" disabled/>
                                        <label  class="checkbox" style="margin: 5px 0 20px 0">
                                            <input id="check_google" name="google_ok" type="checkbox"/> Хочу загружать их в гугл
                                        </label>
                                    --><?/*endif*/?>
                                   <!-- <label  class="checkbox" style="margin: 5px 0 20px 0">
                                        <input id="check_googl1e" name="google_ok" type="checkbox"/> Хочу загружать их в гугл
                                    </label>-->
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>