<?=HTML::style('adm/css/print.css')?>
<?=HTML::style('global/css/view_doc.css')?>
<?=HTML::script('global/js/viewdoc.js')?>
<style type="text/css">
    .modal_header
    {
        font-size: 14pt;
        font-weight: 300;
    }
</style>

<div class="container">
    <h1><small>Список всех файлов</small></h1>
    <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Для слушателя <?=$checked_user?></a></li>
            <li><a href="#tab2" data-toggle="tab">Для его группы <?=$checked_user_group?></a></li>
            <li><a href="#tab3" data-toggle="tab">Пустые бланки</a></li>
        </ul>
        <div class="tab-content">
            <!-- tab 1 - docs for listener -->
            <div class="tab-pane active" id="tab1">
                <div class="backgr">
                    <div class="row">
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Заявление (о поступлении)</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/statement')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/statement.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/statement')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/statement')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/statement')?>" data-type="statement" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Договор</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/contract')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/contract.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/contract')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/contract')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/contract')?>" data-type="contract"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Квитанция</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/ticket')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/ticket.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/ticket')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/ticket')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/ticket')?>" data-type="ticket" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Личная карточка слушателя</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/personal_card')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/client_card.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/personal_card')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/personal_card')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/personal_card')?>" data-type="personal_card"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Список всех подавших заявку</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/distrib_all_info')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/distrib_all_info.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/distrib_all_info')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/distrib_all_info')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/distrib_all_info')?>" data-type="distrib_all_info"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Подавшие заявку с Примечанием</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/distrib')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/distrib.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/distrib')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/distrib')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/distrib')?>" data-type="distrib"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- tab 2 - docs for group -->
            <div class="tab-pane" id="tab2">
                <div class="backgr">
                    <div class="row">
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Практика</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/group_practice')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/group_practice.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a target="_blank" href="<?=URL::site('admin/files/print/group_practice')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/group_practice')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/group_practice')?>" data-type="group_practice"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Медкомиссия</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/listmed')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/listmed.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a target="_blank" href="<?=URL::site('admin/files/print/listmed')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/listmed')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/listmed')?>" data-type="listmed"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Книги</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/list_books')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/list_books.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a target="_blank" href="<?=URL::site('admin/files/print/list_books')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/list_books')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/list_books')?>" data-type="list_books"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Оплата, документы</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/pay_doc')?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/pay_doc.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a target="_blank" href="<?=URL::site('admin/files/print/pay_doc')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('admin/files/download/pay_doc')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/pay_doc')?>" data-type="pay_doc" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- tab 3 - empty blanks -->
            <div class="tab-pane" id="tab3">
                <div class="backgr">
                    <div class="row">
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Заявление в АШ</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/Zaivlenie.doc'))?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/statement.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/other?url='.URL::site('download/documents/Zaivlenie.doc'))?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('download/documents/Zaivlenie.doc')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/Zaivlenie.doc'))?>" data-type="empty_blank_statement" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Договор</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/Dogovor.doc'))?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/contract.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/other?url='.URL::site('download/documents/Dogovor.doc'))?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('download/documents/Dogovor.doc')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/Dogovor.doc'))?>" data-type="empty_blank_contract"  data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Квитанция</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/kvitanciya.doc'))?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/ticket.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/other?url='.URL::site('download/documents/kvitanciya.doc'))?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('download/documents/kvitanciya.doc')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/kvitanciya.doc'))?>" data-type="empty_blank_ticket" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span4">
                            <div class="doc_print">
                                <h5>Путевой лист</h5>
                                <a href="#view_doc_modal" class="view_doc_createtmpfile" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/waybill.doc'))?>" data-toggle="modal">
                                    <img src="<?=URL::site('public/adm/img/print/waybill.png')?>" width="170px" height="180px" alt=""/>
                                </a>

                                <div class="btn-group-wrap">
                                    <div class="btn-group">
                                        <a href="<?=URL::site('admin/files/print/other?url='.URL::site('download/documents/waybill.doc'))?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                                        <a href="<?=URL::site('download/documents/waybill.doc')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                                        <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/other?url='.URL::site('download/documents/waybill.doc'))?>" data-type="empty_blank_waybill" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>


        </div>
    </div>


</div>

<?=View::factory('view_doc')->render()?>