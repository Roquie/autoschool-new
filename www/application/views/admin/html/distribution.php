
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->

<style type="text/css">
    .modal {
        width: 550px;
        margin-left: -275px;
    }
    .modal-body {
        /*float: right;
        width: 400px;*/
        overflow: hidden;
    }

    #sortable1, #sortable2 { padding: 5px; width: 173px;}

    #sortable1 li, #sortable2 li {
        margin: 5px 0 10px;
        font-size: 1.2em;
        width: 185px;
    }

    #sortable2 .ui-state-highlight {
        height: 1.5em;
        line-height: 1.2em;
        border: 1px dashed #aaa;
        background: #ccc;
    }

    .ui-state-default {
        cursor: pointer;
    }
    .ui-state-default:hover {
        color: #0060fc;
    }

</style>
<?=HTML::script('adm/js/distribution.js')?>

<!-- Modal -->
<div id="distribution" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="twitter">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="global-tweet-dialog-header">
                Распределение по группам
            </h3>
        </div>
        <div class="modal-body">


            <p style="text-align: center">
                Перенос слушателей из одной группы в другую возможен из левой колонки, в правую.
            </p>
            <br/>

            <input type="hidden" name="csrf" class="csrf" value="<?=Security::token()?>"/>

            <div class="span3 pull-left" style="margin-left: 0">

                <label for="">Выберите группу</label>
                <select name="left" id="dist_groups" class="dist_groups" data-url="<?=URL::site('admin/index/get_user_dist')?>">
                    <option value="0" selected="selected">Без группы</option>
                    <?foreach($list_groups as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>

                <div class="sms_list_listeners dist_list_user">
                    <ul id="sortable1" class="unstyled">
                        <li class="ui-state-default">Item 1</li>
                        <li class="ui-state-default">Item 2</li>
                        <li class="ui-state-default">Item 3</li>
                        <li class="ui-state-default">Item 4</li>
                        <li class="ui-state-default">Item 5</li>
                    </ul>
                </div>
            </div>
            <div class="span3 pull-right">

                <label for="">Выберите группу</label>
                <select name="right" id="dist_groups" class="dist_groups" data-url="<?=URL::site('admin/index/get_user_dist')?>">
                    <?foreach($list_groups as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>

                <div class="sms_list_listeners dist_list_user">
                    <ul id="sortable2" class="connectedSortable unstyled">
                        <li>Item 1</li>
                        <li>Item 2</li>
                        <li>Item 3</li>
                        <li>Item 4</li>
                        <li>Item 5</li>
                    </ul>
                </div>
            </div>

            <input type="hidden" class="url-add" data-url="<?=URL::site('admin/index/distribution')?>"/>

        </div>
    </div>
</div>