<?
    if (!empty($list_users)) :
        foreach($list_users as $key => $value):
?>
        <label class="checkbox">
            <input type="checkbox" value="<?=$key?>" name="listeners_names"/>
            <span class="pull-left"><?=$value?></span>
        </label>
<?
        endforeach;
    endif;
?>