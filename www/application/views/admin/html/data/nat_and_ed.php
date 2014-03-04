<?=HTML::style('adm/css/nat_and_edu.css')?>

<div class="container">
    <div class="row">
        <div class="span12 pull-left">
            <h1><small>Гражданство и образование</small></h1>
        </div>
    </div>

    <? if(isset($errors)) : ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?=array_shift($errors)?>
        </div>
    <? endif ?>

    <div class="row">
        <div class="span6">
            <div class="well">
                <h5 class="header_block">Гражданство</h5>
                <form  action="<?=URL::site('admin/other/natandedu/create_nat')?>" method="post" accept-charset="utf-8" novalidate>
                    <label for="national_add">Добавить</label>
                    <input id="national_add" type="text" name="grajdanstvo"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <input type="submit" style="margin-top: -10px" class="btn" value="OK"/>
                </form>
                <table class="table table_admins" id="national">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?$i=0;foreach($national as $v):?>
                        <tr id="<?=$v->id?>">
                            <td><?=++$i?></td>
                            <td><?=$v->grajdanstvo?></td>
                            <td><a href="<?=URL::site('admin/other/natandedu/delete_nat/?id='.$v->id.'&csrf='.Security::token())?>" style="display: table; margin: 0 auto; width: 27px; height: 18px" class="badge badge-important delete"><i class="icon-remove"></i></a></td>
                        </tr>
                    <?endforeach?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="span6">
            <div class="well">
                <h5 class="header_block">Образование</h5>
                <form action="<?=URL::site('admin/other/natandedu/create_edu')?>" method="post" accept-charset="utf-8" novalidate>
                    <label for="edu_add">Добавить</label>
                    <input id="edu_add" type="text" name="obrazovanie"/>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <input type="submit" style="margin-top: -10px" class="btn" value="OK"/>
                </form>
                <table class="table" id="edu">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?$i=0;foreach($edu as $v):?>
                        <tr id="<?=$v->id?>">
                            <td><?=++$i?></td>
                            <td><?=$v->obrazovanie?></td>
                            <td><a href="<?=URL::site('admin/other/natandedu/delete_edu/?id='.$v->id.'&csrf='.Security::token())?>" style="display: table; margin: 0 auto; width: 27px; height: 18px" class="badge badge-important delete"><i class="icon-remove"></i></a></td>
                        </tr>
                    <?endforeach?>

                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>