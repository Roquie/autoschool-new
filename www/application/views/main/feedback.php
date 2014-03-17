<?=HTML::style('main/css/login.css')?>
<div class="container">
    <div class="row">
        <div class="span10 offset1 wrap">
            <form class="form-horizontal" action="<?=Request::current()->url()?>" method="POST" accept-charset="utf-8" novalidate>
                <fieldset>
                    <div class="row">
                        <div class="span5 pull-left">
                            <legend>Форма обратной связи</legend>
                            <?if(isset($error)):?>
                                <div class="alert alert-danger">
                                    <?=$error?>
                                </div>
                            <?endif?>
                            <?if(isset($success)):?>
                                <div class="alert alert-success">
                                    <?=$success?>
                                </div>
                            <?endif?>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
