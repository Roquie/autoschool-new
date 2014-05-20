<div class="container">
    <div class="row">
        <div class="span3 pull-left">
            <h1><small>Группы</small></h1>
        </div>
        <div class="span9" style="margin-top: 20px">
            <div class="pull-right">
                <a href="#tab1" class="btn active" data-toggle="tab">Просмотр/Редакт.</a>
                <a href="#tab2" class="btn" data-toggle="tab">Добавление</a>
                <div class="btn-group">
                    <a href="<?=URL::site('/print/pdf')?>" target="_blank" data-placement="bottom" rel="tooltip" title="Распечатать список слушателей" class="btn"><i class="icon-print"></i></a>
                    <a href="<?=URL::site('/download/print/name')?>" data-placement="bottom" rel="tooltip" title="Загрузить документ со списоком слушателей" class="btn btn-success"><i class="icon-download"></i></a>
                    <a href="#" data-placement="bottom" rel="tooltip" title="Открыть список слушателей" class="btn btn-info"><i class="icon-eye-open"></i></a>
                </div>
                <a href="#" class="btn btn-success" data-placement="bottom" rel="tooltip" title="Распределение слушателей подавших заявку по группам">Кнопка</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span3">
            <div class="well" >
                <h5 class="header_block">Наименование группы</h5>
                <div class="wrap" data-url="<?=URL::site('admin/listeners/getUser')?>">
                    <?=View::factory('admin/html/groups_index', compact('groups'))?>
                </div>
            </div>
<!--                <div style="overflow-x: auto; height: 634px; padding-left: 2px; padding-right: 25px">
                    <?/*=View::factory('admin/html/groups_index', compact('groups'))*/?>
                </div>-->

        </div>

        <?=$content?>

    </div>

</div>