<?=HTML::style('adm/css/settings.css')?>
<?=HTML::script('adm/js/settings.js')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="#administrators" data-toggle="tab">Администраторы</a></li>
            <li><a href="#upload" data-toggle="tab" >Загрузка файлов</a></li>
            <li><a href="#home" data-toggle="tab" id="act">Главная страница</a></li>
        </ul>
        <div class="tab-content">
            <!--вкладка Главная страница-->
            <div class="tab-pane" id="home">
                <?=View::factory('admin/html/settings/smtp')
                    // ->set('upload_files', $upload_files)
                    //->set('smtp', $smtp)
                    ->render()?>
            </div>
            <!--вкладка Администраторы -->
            <div class="tab-pane" id="administrators">
                <?=View::factory('admin/html/settings/admins')
                    //->set('all_admins', $all_admins)
                    ->render()?>
            </div>
            <!--вкладка 2-->
            <div class="tab-pane" id="upload">
                <?=View::factory('admin/html/settings/upload')
                    //->set('upload_files', $upload_files)
                    ->render()?>
            </div>
        </div>
    </div>

</div>

<!--модалка -->
<div class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Удаление пользователя</h3>
    </div>
    <div class="modal-body">
        <p>Вы действительно хотите удалить пользователя?</p>
    </div>
    <div class="modal-footer">
        <a href="#" id="yes" class="btn btn-success" data-url="<?=URL::site('admin/settings/delAdmin/')?>">Да</a>
        <a href="#" id="no" class="btn">Нет</a>
    </div>
</div>
<!-- конец модалке -->