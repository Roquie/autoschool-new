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

        <?=HTML::script('js/general/put_doc.js')?>
        <div class="well form-block">
            <!--<h2>Регистрация</h2>-->
            <div class="row">
                <p style="text-align: center; font-weight: 600; padding: 0 20px 10px 20px">Выберите Вашу соц. сеть. Это быстро и удобно. Тогда Вам не придется помнить пароль от профиля в Автошколе МПТ, поребуется нажать всего одну кнопку.</p>
                <div class="span6 offset4">
                    <script src="//ulogin.ru/js/ulogin.js"></script>
                    <div id="uLogin" data-ulogin="display=panel;fields=email,first_name,last_name,city,country;optional=photo_big;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter;hidden=;redirect_uri=<?=URL::site('/users/social')?>"></div>
                </div>
            </div>
            <p style="text-align: center;  margin-top: 20px"> ... или зарегистрируйтесь обычным способом: </p>
            <br/>

            <form id="statement" action="#" method="post">
                <div class="row-fluid">
                    <div class="span6">
                        <label for="family_name">Фамилия</label>
                        <input type="text" id="family_name" autofocus="autofocus" name="family_name" data-placement="top" data-req="true" tabindex="1">
                        <label for="first_name">Имя</label>
                        <input type="text" name="first_name" id="first_name" data-req="true" tabindex="2">
                        <label for="daddy_name">Отчество</label>
                        <input type="text" name="daddy_name" id="daddy_name" tabindex="3">
                    </div>
                    <div class="span6">
                        <label id="mob_tel">Мобильный телефон</label>
                        <input type="text" id="mob_tel" name="mob_tel" placeholder="8 (926) 123-45-67" data-req="true"  tabindex="12">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" data-req="true" tabindex="2">

                        <input style="margin-top: 25px" type="submit" class="btn btn-info btn-block" value="Зарегистрироваться"/>
                    </div>
                </div>

            </form>
        </div>

        </div>
    </div>
</div>
