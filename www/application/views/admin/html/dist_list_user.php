<ul id="<?=((int)$post['column'] == 0 ? 'sortable1' : 'sortable2')?>" class="unstyled <?=((int)$post['column'] == 0 ? null : 'connectedSortable')?>">

    <? if (!empty($list_users)) : ?>
        <? foreach ($list_users as $key => $v) : ?>
            <? if ((int)$post['column'] == 0) : ?>
                <li class="ui-state-default" data-id="<?=$key?>"><?=$v?></li>
            <? else : ?>
                <li><?=$v?></li>
            <? endif; ?>
        <? endforeach; ?>
    <? endif; ?>
</ul>