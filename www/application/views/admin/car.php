
<?=HTML::script('adm/js/cars.js')?>

<div class="container wrap_car">
    <div class="row">
        <div class="span6">
            <h1><small>Транспорт</small></h1>
        </div>
        <div class="span6" style="margin-top: 25px; margin-bottom: 20px">
            <div class="pull-right">
                <a href="#" class="btn btn-change edit active" data-url="<?=URL::site('admin/cars/edit')?>">Просмотр/Редакт.</a>
                <a href="#" class="btn btn-change add" data-url="<?=URL::site('admin/cars/add')?>">Добавление</a>
                <a href="#" data-url="<?=URL::site('admin/cars/del_car?csrf='.bin2hex(Security::token()).'&id=')?>" data-placement="bottom" rel="tooltip" title="Удалить машину" class="btn btn-danger del_car"><i class="icon-trash"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span3">
            <div class="well" id="list_groups">
                <h5 class="header_block">Машины</h5>
                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="wrap" id="cars" data-url="<?=URL::site('admin/cars/getCar')?>" style="height: 335px">
                    <?=View::factory('admin/html/list_car', compact('cars'))?>
                </div>
            </div>
        </div>
        <form action="<?=URL::site('admin/cars/edit')?>" method="post" accept-charset="utf-8" style="margin-bottom: 0" novalidate id="car_form">
            <div class="span9" id="data_for_group">
                <div class="well" style="height: 370px">
                    <div class="row">

                        <div class="span8">
                            <legend>Информация о машине</legend>
                        </div>

                        <div class="span4">
                            <div class="row">
                                <div class="span4">
                                    <label for="name">Машина</label>
                                    <input type="text" class="span4" name="name" id="name"/>
                                </div>
                                <div class="span4">
                                    <label for="reg_number">Регистрационный номер</label>
                                    <input type="text" class="span4" name="reg_number" id="reg_number"/>
                                </div>
                                <div class="span4">
                                    <label for="description">Описание</label>
                                    <input type="text" class="span4" name="description" id="description"/>
                                </div>
                                <div class="span4">
                                    <label for="doc_seriya">Серия документа</label>
                                    <input type="text" class="span4" name="doc_seriya" id="doc_seriya"/>
                                </div>
                            </div>
                        </div>
                        <div class="span4 pull-right">
                            <div class="row">
                                <div class="span4">
                                    <label for="doc_nomer">Номер документа</label>
                                    <input type="text" class="span4" name="doc_nomer" id="doc_nomer"/>
                                </div>
                                <div class="span4">
                                    <label for="doc_data_reg">Дата регистрации</label>
                                    <div class="input-append">
                                        <input type="text" class="datepicker_adm" name="doc_data_reg" id="doc_data_reg" style="width: 137%">
                                        <span class="add-on btn" id="calendar"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="span4">
                                    <label for="doc_place_reg">Место регистрации</label>
                                    <input type="text" class="span4" name="doc_place_reg" id="doc_place_reg"/>
                                </div>
                                <div class="span4">
                                    <label for="staff_id">Принадлежит</label>
                                    <select name="staff_id" id="staff_id" class="span4">
                                        <? foreach ($staffs as $key => $item) : ?>
                                            <option value="<?=$key?>"><?=$item?></option>
                                        <? endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                    <input type="hidden" name="car_id" id="car_id"/>
                    <button type="submit" id="button" class="btn btn-success btn-block" style="margin-top: 20px">
                        Сохранить
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>