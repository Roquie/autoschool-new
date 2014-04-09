<div class="well" style="width: 420px; height: 320px">
    <form  action="<?=URL::site('admin/other/national')?>" method="post" accept-charset="utf-8" novalidate>
        <label for="national_add">Добавить</label>
        <input id="national_add" type="text" name="name"/>
        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
        <input type="submit" style="margin-top: -10px" class="btn" value="OK"/>
    </form>
    <?if(count($national) == 0):?>
        <div class="text-center not-found">Граждаства не найдены.</div>
    <?else:?>
        <table class="table table_admins" id="national">
            <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?$i=$national->count();foreach($national as $v):?>
                <tr id="<?=$v->id?>">
                    <td><?=$i--?></td>
                    <td><?=$v->name?></td>
                    <td><a href="<?=URL::site('admin/other/national/remove/?id='.$v->id.'&csrf='.bin2hex(Security::token()))?>" style="display: table; margin: 0 auto; width: 27px; height: 18px" class="badge badge-important delete"><i class="icon-remove"></i></a></td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    <?endif?>
</div>
