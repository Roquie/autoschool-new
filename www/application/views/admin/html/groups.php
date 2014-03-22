<?foreach($list_groups as $key => $value):?>
    <label class="checkbox">
        <input type="checkbox" class="radio" value="<?=$key?>" name="group_name"/>
        <?=$value->name?>
    </label>
<?endforeach?>