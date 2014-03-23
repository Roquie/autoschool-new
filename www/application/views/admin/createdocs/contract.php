<ul id="tabs" class="nav nav-tabs">
    <li><a href="<?=URL::site('admin/createdocs')?>">Заявление</a></li>
    <li class="active"><a href="<?=URL::site('admin/createdocs/contract')?>">Договор</a></li>
</ul>

<div class="row">
    <div class="span10">
        <div class="span4">
            <form action="#" method="post" accept-charset="utf-8" novalidate>
                <label for="is_individual">
                    <!-- я хз как написать иначе-->
                <input type="checkbox" style="width: 16px; margin-bottom: 5px" name="is_individual" id="is_individual" />
                    Заказчик, тот, кто писал заявление
                </label>
            </form>
        </div>




    </div>
    <div class="row pull-right">
        <div class="span3">
            <input type="button" id="generateContract" class="btn btn-success " name="ok" value="Сгенерировать"/>
        </div>
        <div class="span3">
            <input type="button" class="btn btn-info" id="send" value="Сохранить в базе" data-url="<?=URL::site('admin/listeners/g_add')?>">
        </div>
    </div>
</div>