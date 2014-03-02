<?=HTML::style('adm/css/settings.css')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li><a href="<?=URL::site('admin/settings/upload')?>">Загрузка файлов</a></li>
            <li class="active"><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
        </ul>
        <div class="tab-content">
            <!--вкладка Главная страница-->

            <? if(isset($errors)) : ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=array_shift($errors)?>
                </div>
            <? endif ?>
            <script>
                $(function() {
                    $('#reset').on('click', function() {
                        $('form').find('.input-block-level').each(function() {
                            $(this).removeAttr('value');
                        });
                    });
                });
            </script>
            <div class="row" style="overflow-x: hidden">
                <div class="span4">
                    <div class="well" style="height: 346px">
                        <div>
                            <h5 class="header_block">Настройки SMTP</h5>
                            <form action="<?=Route::url('admin', array('controller' => 'settings', 'action' => 'index'))?>" method="post">
                                <label for="server">Сервер:</label>
                                <input name="server" id="server" class="input-block-level" type="text" placeholder="smtp.gmail.com" value="<?=isset($data['server'])?$data['server']:null?>">
                                <label for="port">Порт:</label>
                                <input name="port" id="port" type="text" class="input-block-level" placeholder="25" value="<?=isset($data['port'])?$data['port']:null?>">
                                <label for="login">E-mail:</label>
                                <input name="login" id="login" type="text" class="input-block-level" placeholder="example@gmail.com" value="<?=isset($data['login'])?$data['login']:null?>">
                                <label for="password">Пароль:</label>
                                <input name="password" id="password" type="password" class="input-block-level" placeholder="Пароль" value="<?=isset($data['password'])?'*************':null?>"><br>
                                <input type="hidden" name="csrf" value="<?=Security::token()?>" class="csrf"/>
                                <input class="btn btn-info pull-right" id="reset" type="reset" value="Очистить">
                                <input type="submit" class="btn btn-success" value="Сохранить">
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