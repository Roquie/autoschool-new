<?=HTML::style('profile/css/downloads.css')?>
<?=HTML::style('global/css/view_doc.css')?>

<div class="span3 menu" style="margin-top: 110px">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?=URL::site('profile')?>"><i class="icon-comments"></i>Новости группы</a></li>
        <li><a href="<?=URL::site('profile/statement')?>"><i class="icon-file"></i>Заявление</a></li>
        <li><a href="<?=URL::site('profile/contract')?>"><i class="icon-file"></i>Договор</a></li>
        <li class="active"><a href="<?=URL::site('profile/download')?>"><i class="icon-cloud-download"></i>Загрузки</a></li>
        <li><a href="<?=URL::site('profile/help')?>"><i style="padding-left: 5px" class="icon-info"></i>Помощь</a></li>
    </ul>
</div>
<div class="span8">
    <div class="row downloads">
        <div class="span4">
            <div class="dwn_block">
                <div class="row">

                    <div class="span1">
                        <img src="<?=URL::site('public/img/profile/w.png')?>" alt="word"/>
                    </div>
                    <div class="span3 pull-left">
                        <h2>Заявление</h2>
                        <div class="buttons_gr">
                            <a class="btn btn-info" href="<?=URL::site('profile/download_statement')?>">Скачать</a>
                            <a class="btn btn-success view_doc_createtmpfile" href="#view_doc_modal" data-url="<?=URL::site('profile/view_doc/statement')?>" data-toggle="modal">Просмотр</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dwn_block">
                <div class="row">
                    <div class="span1">
                        <img src="<?=URL::site('public/img/profile/w.png')?>" alt="word"/>
                    </div>
                    <div class="span3 pull-left">
                        <h2>Договор</h2>
                        <div class="buttons_gr">
                            <a class="btn btn-info" href="<?=URL::site('profile/download_contract')?>">Скачать</a>
                            <a class="btn btn-success view_doc_createtmpfile" href="#view_doc_modal" data-url="<?=URL::site('profile/view_doc/contract')?>" data-toggle="modal">Просмотр</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dwn_block">
                <div class="row">
                    <div class="span1">
                        <img src="<?=URL::site('public/img/profile/w.png')?>" alt="word"/>
                    </div>
                    <div class="span3 pull-left">
                        <h2>Квитанция</h2>
                        <div class="buttons_gr">
                            <a class="btn btn-info" href="<?=URL::site('profile/download_ticket')?>">Скачать</a>
                            <a class="btn btn-success view_doc_createtmpfile" href="#view_doc_modal" data-url="<?=URL::site('profile/view_doc/ticket')?>" data-toggle="modal">Просмотр</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="span4">
            <div class="dwn_block">
                <div class="row">
                    <div class="span1">
                        <img style="height: 60px; padding-left: 18px" src="<?=URL::site('public/img/profile/z.png')?>" alt="zip"/>
                    </div>
                    <div class="span3 pull-left">
                        <h2>Скачать все архивом</h2>
                        <div class="buttons_gr">
                            <a class="btn btn-info" href="<?=URL::site('profile/download_zip')?>">Скачать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<?=HTML::script('global/js/viewdoc.js')?>

<?=View::factory('view_doc')->render()?>

