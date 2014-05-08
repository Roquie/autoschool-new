<!-- Modal -->
<div id="desc_status" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="twitter">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="global-tweet-dialog-header">Описание отсутствующих данных</h3>
        </div>
        <div class="modal-body">
            <form action="<?=URL::site('admin/listeners/add_desc_status')?>" method="post" id="add_desc_status">

                <textarea name="description_status" id="description_status" class="message"></textarea>

                <div class="tweet-button pull-right">
                    <button type="submit" class="btn btn-primary">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>