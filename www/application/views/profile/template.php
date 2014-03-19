<?=HTML::style('profile/css/lk.css')?>
<?=HTML::style('profile/css/chat.css')?>
<?=HTML::style('profile/css/lk_statement.css')?>


<div class="container" style="margin-top: 110px;">
    <?if (Auth::instance()->get_user()->logins == 1):?>
        <div class="row">
            <div class="span12 reg">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Поздравляем!</h4>
                    Вы были успешно зарегистрированы. На вашу почту отправлены данные для входа.
                </div>
            </div>
        </div>
        <!--ой, не хорошо так делать-->
        <?ORM::factory('User', Auth::instance()->get_user()->id)->set('logins', 2)->update()?>
    <?endif?>
    <div class="lk">
        <div class="row">
            <div class="imgprofile">
                <div class="profile">
                    <?=HTML::image($user['photo'], array('width' => '180px', 'height' => '180px'))?>
                </div>
            </div>
            <div class="span12 back1">
                <div class="row">
                    <div class="span9 pull-right">
                        <div class="row-fluid">
                            <div class="span4">
                                <h1><span id="userFamil"><?=$user['famil']?></span>&nbsp;<span id="userName"><?=$user['imya']?></span></h1>
                            </div>
                            <div class="span8">
                                <h1 class="group pull-right"
                                    title="Группа">
                                    <?= ($group === 0) ? '' : $group['name']?>
                                </h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span6 settings">
                                <i class="icon-envelope-alt"></i> <span id="userEmail"><?=$user['email']?></span>, <a href="<?=URL::site('profile/settings')?>"><i class="icon-cog"></i> Настройки</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?=$content?>
        </div>


    </div>

</div>