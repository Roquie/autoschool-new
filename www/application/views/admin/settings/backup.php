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
                        <h5 class="header_block">Резервное копирование</h5>


                    </div>
                </div>

            </div>
        </div>
    </div>

</div>