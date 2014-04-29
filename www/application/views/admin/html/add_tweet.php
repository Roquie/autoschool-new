<!-- Modal -->
<div id="twitter" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="twitter">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="global-tweet-dialog-header">Новый твит</h3>
        </div>
        <div class="modal-body">
            <form action="<?=URL::site('twitter/add_tweet')?>" method="post" id="add_tweet">

                <textarea name="message" id="message" class="message" maxlength="140"></textarea>

                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="tweet-button pull-right">
                    <span class="tweet-counter">140</span>
                    <button type="submit" class="btn btn-primary">
                        Твитнуть
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>