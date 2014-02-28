<div class="container" style="margin-top: 35px">
    <div id="result">
        <h2 class="info">
            Чтобы оставить заявку на поступление в автошколу, вам нужно просто ввести необходимую информацию в соответствующие поля. Всё остальное мы сделаем за вас. <br>
            Далее в личном кабинете, по желанию, Вы можете указать дополнительные данные для договора и заявления.
        </h2>
        <br>
        <!--css-->
        <?=HTML::style('main/css/stylizationForm.css')?>
        <?=HTML::style('main/css/datepicker.css')?>
        <?=HTML::style('main/css/statement.css')?>
        <?=HTML::style('main/css/chosen.css')?>
        <!--js-->
        <?=HTML::script('main/js/chosen.jquery.min.js')?>
        <?=HTML::script('main/js/jquery.maskedinput.min.js')?>
        <?=HTML::script('main/js/statement.js')?>
        <?=HTML::script('main/js/stylizationForm.js')?>

        <?if(isset($errors)):?>
            <div class="alert alert-danger"><?=array_shift($errors)?></div>
        <?endif?>
        <div class="well form-block">
            <div class="row-fluid">
                <div class="span6 separator">
                    <form id="statement" action="<?=Route::to('users', 'users#register')?>" method="post" novalidate>
                        <h2 class="page_header">Обычная регистрация</h2>
                        <label for="famil">Фамилия</label>
                        <input type="text" id="famil" autofocus="autofocus" name="famil"  tabindex="1" value="<?=isset($post['famil']) ? $post['famil'] : null?>">
                        <label for="imya">Имя</label>
                        <input type="text" name="imya" id="imya" tabindex="2" value="<?=isset($post['imya']) ? $post['imya'] : null?>">
                        <label for="ot4estvo">Отчество</label>
                        <input type="text" name="ot4estvo" id="ot4estvo" tabindex="3" value="<?=isset($post['ot4estvo']) ? $post['ot4estvo'] : null?>">
                        <label id="mob_tel">Мобильный телефон</label>
                        <input type="text" id="mob_tel" name="mob_tel" placeholder="8 (926) 123-45-67" tabindex="4" value="<?=isset($post['mob_tel']) ? $post['mob_tel'] : null?>">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" tabindex="5" value="<?=isset($post['email']) ? $post['email'] : null?>">
                        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                        <input type="submit" class="btn btn-info btn-block" value="Зарегистрироваться"/>
                    </form>
                </div>
                <div class="span6 social">
                    <h2 class="page_header">Регистрация через соц. сети</h2>
                    <div class="icons">
                            <script src="<?=URL::site('main/js/ulogin.js')?>"></script>
                            <div id="uLogin" data-ulogin="display=panel;fields=email,first_name,last_name;optional=photo_big;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter;hidden=;redirect_uri=<?=URL::site('/users/social')?>"></div>
                    </div><br>
                    <div class="text">
                        <p>Вы можете авторизоваться у нас без регистрации и ввода пароля. То есть если у Вас уже есть логин на одном из этих сайтов, Вы можете войти к нам с помощью этого сайта.</p>
                    </div>
                </div>
            </div>


        </div>

        </div>
    </div>
</div>
