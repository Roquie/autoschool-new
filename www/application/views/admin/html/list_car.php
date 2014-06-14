<?foreach($cars as $key => $value):?>
    <label class="checkbox">
        <input type="checkbox" value="<?=$value->id?>" name="group_name"/>
        <span class="pull-left"><?=$value->name?></span>
    </label>
<?endforeach?>