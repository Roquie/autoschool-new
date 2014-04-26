<?=HTML::style('adm/css/print.css')?>
<?=HTML::style('global/css/view_doc.css')?>
<style type="text/css">
    .modal_header
    {
        font-size: 14pt;
        font-weight: 300;
    }
</style>
<script>
    $(function() {
        /**
         * post запрос на создание временного документа
         * -
         * формирование ссылки для просмотра документа в браузере
         */
        $('.view_doc_createtmpfile').on('click', function() {
            $.post(
                $(this).data('url'),
                function(response)
                {
                    $('#docs_viewer').attr('src', "http://view.officeapps.live.com/op/view.aspx?src="+response.data.url+"/"+response.data.file);
                },
                'json'
            );
        });

        /**
         * Перенос модального окна за пределы видимости div#wrap
         */
        $('#view_doc_modal').appendTo($('body'));
    });
</script>

<div class="container">
    <h1><small>Список всех файлов</small></h1>
    <div class="backgr">
        <div class="row">
            <div class="span4">
                <div class="doc_print">
                    <h5>Заявление (о поступлении)</h5>
                    <a href="<?=URL::site('admin/files/download/statement')?>"><img src="<?=URL::site('public/adm/img/print/driving_card.png')?>" width="170px" height="180px" alt="Водительская карточка"/></a>
                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('admin/files/print/statement')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('admin/files/download/statement')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/statement')?>" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="doc_print">
                    <h5>Договор</h5>
                    <a href="<?=URL::site('admin/files/download/contract')?>"><img src="<?=URL::site('public/adm/img/print/statement_mreo.png')?>" width="170px" height="180px" alt="Заявление в ГИБДД"/></a>
                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('admin/files/print/contract')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('admin/files/download/contract')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/contract')?>" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="doc_print">
                    <h5>Квитанция</h5>
                    <a href="<?=URL::site('admin/files/download/ticket')?>"><img src="<?=URL::site('public/adm/img/print/statement_mreo.png')?>" width="170px" height="180px" alt="Письмо в МРЭО ГИБДД"/></a>
                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('admin/files/print/ticket')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('admin/files/download/ticket')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/ticket')?>" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4">
                <div class="doc_print">
                    <h5>Личная карточка слушателя</h5>
                    <a href="<?=URL::site('admin/files/download/personal_card')?>"><img src="<?=URL::site('public/img/admin/print/client_card.png')?>" width="170px" height="180px" alt="Личная карточка слушателя"/></a>

                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('admin/files/print/personal_card')?>" target="_blank" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('admin/files/download/personal_card')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#view_doc_modal" data-url="<?=URL::site('admin/files/look/personal_card')?>" data-toggle="modal" rel="tooltip" title="Открыть" class="btn btn-info view_doc_createtmpfile"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="doc_print">
                    <h5>Заявление в ГИБДД</h5>
                    <a href="#"><img src="<?=URL::site('public/adm/img/print/statement_mreo.png')?>" width="170px" height="180px" alt="Заявление в ГИБДД"/></a>

                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('/print/pdf')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('/download/print/name')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#" rel="tooltip" title="Открыть" class="btn btn-info"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="doc_print">
                    <h5>Письмо в МРЭО ГИБДД</h5>
                    <a href="#"><img src="<?=URL::site('public/adm/img/print/statement_mreo.png')?>" width="170px" height="180px" alt="Письмо в МРЭО ГИБДД"/></a>

                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('/print/pdf')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('/download/print/name')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#" rel="tooltip" title="Открыть" class="btn btn-info"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4">
                <div class="doc_print">
                    <h5>Экзаменационный протокол</h5>
                    <a href="#"><img src="<?=URL::site('public/adm/img/print/ekzamen.png')?>" width="170px" height="180px" alt="Экзаменационный протокол"/></a>

                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('/print/pdf')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('/download/print/name')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#" rel="tooltip" title="Открыть" class="btn btn-info"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="doc_print">
                    <h5>Список слушателей группы (образ.)</h5>
                    <a href="#"><img src="<?=URL::site('public/adm/img/print/list_group_edu.png')?>" width="170px" height="180px" alt="Список слушателей группы (образ.)"/></a>

                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('/print/pdf')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('/download/print/name')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#" rel="tooltip" title="Открыть" class="btn btn-info"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="doc_print">
                    <h5>Список слушателей группы (мед.)</h5>
                    <a href="#"><img src="<?=URL::site('public/adm/img/print/list_group_md.png')?>" width="170px" height="180px" alt="Список слушателей группы (мед.)"/></a>

                    <div class="btn-group-wrap">
                        <div class="btn-group">
                            <a href="<?=URL::site('/print/pdf')?>" rel="tooltip" title="Распечатать" class="btn"><i class="icon-print"></i></a>
                            <a href="<?=URL::site('/download/print/name')?>" rel="tooltip" title="Загрузить" class="btn btn-success"><i class="icon-download"></i></a>
                            <a href="#" rel="tooltip" title="Открыть" class="btn btn-info"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?=View::factory('view_doc')->render()?>