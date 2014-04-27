<?=HTML::style('adm/css/settings.css')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>
<?=HTML::script('adm/js/settings.js')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li><a href="<?=URL::site('admin/settings/upload')?>">Загрузка файлов</a></li>
            <li><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
            <li><a href="<?=URL::site('admin/settings/sync')?>">Синхронизация</a></li>
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
                <div class="span4">
                    <div class="well">
                        <form action="<?=Request::current()->url()?>" method="post" novalidate>
                            <h5 class="header_block">Номера для связи</h5>

                            <label for="telephone_1">Тел. 1</label>
                            <input name="telephone_1" type="text" class="input-block-level telephone" id="telephone_1" value="<?=isset($data['telephone_1']) ? $data['telephone_1'] : null?>">

                            <label for="telephone_2">Тел. 2</label>
                            <input name="telephone_2" type="text" class="input-block-level telephone" id="telephone_2" value="<?=isset($data['telephone_2']) ? $data['telephone_2'] : null?>">

                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="hidden" name="type" value="tel"/>

                            <input type="submit" class="btn btn-success btn-block" value="Сохранить" style="margin-top: 10px">
                        </form>
                    </div>
                </div>

                <div class="span4">
                    <div class="well">
                        <form action="<?=Request::current()->url()?>" method="post" novalidate>
                            <h5 class="header_block">Основные данные</h5>

                            <label for="title">Наименование</label>
                            <input name="title" type="text" class="input-block-level" id="title" value="<?=isset($data['title']) ? $data['title'] : null?>">

                            <label for="address">Адрес</label>
                            <input name="address" type="text" class="input-block-level" id="address" value="<?=isset($data['address']) ? $data['address'] : null?>">

                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="hidden" name="type" value="general"/>

                            <input type="submit" class="btn btn-success btn-block" value="Сохранить" style="margin-top: 10px">
                        </form>
                    </div>
                </div>

                <div class="span4">
                    <div class="well">
                        <form action="<?=Request::current()->url()?>" method="post" novalidate>
                            <h5 class="header_block">E-mail адрес</h5>

                            <label for="email">E-mail</label>
                            <input name="email" type="text" class="input-block-level" id="email" placeholder="example@gmail.com" value="<?=isset($data['email']) ? $data['email'] : null?>" style="margin-bottom: 75px">

                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="hidden" name="type" value="email"/>

                            <input type="submit" class="btn btn-success btn-block" value="Сохранить" style="margin-top: 10px">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>