<!-- Modal -->
<div id="send_sms" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="twitter">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="global-tweet-dialog-header">
                Отправить смс-ки
            </h3>
        </div>
        <div class="modal-body">
            <form action="<?=URL::site('aramba/send_sms')?>" method="post" id="send_sms_form">

                <label for="many_tels">Кому:</label>
                <textarea id="many_tels1" name="to" class="to sms_sender" style="width: 98%; line-height: 1.4 !important; resize: vertical"></textarea>
                <label for="message">Текст сообщения:</label>
                <textarea name="message" id="message" class="message"></textarea>

                <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                <div class="pull-left" style="margin-top: 5px">
                    Баланс: <span id="sum_sendsms_balance">0.00</span>р. <a href="#" id="sendsms_balance" data-url="<?=URL::site('aramba/get_balance')?>" rel="tooltip1" title="Обновить баланс" class="label"><i class="icon-refresh"></i></a>&nbsp;<a href="https://my.aramba.ru/Payment/AddRubles" target="_blank" rel="tooltip1" title="Пополнить баланс" class="label"><i class="icon-plus-sign"></i></a>
                </div>
                <div class="tweet-button pull-right">
                    <button type="submit" class="btn btn-primary">
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>