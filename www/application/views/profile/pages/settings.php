<?=HTML::style('profile/css/lk_sttgs.css')?>
<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<div class="span8" style="margin-top: 10px">
    <?if(isset($errors)):?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?=array_shift($errors)?>
        </div>
    <?endif?>
    <?if(isset($success)):?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?=$success?>
        </div>
    <?endif?>
    <div class="row settingsContent">
        <div class="span4">
            <h2>Изменить пароль</h2>
            <form action="<?=URL::site('profile/settings/change_pass')?>" method="POST">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-key"></i></span>
                    <input id="password" name="password" placeholder="старый пароль" type="password">
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-key"></i></span>
                    <input id="password_new" name="password_new" placeholder="новый пароль" type="password">
                </div>
                <br>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <input type="submit" value="Изменить" class="btn btn-info pull-right"/>
            </form>
        </div>

        <div class="span4">

            <h2>Изменить email</h2>
            <form id="toggle_pass_email" action="<?=URL::site('profile/settings/change_email')?>" method="POST" novalidate>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-key"></i></span>
                    <input id="password" name="password" placeholder="ваш пароль" type="password">
                </div>
                <div class="input-prepend">
                    <span class="add-on"><b style="font-weight: 600">@</b></span>
                    <input id="new_email" name="new_email" placeholder="новый email" type="email">
                </div>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <input type="submit" value="Изменить" class="btn btn-success pull-right"/>
            </form>
        </div>
    </div>
</div>








