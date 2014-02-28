<?=HTML::style('css/lk/lk.css')?>
<?=HTML::style('css/chat.css')?>
<?=HTML::script('js/lk/lk.js')?>
<?=HTML::script('js/vendor/moment+langs.min.js')?>
<?=HTML::style('css/vendor/bootstrap-editable.css')?>
<?=HTML::script('js/vendor/bootstrap-editable.min.js')?>
<?=HTML::style('css/lk/lk_statement.css')?>
<?=HTML::style('css/vendor/select2.css')?>
<?=HTML::script('js/vendor/select2.min.js')?>
<?
    $reg = Session::instance()->get('after_register');
    if (!is_null($reg)) :
        Session::instance()->delete('after_register');
?>
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
<? endif; ?>

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
                                <i class="icon-envelope-alt"></i> <span id="userEmail"><?=$user['email']?></span>, <a href="<?=URL::site('lk/ajax/settings')?>" data-nav="true" data-noactive="true"><i class="icon-cog"></i> Настройки</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="span3 menu">
                <ul class="nav nav-pills nav-stacked" id="left_menu">
                    <li><a href="<?=URL::site('lk/ajax/messages')?>" data-nav="true"><i class="icon-comments"></i><span>Группа</span></a></li>
                    <li><a href="<?=URL::site('lk/ajax/statement')?>" data-nav="true"><i class="icon-file"></i><span>Заявление</span></a></li>
                    <li><a href="<?=URL::site('lk/ajax/contract')?>" data-nav="true"><i class="icon-file"></i><span>Договор</span></a></li>
                    <li><a href="<?=URL::site('lk/ajax/download')?>" data-nav="true"><i class="icon-cloud-download"></i><span>Загрузки</span></a></li>
                    <li><a href="<?=URL::site('lk/ajax/help')?>" data-nav="true">&nbsp;<i class="icon-info"></i><span>&nbsp;Помощь</span></a></li>
                </ul>
            </div>

            <div id="loader">
                <div class="title">Загрузка данных... Пожалуйста, подождите</div>
                <div class="loader"><i class="icon-refresh icon-spin icon-large load"></i></div>
            </div>

            <div class="span8" id="content">
            </div>
        </div>
    </div>

</div>