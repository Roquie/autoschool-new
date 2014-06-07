<?=HTML::style('adm/css/group.css')?>
<?=HTML::script('adm/js/group.js')?>
<div class="row">
    <div class="span12" style="margin: 0 19px 20px">
        <div class="pull-right">
            <a href="#" class="btn btn-change edit active" data-url="<?=URL::site('admin/other/group/edit')?>">Просмотр/Редакт.</a>
            <a href="#" class="btn btn-change add" data-url="<?=URL::site('admin/other/group/add')?>">Добавление</a>
            <div class="btn-group">
                <a href="<?=URL::site('/print/pdf')?>" target="_blank" data-placement="bottom" rel="tooltip" title="Распечатать список слушателей" class="btn"><i class="icon-print"></i></a>
                <a href="<?=URL::site('/download/print/name')?>" data-placement="bottom" rel="tooltip" title="Загрузить документ со списоком слушателей" class="btn btn-success"><i class="icon-download"></i></a>
                <a href="#" data-placement="bottom" rel="tooltip" title="Открыть список слушателей" class="btn btn-info"><i class="icon-eye-open"></i></a>
                <a href="#" data-url="<?=URL::site('admin/other/group/del_group?csrf='.bin2hex(Security::token()).'&id=')?>" data-placement="bottom" rel="tooltip" title="Удалить группу" class="btn btn-danger del_group"><i class="icon-trash"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="span3">
        <div class="well" id="list_groups">
            <h5 class="header_block">Наименование группы</h5>
            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
            <div class="wrap" id="groups" data-url="<?=URL::site('admin/other/group/getGroup')?>" style="height: 515px">
                <?=View::factory('admin/html/groups_index', compact('groups'))?>
            </div>
        </div>
    </div>
    <form action="<?=URL::site('admin/other/group/edit')?>" method="post" accept-charset="utf-8" style="margin-bottom: 0" novalidate id="group_form">
        <div class="span9" id="data_for_group">
            <div class="well">
                <div class="row">
                    <div class="span3">
                        <label for="name">Название группы:</label>
                        <input id="name" name="name" type="text" style="width: 150px">
                    </div>
                    <div class="span3">
                        <label for="start_lessons">Начало занятий:</label>
                        <div class="input-append">
                            <input id="start_lessons" class="datepicker_adm" name="data_start" type="text" style="width: 124px">
                            <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="span2">
                        <label for="end_driving">Окончание занятий:</label>
                        <div class="input-append">
                            <input id="end_driving" class="datepicker_adm" name="data_end" type="text" style="width: 124px">
                            <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span3">
                        <label for="teacher_pdd">Преподаватель ПДД:</label>
                        <select style="width: 165px" name="pdd_teacher" id="teacher_pdd">
                            <option value="" selected="selected"> --- </option>
                            <? foreach ($staffs['teachers'] as $key => $item) : ?>
                                <option value="<?=$key?>"><?=$item?></option>
                            <? endforeach ?>
                        </select>
                    </div>
                    <div class="span3">
                        <label for="teacher_tu_and_to">Преподаватель ТУ и ТО:</label>
                        <select style="width: 165px" name="tyto_teacher" id="teacher_tu_and_to">
                            <option value="" selected="selected"> --- </option>
                            <? foreach ($staffs['teachers'] as $key => $item) : ?>
                                <option value="<?=$key?>"><?=$item?></option>
                            <? endforeach ?>
                        </select>
                    </div>
                    <div class="span2" style="width: 155px">
                        <label for="teacher_opmt">Преподаватель ОПМТ:</label>
                        <select style="width: 165px" name="med_teacher" id="teacher_opmt">
                            <option value="" selected="selected"> --- </option>
                            <? foreach ($staffs['teachers'] as $key => $item) : ?>
                                <option value="<?=$key?>"><?=$item?></option>
                            <? endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="well">
                <div class="row">
                    <div class="span4">
                        <label for="category">Категория прав:</label>
                        <select style="width: 225px" id="category" name="category_id">
                            <option value="0" selected="selected"> --- </option>
                            <? foreach ($category as $key => $item) : ?>
                                <option value="<?=$item->id?>"><?=$item->name?></option>
                            <? endforeach ?>
                        </select>
                    </div>
                    <div class="span4 instructors_slct">
                        <label for="instructors">Водители - инструкторы:</label>
                        <div class="input-append">
                            <select style="width: 225px" id="instructors" name="instructors[]">
                                <option value="" selected="selected"> --- </option>
                                <? foreach ($staffs['instructors'] as $key => $item) : ?>
                                    <option value="<?=$key?>"><?=$item?></option>
                                <? endforeach ?>
                            </select>
                            <a href="#" class="btn add_instructor" style="margin-left: 15px"><i class="icon-plus"> Добавить</i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="well">
                <div class="row">
                    <div class="span7">
                        <h5 style="margin-top: 0">Дни и часы занятий</h5>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>День недели</th>
                                <th style="width: 70px">С</th>
                                <th style="width: 70px">До</th>
                                <th style="width: 150px">Предмет</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <select name="lessons[1][day_of_week]" class="day_of_week" id="day_of_week" style="width: 150px">
                                        <option selected="selected" value=""> --- </option>
                                        <option value="1">Понедельник</option>
                                        <option value="2">Вторник</option>
                                        <option value="3">Среда</option>
                                        <option value="4">Четверг</option>
                                        <option value="5">Пятница</option>
                                    </select>
                                </td>
                                <td><input type="text" name="lessons[1][time_start]" class="time_start" placeholder="17:00" style="width: 70px"/></td>
                                <td><input type="text" name="lessons[1][time_end]" class="time_end" placeholder="20:00" style="width: 70px"/></td>
                                <td><input type="text" name="lessons[1][lesson]" class="lesson" placeholder="ПДД" style="width: 70px"/></td>
                                <td style="text-align: center"><a href="#" class="btn btn-danger remove_lessons"><i class="icon-remove"></i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="span1">
                        <div class="buttons" style="margin-top: 30px; margin-left: 0px">
                            <a href="#" class="btn btn-primary" id="add_lessons" rel="tooltip" title="Добавить расписание"><i class="icon-plus"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="well">
                <div class="row">
                    <div class="span8">
                        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                        <input type="hidden" name="group_id" id="group_id"/>

                        <button type="submit" id="button" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

