<?=HTML::style('adm/css/global_other.css')?>
<?=View::factory('errors/msg')?>
<div class="row">
    <div class="span4">
        <div class="well">
            <h5 class="header_block">Добавить </h5>
            <p class="awesome_text">Эта "должность" будет отображена при заполнении данных сотрудника</p>
            <form  action="<?=URL::site('admin/other/office')?>" method="post" accept-charset="utf-8" novalidate>
                <!--<label for="office_add">Введите наименование</label>-->
                <input id="office_add" type="text" name="name" style="width: 94%"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <input type="submit" style="margin-top: 10px; width: 100%" class="btn btn-success" value="Добавить должность"/>
            </form>
        </div>
    </div>
    <div class="span8">
        <div class="well" style="height: 203px">
            <h5 class="header_block">Список созданных</h5>
            <?if(count($office) == 0):?>
                <div class="text-center not-found">Должности не найдены.</div>
            <?else:?>
                <table class="table table_admins" id="national">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th><?= ($info->is_root) ? 'Удалить' : null?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?$count = $office->count(); foreach($office as $v):?>
                        <tr class="content_rows" id="<?=$v->id?>">
                            <td><?=$count--?></td>
                            <td><?=$v->name?></td>
                            <td>
                                <? if ($info->is_root) : ?>
                                    <a style="height: 21px; padding: 2px 10px 2px 10px" href="<?=URL::site('admin/other/office/remove/?id='.$v->id.'&csrf='.bin2hex(Security::token()))?>" rel="tooltip" title="Удаляется без предупреждения!" class="btn btn-danger"><i class="icon-trash"></i></a>
                                <? endif; ?>
                            </td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
            <?endif?>
        </div>
    </div>
</div>


