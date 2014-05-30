<style type="text/css">
    .custom_p {
        margin-bottom: 3px;
    }
</style>
<div class="tab-content">

<!-- добавление -->
<div class="tab-pane active" id="tab1">
    <form action="#" method="post" accept-charset="utf-8" style="margin-bottom: 0" novalidate id="group_form">
        <div class="span9">
            <div class="well">
                <div class="row">
                    <div class="span3">
                        <label for="start_lessons">Начало занятий:</label>
                        <div class="input-append">
                            <input id="start_lessons" name="data_start" type="text" style="width: 124px">
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="span3">
                        <label for="end_driving">Окончание занятий:</label>
                        <div class="input-append">
                            <input id="end_driving" name="data_end" type="text" style="width: 124px">
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span3">
                        <label for="teacher_pdd">Преподаватель ПДД</label>
                        <select style="width: 165px" name="pdd_teacher" id="teacher_pdd">
                            <option selected> --- </option>
                            <option>Шуверов В.В.</option>
                            <option>Шацкий И.А.</option>
                            <option>Коротков С.А.</option>
                            <option>Самозванцев Л.Л</option>
                        </select>
                    </div>
                    <div class="span3">
                        <label for="teacher_tu_and_to">Преподаватель ТУ и ТО:</label>
                        <select style="width: 165px" name="tyto_teacher" id="teacher_tu_and_to">
                            <option selected> --- </option>
                            <option>Самозванцев Л.Л</option>
                            <option>Шацкий И.А.</option>
                            <option>Коротков С.А.</option>
                            <option>Шуверов В.В.</option>
                        </select>
                    </div>
                    <div class="span2" style="width: 155px">
                        <label for="teacher_opmt">Преподаватель ОПМТ:</label>
                        <select style="width: 165px" name="med_teacher" id="teacher_opmt">
                            <option selected> --- </option>
                            <option>Шуверов В.В.</option>
                            <option>Шацкий И.А.</option>
                            <option>Коротков С.А.</option>
                            <option>Самозванцев Л.Л</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="well">
                <div class="row">
                    <div class="span4">
                        <label for="start_lessons">Директор автошколы:</label>
                        <div class="input-append">
                            <input id="start_lessons" name="start_lessons" type="text" style="width: 205px" placeholder="">
                            <span class="add-on"><i class="icon-user"></i></span>
                        </div>
                    </div>
                    <div class="span4">
                        <label for="start_lessons">Водители - инструкторы:</label>
                        <div class="input-append">
                            <select style="width: 225px" name="teacher_opmt" id="teacher_opmt">
                                <option selected> --- </option>
                                <option>Шуверов В.В.</option>
                                <option>Шацкий И.А.</option>
                                <option>Коротков С.А.</option>
                                <option>Самозванцев Л.Л</option>
                            </select>
                            <a href="#" class="btn" style="margin-left: 15px"><i class="icon-plus"> Добавить</i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="well">
                <div class="row">
                    <div class="span4">
                        <h5 style="margin-top: 0">Расписание занятий</h5>
                    </div>
                    <div class="span4">
                        <h5 style="margin-top: 0">Экзамен</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>День недели</th>
                                <th>С</th>
                                <th>До</th>
                                <th>Предмет</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Понедельник</td>
                                <td>17:00</td>
                                <td>20:00</td>
                                <td>ПДД</td>
                            </tr>
                            <tr>
                                <td>Четверг</td>
                                <td>17:00</td>
                                <td>20:00</td>
                                <td>ТУ и ТО</td>
                            </tr>
                            <tr>
                                <td>Пятница</td>
                                <td>17:00</td>
                                <td>20:00</td>
                                <td>ОПМТ</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: center">Расписание для группы не создано</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="span4">
                        <div class="row">
                            <div class="span2">
                                <label for="predatel">Пред. экз. комиссии</label>
                                <input type="text" name="predatel" id="predatel" style="width: 130px"/>
                                <label for="hui">Члены комиссии</label>
                                <input type="text" name="hui1" id="hui" style="width: 130px"/>
                                <input type="text" name="hui2" id="hui" style="width: 130px"/>

                            </div>
                            <div class="span2">
                                <label for="predatel">Секретарь</label>
                                <input type="text" name="predatel" id="predatel" style="width: 130px"/>
                                <label for="predatel">Протокол номер</label>
                                <input type="text" name="predatel" id="predatel" style="width: 130px"/>
                                <div class="form-inline">
                                    <label for="predatel">от</label>
                                    <div class="input-append">
                                        <input id="end_driving" name="end_driving" type="text" style="width: 80px" placeholder="01.01.13">
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- <input type="hidden" name="csrf" value="<?/*=Security::token()*/?>"/>-->
    </form>
</div>
</div>