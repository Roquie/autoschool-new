<?foreach($list_users as $key => $value):?>
    <label class="checkbox">
        <input type="checkbox" class="radio" value="<?=$key?>" name="listeners_names"/>
        <span style="float: left"><?=$value?></span>
    </label>
<?endforeach?>