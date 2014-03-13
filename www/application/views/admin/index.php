<?=HTML::style('adm/css/listeners.css')?>
<?=HTML::style('global/css/datepicker.css')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>
<div class="container">
    <div class="row">
        <div class="span4">
            <h1><small>Слушатели</small></h1>
        </div>
        <div class="span8 btn_actions">
            <a href="<?=URL::site('/admin/listeners/g_add')?>" class="btn btn-warning pull-right" data-placement="bottom" rel="tooltip" title="Добавить слушателя (или создать документы без добавления данных в БД)">Добавить</a>
            <a href="<?=URL::site('/admin/listeners/distrib')?>" class="btn btn-success pull-right" data-placement="bottom" rel="tooltip" title="Распределение слушателей подавших заявку по группам">Подавшие заявку</a>
        </div>
    </div>

    <div class="row">
        <div class="span3 l_select_group">
            <div class="well">
                <h5 class="header_block">Номер группы</h5>
                <label for="">Выберите:</label>
                <select name="select2">
                    <option value="0" selected="selected">Все ...</option>
<!--                    <?/*foreach($list_groups as $item):*/?>
                        <option value="<?/*=$item->id*/?>"><?/*=$item->name*/?></option>
                    --><?/*endforeach*/?>
                </select>
            </div>
        </div>
        <div class="span9 l_sort">
            <div class="well">
                <h5 class="header_block">Сортировка</h5>
                <form action="#" method="post" accept-charset="utf-8" novalidate>
                    <div class="row">
                        <div class="span2">
                            <label for="contract_from">Договор от:</label>
                            <div class="input-append">
                                <input id="contract_from" name="contract_from" type="text" class="input-small" placeholder="01.01.13">
                                <span class="add-on"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="span2">
                            <label for="">Группа №:</label>
                            <select name="group_num">
                                <option value="0" selected="selected"> --- </option>
                                <?/*foreach($list_groups as $item):*/?><!--
                                    <option value="<?/*=$item->id*/?>"><?/*=$item->name*/?></option>
                                --><?/*endforeach*/?>
                            </select>
                        </div>
                        <div class="span2">
                            <label for="">Водитель-инстр.</label>
                            <select class="teacher_driver" name="teacher_driver" id="l_teacher_driver">
                                <option selected> --- </option>
                                <option>Самозванцев Л.Л</option>
                                <option>Шацкий И.А.</option>
                                <option>Коротков С.А.</option>
                                <option>Шуверов В.В.</option>
                            </select>
                        </div>
                        <div class="pull-right ok">

                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" class="btn" rel="tooltip" title="Применить фильтр" value="OK"/>
                            <a href="#" class="btn" rel="tooltip" title="Сброс фильтра">Сбросить</a>
                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="span3 l_fio">
            <div class="well">
                <h5 class="header_block">Фамилия И.О.</h5>
                <div class="wrap">
                    <?/*foreach($list_users as $item):*/?>
                        <!-- http://stackoverflow.com/questions/9709209/html-select-only-one-checkbox-in-a-group -->
                    <!--<input type="radio" name="listeners_names" style="margin-bottom: 6px"/><span><?/*=$item*/?></span><br>
                    --><?/*endforeach*/?>
                </div>

            </div>
        </div>
        <div class="span9 l_info">
            <div class="well">
                <div class="header-wrap">
                    <h5 class="header_block pull-left">Информация</h5>
                    <div class="btns pull-right">
                        <!-- меняй класс active у кнопок + менять href'ы у кнопок редактирования и удаления (для того чтобы понять что удалять) statement_or_contract -->
                        <a id="l_statement" href="#tab1" class="btn active" data-toggle="tab">Заявление</a>
                        <a id="l_contract" href="#tab2" class="btn" data-toggle="tab">Договор</a>
                    </div>
                </div>
                <div style="margin-top: 40px" class="tab-content">
                    <div class="tab-pane active" id="tab1">

                        <script>
                            $(function() {
                                var body = $('body');

                                /*
                                 * Настройки для календаря
                                 * @type {{monthNames: Array, monthNamesShort: Array, dayNames: Array, dayNamesMin: Array}}
                                 */
                                $.datepicker.regional['ru'] = {
                                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
                                        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                                    monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
                                        'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                                    dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
                                    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
                                };

                                $.datepicker.setDefaults($.datepicker.regional['ru']);

                                $('#data_rojdeniya, #pasport_data_vyda4i, #pasport_data_vyda4i_ind').datepicker({
                                    maxDate: "+0D",
                                    nextText: "&raquo;",
                                    prevText: "&laquo;",
                                    yearRange: "1950:<?=date('Y')?>",
                                    dateFormat: 'dd.mm.yy',
                                    changeMonth: true,
                                    changeYear: true
                                });

                                // Отображение календаря при нажатии на иконку календаря
                                body.on('click', '#calendar', function() {
                                    $(this).closest('.input-append').find('input').datepicker( "show" );
                                });

                                $("#telephone, #telephone_ind").mask("8 (999) 999-99-99");
                                $('#data_rojdeniya, #pasport_data_vyda4i').mask('99.99.9999');
                            });
                        </script>
                        <form method="post" action="#">
                            <table class="table table-striped statement">
                                <tbody>
                                <tr>
                                    <td>Фамилия</td>
                                    <td><input type="text" name="famil" value="Мельников" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Имя</td>
                                    <td><input type="text" name="imya" value="Виктор" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Отчество</td>
                                    <td><input type="text" name="otch" value="Игоревич" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Дата рождения</td>
                                    <td>
                                        <div class="input-append">
                                            <input type="text" id="data_rojdeniya" name="data_rojdeniya" value="07.08.1994" style="width: 87.5%">
                                            <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Место рождения</td>
                                    <td><input type="text" name="mesto_rojdeniya" value="Москва" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Адрес регистрации по паспорту</td>
                                    <td><input type="text" name="adres" value="ул. Одесская, д. 15, кв. 64" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Временная регистрация</td>
                                    <td>
                                        <label class="checkbox">
                                            <input type="checkbox" name="vrem_reg">
                                            имеется
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Гражданство</td>
                                    <td>
                                        <select name="nationality_id" class="input-block-level">
                                            <option value="1">РФ</option>
                                            <option value="2">РБ</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Образование</td>
                                    <td>
                                        <select name="education_id" class="input-block-level">
                                            <option value="1">Высшее</option>
                                            <option value="2">Среднее</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Паспорт серия</td>
                                    <td><input type="text" name="pasport_seriya" value="4509" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Паспорт номер</td>
                                    <td><input type="text" name="pasport_nomer" value="123456" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Дата выдачи паспорта</td>
                                    <td>
                                        <div class="input-append">
                                            <input type="text" id="pasport_data_vyda4i" name="data_rojdeniya" value="08.08.2008" style="width: 87.5%">
                                            <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Кем выдан паспорт</td>
                                    <td><input type="text" name="pasport_kem_vydan" value="ОУФМС РОССИИ по р-ну" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Мобильный телефон</td>
                                    <td><input type="text" name="tel" value="" id="telephone" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Место работы</td>
                                    <td><input type="text" name="mesto_raboty" value="ООО ..." class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Пол</td>
                                    <td>
                                        <select name="sex" class="input-block-level">
                                            <option value="0">Мужской</option>
                                            <option value="1">Женский</option>
                                        </select>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" value="Сохранить" class="btn btn-info btn-block" style="padding: 7px 12px; font-size: 16px"/>
                        </form>

                    </div>

                    <div class="tab-pane" id="tab2">

                        <form action="#" method="post">
                            <table class="table table-striped contract">

                                <tbody>

                                <tr>
                                    <td>Фамилия</td>
                                    <td><input type="text" name="famil" value="Мельников" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Имя</td>
                                    <td><input type="text" name="imya" value="Виктор" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Отчество</td>
                                    <td><input type="text" name="otch" value="Игоревич" class="input-block-level"/></td>
                                </tr>

                                <tr>
                                    <td>Адрес регистрации по паспорту</td>
                                    <td><input type="text" name="adres" value="ул. Одесская, д. 15, кв. 64" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Временная регистрация</td>
                                    <td>
                                        <label class="checkbox">
                                            <input type="checkbox" name="vrem_reg">
                                            имеется
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Паспорт серия</td>
                                    <td><input type="text" name="pasport_seriya" value="4509" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Паспорт номер</td>
                                    <td><input type="text" name="pasport_nomer" value="123456" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Дата выдачи паспорта</td>
                                    <td>
                                        <div class="input-append">
                                            <input type="text" id="pasport_data_vyda4i_ind" name="data_rojdeniya" value="08.08.2008" style="width: 87.5%">
                                            <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Кем выдан паспорт</td>
                                    <td><input type="text" name="pasport_kem_vydan" value="ОУФМС РОССИИ по р-ну" class="input-block-level"/></td>
                                </tr>
                                <tr>
                                    <td>Мобильный телефон</td>
                                    <td><input type="text" name="tel" value="" id="telephone_ind" class="input-block-level"/></td>
                                </tr>

                                </tbody>

                            </table>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" value="Сохранить" class="btn btn-info btn-block" style="padding: 7px 12px; font-size: 16px"/>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>