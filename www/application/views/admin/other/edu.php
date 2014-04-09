<div class="well" style="width: 420px; height: 320px">
    <form action="<?=URL::site('admin/other/edu')?>" method="post" accept-charset="utf-8" novalidate>
        <label for="edu_add">Добавить</label>
        <input id="edu_add" type="text" name="name"/>
        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
        <input type="submit" style="margin-top: -10px" class="btn" value="OK"/>
    </form>
    <? if (count($edu) == 0) : ?>
        <div class="text-center not-found">Образования не найдены.</div>
    <? else : ?>
        <table class="table" id="edu">
            <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?$i=$edu->count();foreach($edu as $v):?>
                <tr id="<?=$v->id?>">
                    <td><?=$i--?></td>
                    <td><?=$v->name?></td>
                    <td><a href="<?=URL::site('admin/other/edu/remove/?id='.$v->id.'&csrf='.bin2hex(Security::token()))?>" style="display: table; margin: 0 auto; width: 27px; height: 18px" class="badge badge-important delete"><i class="icon-remove"></i></a></td>
                </tr>
            <?endforeach?>

            </tbody>
        </table>
    <? endif; ?>
</div>
