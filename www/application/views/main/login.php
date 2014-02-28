<?=HTML::style('main/css/login.css')?>
<div class="container">
    <div class="row">
        <div class="span10 offset1 wrap">
            <form class="form-horizontal" action="<?=Request::current()->url()?>" method="POST" accept-charset="utf-8" novalidate>
                <fieldset>
                    <?if(isset($errors)):?>
                        <div class="alert alert-danger"><?=array_shift($errors)?></div>
                    <?endif?>
                    <div class="row">
                        <div class="span5 pull-left">
                            <legend>Вход в личный кабинет</legend>
                            <div class="control-group">
                                <label class="control-label"  for="username">Email</label>
                                <div class="controls">
                                    <input type="email" id="email" name="email" placeholder="example@gmail.com" class="input-large">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Пароль</label>
                                <div class="controls">
                                    <input type="password" id="password" name="password" placeholder="************" class="input-large">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <label for="remember"><input class="remember" type="checkbox" name="remember" id="remember"/> Запомнить меня</label>
                                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                                    <input type="submit" class="btn btn-success" value="Войти"/>
                                    <a class="forgot" href="<?=Route::to('users', 'users#forgot')?>">Забыли пароль?</a>
                                </div>
                            </div>
                        </div>
                        <div class="span5">
                            <legend>Вход через соц. сети</legend>
                            <script src="<?=URL::site('main/js/ulogin.js')?>"></script>
                            <div id="uLogin" data-ulogin="display=panel;fields=email,first_name,last_name;optional=photo_big;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter;hidden=;redirect_uri=<?=Route::to('users', 'users#social_login')?>"></div>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>
