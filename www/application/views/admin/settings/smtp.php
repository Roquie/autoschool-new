<?=HTML::style('adm/css/settings.css')?>
<?=HTML::script('adm/js/settings.js')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li><a href="<?=URL::site('admin/settings/upload')?>">Загрузка файлов</a></li>
            <li class="active"><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
            <li><a href="<?=URL::site('admin/settings/sync')?>">Синхронизация</a></li>
            <li><a href="<?=URL::site('admin/settings/backup')?>">Резервное копирование</a></li>
        </ul>
        <div class="tab-content">

            <?=View::factory('errors/msg')?>

            <div class="row" style="overflow-x: hidden">
                <div class="span4">
                    <div class="well" >
                        <div>
                            <h5 class="header_block">Настройки SMTP</h5>
                            <form action="<?=Route::to('admin', 'settings#smtp')?>" method="post">
                                <label for="server">Сервер:</label>
                                <input name="server" id="server" class="input-block-level" type="text" placeholder="smtp.gmail.com" value="<?=isset($post['server']) ? $post['server'] : null?>">
                                <label for="port">Порт:</label>
                                <input name="port" id="port" type="text" class="input-block-level" placeholder="25" value="<?=isset($post['port']) ? $post['port'] : null?>">
                                <label for="login">E-mail:</label>
                                <input name="login" id="login" type="text" class="input-block-level" placeholder="example@gmail.com" value="<?=isset($post['login']) ? $post['login'] : null?>">
                                <label for="password">Пароль:</label>
                                <?if($settings->get('smtp')):?>
                                    <input name="password" id="password" type="password" class="input-block-level" placeholder="Пароль скрыт в целях безопасности" value="<?=isset($post['password']) ? null : null?>"><br>
                                <?else:?>
                                    <input name="password" id="password" type="password" class="input-block-level" placeholder="Пароль" value="<?=isset($post['password']) ? null : null?>"><br>
                                <?endif?>
                                <input type="hidden" name="csrf" value="<?=Security::token()?>" class="csrf"/>
                                <!--<input class="btn btn-info pull-right" id="reset" type="reset" value="Очистить">-->
                                <?if($settings->get('smtp')):?>
                                    <input type="submit" class="btn btn-danger" style="width: 100%" value="Выключить SMTP">
                                <?else:?>
                                    <input type="submit" class="btn btn-success" style="width: 100%" value="Включить SMTP">
                                <?endif?>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="span8">
                    <div class="well" style="height: 346px">
                        <div class="row-fluid" style="text-align: center">
                            <div class="span4"><h5 class="header_block">Google</h5></div>
                            <div class="span4"><h5 class="header_block">Yandex</h5></div>
                            <div class="span4"><h5 class="header_block">Mail</h5></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4"><strong>Сервер:</strong> sslv3://smtp.gmail.com<br><strong>Порт:</strong> 465</div>
                            <div class="span4"><strong>Сервер:</strong> ssl://smtp.yandex.ru<br><strong>Порт:</strong> 465</div>
                            <div class="span4"><strong>Сервер:</strong> <br/>ssl://smtp.mail.ru<br><strong>Порт:</strong> 465</div>
                        </div>
                        <br><br>
                        <div class="alert alert-info">
                            В таблице указаны данные для настройки отправки почты по протоколу SMTP трёх часто используемых почтовых сервисов.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>