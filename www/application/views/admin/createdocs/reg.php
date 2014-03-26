<div class="span6 separator">
    <form id="statement" action="<?=Route::to('users', 'users#register')?>" method="post" novalidate>
        <label for="famil">Фамилия</label>
        <input type="text" id="famil" autofocus="autofocus" name="famil"  tabindex="1" value="<?=isset($post['famil']) ? $post['famil'] : null?>">
        <label for="imya">Имя</label>
        <input type="text" name="imya" id="imya" tabindex="2" value="<?=isset($post['imya']) ? $post['imya'] : null?>">
        <label for="otch">Отчество</label>
        <input type="text" name="otch" id="otch" tabindex="3" value="<?=isset($post['otch']) ? $post['otch'] : null?>">
        <label id="tel">Мобильный телефон</label>
        <input type="text" id="tel" name="tel" placeholder="8 (926) 123-45-67" tabindex="4" value="<?=isset($post['tel']) ? $post['tel'] : null?>">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" tabindex="5" value="<?=isset($post['email']) ? $post['email'] : null?>">
        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
        <input type="submit" class="btn btn-info btn-block" value="Зарегистрироваться"/>
    </form>
</div>