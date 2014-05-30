<?=HTML::style('main/css/login.css')?>
<div class="container">
    <div class="row">
        <div class="span10 offset1 wrap">
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
            <form class="form-horizontal" action="<?=Request::current()->url()?>" method="POST" accept-charset="utf-8" novalidate>
                <fieldset>
                    <legend>Восстановить доступ к аккаунту</legend>
                    <div class="control-group">
                        <label class="control-label"  for="username">Email (или моб. тел.)</label>
                        <div class="controls">
                            <input type="email" id="email" name="tel_or_email" class="input-xlarge" autocomplete="off">
                            <p class="help-block forgot-info" style="margin-top: 0; font-size: 8pt">новый пароль вышлем вам на почту или на моб. телефон</p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" class="btn btn-success" value="ОК"/>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>