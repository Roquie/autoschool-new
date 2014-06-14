<?=HTML::style('adm/css/settings.css')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>
<?=HTML::script('adm/js/settings.js')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li><a href="<?=URL::site('admin/settings/upload')?>">Загрузка файлов</a></li>
            <li><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
            <li><a href="<?=URL::site('admin/settings/sync')?>">Синхронизация</a></li>
            <li class="active"><a href="<?=URL::site('admin/settings/backup')?>">Резервное копирование</a></li>
        </ul>
        <div class="tab-content">
            <!--вкладка Главная страница-->

            <? if(isset($error)) : ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$error?>
                </div>
            <? endif ?>
            <? if(isset($success)) : ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$success?>
                </div>
            <? endif ?>

            <div class="row" style="overflow-x: hidden">
                <div class="span12">
                    <div class="well">
                        <div class="row">
                            <form action="<?=URL::site('admin/settings/backup')?>" method="post" accept-charset="utf-8">
                                <div class="span3">
                                    <h5 class="header_block">Резервное копирование <?/*=date('d.m.Y H:i:s')*/?></h5>
                                    <label for="time">Время выполнения</label>
                                    <input id="time" type="time" name="time" value="05:00" />
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
                                        <label class="checkbox" style="margin: 13px 0 19px 0">
                                            <input type="checkbox" name="email_ok" checked/> Отправлять отчет на почту
                                        </label>
                                    <?else:?>
                                        <label class="checkbox" style="margin: 13px 0 19px 0">
                                            <input type="checkbox" name="email_ok"/> Отправлять отчет на почту
                                        </label>
                                    <?endif?>
                                    <?if($settings->get('backup')):?>
                                        <input type="submit" class="btn btn-success" style="width: 100%" value="Вкл. резервное копирование"/>
                                        <input type="hidden" name="backup_status" value="0"/>
                                    <?else:?>
                                        <input type="submit" class="btn btn-danger" style="width: 100%; padding-left: 9px" value="Выкл. резервное копирование"/>
                                        <input type="hidden" name="backup_status" value="1"/>
                                    <?endif?>
                                </div>
                                <div class="span8" style="padding-left: 20px" id="google_drive">
                                    <h5 class="header_block">Список созданных резервных архивов</h5>

                                    <table class="table table_files" style="margin-top: -10px">
                                        <thead style="margin-top: -20px">
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 380px">Наименование</th>
                                                <th style="width: 150px">Загрузить</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?$count = count($backup_files); foreach($backup_files as $k => $v):?>
                                            <tr>
                                                <td><?=$count--?></td>
                                                <td style="width: 380px"><?=$filename = pathinfo($v, PATHINFO_BASENAME)?></td>
                                                <td style="width: 180px; margin-left: 20px"><a href="<?=URL::site('backup_download/'.$filename)?>">Скачать</a></td>
                                            </tr>
                                        <?endforeach?>
                                        </tbody>
                                    </table>


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