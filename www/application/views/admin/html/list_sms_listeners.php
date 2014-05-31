<?if(isset($list_checked_listeners)):?>
    <?foreach($list_checked_listeners as $k => $v):?>
        <li>
            <label class="checkbox">
                <input type="checkbox" value="<?=$v->id?>" data-tel="<?=$v->tel?>" name="listeners_sms_names"/>
                <span><?=Text::format_name($v->famil, $v->imya, $v->otch)?></span>
            </label>
        </li>
    <?endforeach?>
<?else:?>
    <p>Группа не выбрана</p>
<?endif?>