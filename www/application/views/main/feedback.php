<?=HTML::style('main/css/login.css')?>
<div class="container">
    <div class="row">
        <div class="span10 offset1 wrap">
            <form class="form-horizontal" action="<?=Request::current()->url()?>" method="POST" accept-charset="utf-8" novalidate>
                <fieldset>
                    <div class="row">
                        <div class="span8 pull-left">
                            <legend>Форма обратной связи</legend>
                            <?if(isset($error)):?>
                                <div class="row">
                                    <div class="span1">
                                        <a href="#" class="btn" onclick="window.history.go(-1); return false;">Назад</a>
                                    </div>
                                    <div class="span6">
                                        <div class="alert alert-danger">
                                            <?=$error?>
                                        </div>
                                    </div>
                                </div>
                            <?endif?>
                            <?if(isset($success)):?>
                                <div class="row">
                                    <div class="span1">
                                        <a href="#" class="btn" onclick="window.history.go(-1); return false;">Назад</a>
                                    </div>
                                    <div class="span6">
                                        <div class="alert alert-success">
                                            <?=$success?>
                                        </div>
                                    </div>
                                </div>
                            <?endif?>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
