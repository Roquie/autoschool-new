<?=HTML::style('adm/css/settings.css')?>
<?=HTML::script('adm/js/upload.js')?>
<style>
    .b-button {
        display: inline-block;
        *display: inline;
        *zoom: 1;
        position: relative;
        overflow: hidden;
    }
    .b-button__input {
        cursor: pointer;
        opacity: 0;
        filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
        top: 0px;
        right: -50px;
        font-size: 50px;
        position: absolute;
    }
    .b-button .progress-bar {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: .5;
        position: absolute;
    }
    .b-button .progress-bar .bar {
        width: 0;
        top: 0;
        left: 0;
        bottom: 0;
        position: absolute;
        background-color: #fff;
    }
</style>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li class="active"><a href="<?=URL::site('admin/settings/upload')?>">Загрузка файлов</a></li>
            <li><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
            <li><a href="<?=URL::site('admin/settings/sync')?>">Синхронизация</a></li>
        </ul>
        <div class="tab-content">
            <!--вкладка Главная страница-->

            <? if(isset($errors)) : ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=array_shift($errors)?>
                </div>
            <? endif ?>
            <div class="row" style="overflow-x: hidden">
            <div class="span8" >
                <div class="well" style="height: 300px;">
                    <h5 class="header_block">Файлы сайта</h5>
                    <table class="table table_files">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Выбрать</th>
                            <th>Имя</th>
                            <th>Описание</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?foreach ($files as $file):?>
                            <tr>
                                <td><?=$file->id?></td>
                                <td><input type="checkbox" value="<?=$file->id?>" name="rd_file" /></td>
                                <td><?=$file->filename?></td>
                                <td><?=$file->desc?></td>
                            </tr>
                        <?endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span4">
                <div class="well" style="height: 300px;">
                    <h5 class="header_block">Загрузить</h5>
                    <p style="text-align: center">Для загрузки файла выберите в таблице слева файл, который Вы хотите заменить, и загрузите новый.</p>
                    <div class="b-button js-fileapi-wrapper" style="margin-bottom: 10px; margin-top: 40px; margin-left: 60px">
                        <form action="<?=Route::url('admin', array('controller'=>'settings', 'action'=>'upload'))?>" method="post" enctype="multipart/form-data">
                            <div class="browse">
                            <? if (!isset($data)) : ?>
                                <a class="b-button__text btn btn-success" href="#">Загрузить файл</a>
                                <input name="files" class="b-button__input" type="file"/>
                                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                <input type="hidden" id="type_file" name="type_file"/>
                            <? else : ?>
                                <input type="submit" value="Загрузить"/>
                            <? endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

</div>