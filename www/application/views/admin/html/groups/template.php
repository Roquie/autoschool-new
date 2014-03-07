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
                    <a href="<?=URL::site('/print/pdf')?>" target="_blank" rel="tooltip" title="Распечатать список слушателей" class="btn"><i class="icon-print"></i></a>
                    <a href="<?=URL::site('/download/print/name')?>" rel="tooltip" title="Загрузить документ со списоком слушателей" class="btn btn-success"><i class="icon-download"></i></a>
                    <a href="#" rel="tooltip" title="Открыть список слушателей" class="btn btn-info"><i class="icon-eye-open"></i></a>
                </div>
                <a href="#" class="btn btn-success" data-placement="left" rel="tooltip" title="Распределение слушателей подавших заявку по группам">Кнопка</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span3">
            <div class="well" >
                <h5 class="header_block">Наименование группы</h5>
                <div style="overflow-x: auto; height: 634px; padding-left: 2px; padding-right: 25px">
                    <ul class="unstyled">
                        <?foreach($groups as $item):?>
                            <!-- http://stackoverflow.com/questions/9709209/html-select-only-one-checkbox-in-a-group -->
                            <li style="padding: 5px 0 5px 0">
                                <label class="radio">
                                    <input type="radio" name="listeners_names" id="optionsRadios1" value="<?=$item->id?>" checked>
                                    <?=$item->name?>
                                    <div class="pull-right">
                                        <!--<a style="margin-right: 5px" href="#"><span class="badge"><i class="icon-pencil"></i></span></a>-->
                                        <a href="#"><span class="badge badge-important"><i class="icon-trash"></i></span></a>
                                    </div>
                                </label>
                            </li>
                        <?endforeach?>
                    </ul>
                </div>

            </div>
        </div>

        <?=$content?>

    </div>

</div>