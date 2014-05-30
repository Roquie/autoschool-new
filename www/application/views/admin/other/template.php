<div class="container">
    <div class="row">
        <div class="span12 pull-left">
            <h1><small>Вспомогательная информация</small></h1>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <?foreach($menu as $controller => $name):?>
            <?if(UTF8::strtolower(Request::initial()->controller()) == $controller):?>
                <li class="active"><a href="<?=URL::site('admin/other/'.$controller)?>"><?=$name?></a></li>
            <?else:?>
                <li><a href="<?=URL::site('admin/other/'.$controller)?>"><?=$name?></a></li>
            <?endif?>
        <?endforeach?>
    </ul>

    <?=$content?>

</div>