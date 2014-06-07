<?=HTML::style('adm/css/settings.css')?>

<div class="container">

    <h1><small>Настройки</small></h1>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?=URL::site('admin/settings/')?>">Главная страница</a></li>
            <li class="active"><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
            <li><a href="<?=URL::site('admin/settings/upload')?>">Загрузка файлов</a></li>
            <li><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
            <li><a href="<?=URL::site('admin/settings/sync')?>">Синхронизация</a></li>
            <li><a href="<?=URL::site('admin/settings/backup')?>">Резервное копирование</a></li>
        </ul>
        <div class="tab-content">
            <!--вкладка Главная страница-->

            <? if(isset($errors)) : ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=array_shift($errors)?>
                </div>
            <? endif ?>
            <div class="row admins">
                <div class="span4">
                    <div class="well well-large newAdmin">
                        <!--
                            FORM NEW USER
                        -->
                        <form action="<?=Request::current()->url()?>" method="post" novalidate>
                            <h5 class="header_block">Новый администратор</h5>

                            <label for="famil">Фамилия</label>
                            <input name="family_name" type="text" class="input-block-level" placeholder="" id="famil" value="<?=isset($data['family_name']) ? $data['family_name'] : null?>">

                            <label for="imya">Имя</label>
                            <input name="first_name" type="text" class="input-block-level" placeholder="" id="imya" value="<?=isset($data['first_name']) ? $data['first_name'] : null?>">

                            <label for="email">Введите E-mail</label>
                            <input name="email" type="email" class="input-block-level" placeholder="example@gmail.com" id="email" value="<?=isset($data['email']) ? $data['email'] : null?>">

                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>

                            <input type="submit" class="btn btn-success btn-block" value="Добавить" style="margin-top: 10px">
                        </form>

                    </div>
                </div>
                <div class="span8">
                    <div class="well well-large listAdmins">
                        <h5 class="header_block">Список администраторов</h5>
                        <? if (count($admins) == 0) : ?>
                            <div class="text-center not-found">Администраторы отсутствуют.</div>
                        <? else : ?>
                        <table id="table_admins" class="table table_admins">
                            <thead>
                            <tr>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>E-mail</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>

                            <? foreach($admins as $admin): ?>
                                <tr id="<?=$admin['id']?>">
                                    <td><?=$admin['info']['family_name']?></td>
                                    <td><?=$admin['info']['first_name']?></td>
                                    <td><?=$admin['email']?></td>
                                    <td>
                                        <a class="badge badge-important" href="<?=Request::current()->url().'?id='.$admin['id'].'&csrf='.bin2hex(Security::token())?>"><i class="icon-remove"></i></a>
                                    </td>
                                </tr>
                            <? endforeach ?>

                            </tbody>
                        </table>
                        <? endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>