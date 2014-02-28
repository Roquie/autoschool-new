<? if(isset($errors)) : ?>
    <div class="alert alert-danger"><?=array_shift($errors)?></div>
<? endif ?>
<div class="row admins">
    <div class="span4">
        <div class="well well-large newAdmin">
            <!--
                FORM NEW USER
            -->
            <form action="<?=Request::current()->url()?>" method="post" novalidate>
                <legend>Новый администратор</legend>

                <label for="famil">Фамилия</label>
                <input name="family_name" type="text" class="input-block-level" placeholder="" id="famil">

                <label for="imya">Имя</label>
                <input name="first_name" type="text" class="input-block-level" placeholder="" id="imya">

                <label for="email">Введите E-mail</label>
                <input name="email" type="email" class="input-block-level" placeholder="example@gmail.com" id="email">

                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>

                <input type="submit" class="btn btn-success btn-block" value="Добавить" style="margin-top: 10px">
            </form>

        </div>
    </div>
    <div class="span8">
        <div class="well well-large listAdmins">
            <legend>Список администраторов</legend>
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
                            <a class="badge badge-important" href="<?=Request::current()->url().'/?id='.$admin['id'].'&csrf='.Security::token()?>"><i class="icon-remove"></i></a>
                        </td>
                    </tr>
                <? endforeach ?>

                </tbody>
            </table>

        </div>
    </div>



</div>