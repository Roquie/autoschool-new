<?=HTML::style('adm/css/global_other.css')?>
<?=View::factory('errors/msg')?>
<div class="row">
    <div class="span4">
        <div class="well">
            <h5 class="header_block">Добавить </h5>
            <p class="awesome_text">Это "гражданство" будет отображено при заполнении данных слушателя</p>
            <form  action="<?=URL::site('admin/other/national')?>" method="post" accept-charset="utf-8" novalidate>
                <!--<label for="national_add">Введите наименование</label>-->
                <input id="national_add" type="text" name="name" style="width: 94%"/>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <input type="submit" style="margin-top: 10px; width: 100%" class="btn btn-success" value="Добавить гражданство"/>
            </form>
        </div>
    </div>
    <div class="span8">
        <div class="well">
            <h5 class="header_block">Список созданных</h5>
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
                    <?$count = $national->count(); foreach($national as $v):?>
                        <tr class="content_rows" id="<?=$v->id?>">
                            <td><?=$count--?></td>
                            <td><?=$v->name?></td>
                            <td>
                                <a style="height: 21px; padding: 2px 10px 2px 10px" href="<?=URL::site('admin/other/national/remove/?id='.$v->id.'&csrf='.bin2hex(Security::token()))?>" rel="tooltip" title="Удаляется без предупреждения!" class="btn btn-danger"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
            <?endif?>
        </div>
    </div>
</div>

