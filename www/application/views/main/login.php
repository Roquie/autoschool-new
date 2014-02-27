<div class="container">
    <div class="row">
        <div class="span12" style="margin-top: 30px">
            <form class="form-horizontal" action="<?=Route::to('users', 'users#login')?>" method="POST" accept-charset="utf-8" novalidate>
                <fieldset>
                    <?if(isset($errors)):?>
                        <div class="alert alert-danger"><?=array_shift($errors)?></div>
                    <?endif?>
                    <div id="legend">
                        <legend class="">Вход в личный кабинет</legend>
                    </div>
                    <div class="control-group">
                        <!-- Username -->
                        <label class="control-label"  for="username">Email</label>
                        <div class="controls">
                            <input type="email" id="email" name="email" placeholder="example@gmail.com" class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- Password-->
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input type="password" id="password" name="password" placeholder="************" class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- Button -->
                        <div class="controls">
                            <p><input type="checkbox" name="remember"/> Запомнить меня</p>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" class="btn btn-success" value="Войти"/>
                        </div>
                    </div>
                </fieldset>
            </form>
            <div class="span24">
                <script src="//ulogin.ru/js/ulogin.js"></script>
                <div id="uLogin" data-ulogin="display=panel;fields=email,first_name,last_name,city,country;optional=photo_big;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter;hidden=;redirect_uri=<?=Route::to('users', 'users#social_login')?>"></div>
            </div>
        </div>

        <div>

        </div>
    </div>
</div>
