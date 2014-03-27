<div class="row">
    <div class="span6 separator">
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
        <form id="statement" action="<?=Route::to('admin.createdocs', 'index#save_to_db')?>" method="post" novalidate>
            <label for="famil">Фамилия</label>
            <input type="text" id="famil" autofocus="autofocus" name="famil"  tabindex="1" value="<?=isset($session_data['famil']) ? $session_data['famil'] : null?>">
            <label for="imya">Имя</label>
            <input type="text" name="imya" id="imya" tabindex="2" value="<?=isset($session_data['imya']) ? $session_data['imya'] : null?>">
            <label for="otch">Отчество</label>
            <input type="text" name="otch" id="otch" tabindex="3" value="<?=isset($session_data['otch']) ? $session_data['otch'] : null?>">
            <label id="tel">Мобильный телефон</label>
            <input type="text" id="tel" name="tel" class="telephone" placeholder="8 (926) 123-45-67" tabindex="4" value="<?=isset($session_data['tel']) ? $session_data['tel'] : null?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" tabindex="5" value="<?=isset($session_data['email']) ? $session_data['email'] : null?>">
            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
            <input type="submit" class="btn btn-info btn-block" value="Зарегистрировать персонажа"/>
        </form>
    </div>
    <div class="span5">
        <p>Проверка правильности введенных данных</p>
        <p>После нажатия на кнопку регистрации пользователя в базе данных на его email отправится электронное сообщение, о регистрации в Автошколе МПТ</p>
    </div>
</div>
