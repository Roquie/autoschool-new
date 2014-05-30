<?foreach($groups as $key => $value):?>
    <label class="checkbox">
        <input type="checkbox" value="<?=$value->id?>" name="group_name"/>
        <span class="pull-left"><?=$value->name?></span>
<!--        <div class="pull-right">
            <!--<a style="margin-right: 5px" href="#"><span class="badge"><i class="icon-pencil"></i></span></a>--
            <a href="#"><span class="badge badge-important"><i class="icon-trash"></i></span></a>
        </div>-->
    </label>
<?endforeach?>