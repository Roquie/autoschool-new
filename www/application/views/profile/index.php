<?=HTML::style('profile/css/lk.css')?>
<?=HTML::style('profile/css/chat.css')?>
<?=HTML::style('profile/css/lk_statement.css')?>
<?/*
    $reg = Session::instance()->get('after_register');
    if (!is_null($reg)) :
        Session::instance()->delete('after_register');
*/?><!--
        <script>
            $(function() {
                $(window).on('load', function() {
                    $('.reg').show();
                    setTimeout(function() {
                        $('.reg').hide();
                    }, 5000);
                });
            });
        </script>
--><?/* endif; */?>

<div class="container" style="margin-top: 110px;">


    <div class="row">
        <div class="span12 reg hide">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Поздравляем!</h4>
                Вы были успешно зарегистрированы. На вашу почту отправлены данные для входа.
            </div>
        </div>
    </div>

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
            <div class="span3 menu" style="margin-top: 110px">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Группа</a></li>
                    <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
                    <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
                    <li><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
                    <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
                </ul>
            </div>
            <div class="span8">
                asdasd
            </div>
        </div>


    </div>

</div>