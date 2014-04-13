<?foreach($list_staff as $id => $name):?>
    <label class="checkbox">
        <input class="names" type="checkbox" value="<?=$id?>" name="staff_id"/>
        <span class="pull-left"><?=$name?></span>
    </label>
<?endforeach?>
