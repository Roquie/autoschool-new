<?foreach($news as $key => $value):?>
    <div class="well thisnews">
        <h2><?=$value->title?></h2>
        <p style="word-wrap: break-word"><?=$value->message?></p>
        <div class="bottom">
            <span class="datetime pull-left"><i class="icon-calendar"></i> <?=date('d.m.Y', strtotime($value->timestamp))?> в <?=date('H:i', strtotime($value->timestamp))?></span>
            <a href="#" id="remove_news" data-url="<?=URL::site('/admin/news/remove')?>" data-csrf="<?=Security::token()?>" data-id-news="<?=$value->id?>" class="badge badge-important pull-right"><i class="icon-trash"></i> Удалить</a>
        </div>
    </div>
<?endforeach?>