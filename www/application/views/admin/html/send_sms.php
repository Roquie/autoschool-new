<style type="text/css">
    .modal {
        margin-left: -350px;
        width: 700px;
     /*   min-height: 500px;*/
    }
    .modal-body {
        /*float: right;
        width: 400px;*/

        max-height: 460px;
    }

    .to {
        overflow-y: auto;
        width: 357px;
        border: 1px solid rgba(0,132,180,0.25);
        border-radius: 3px;
        outline: 0;
        padding: 10px;
        height: 80px;
        background-color: white;
        /*line-height: 1.4 !important; */
        resize: none;
    }
    .list_group_text {
        margin-bottom: 4px;
    }
    .sms_list_listeners {
        border: 1px solid rgba(0,132,180,0.25);
        height: 276px;
        overflow-y: auto;
        background-color: #ffffff;
        padding: 10px;
        border-radius: 3px;
    }
    .sms_list_listeners .loader{text-align:center}
    .check_all {
        border-bottom: 1px dashed darkgray;
        padding-bottom: 4px;
    }
    .message {
        min-height: 130px;
    }

</style>
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
            <div class="span3">
                <p class="list_group_text">Список группы <span class="group_slctd"> --- </span></p>
                <div class="sms_list_listeners">
                    <ul class="unstyled">
                        <li>
                            <label class="checkbox check_all">
                                <input type="checkbox" id="sms_clicked_all"/>
                                <span>Выбрать всех</span>
                            </label>
                        </li>
                        <div id="sms_wrap" data-url="<?=URL::site('admin/messages/reload_checked_listeners')?>">

                        </div>
                    </ul>
                </div>
            </div>
            <div class="span5 pull-right">
                <form action="<?=URL::site('aramba/send_sms')?>" method="post" id="send_sms_form">
                    <label for="many_tels">Кому:</label>

                    <div id="sendsms_tels" class="to" contenteditable="true" ></div>
                    <br/>
                    <input type="hidden" name="to" value=""/>
                    <label for="message">Текст сообщения:</label>

                    <textarea name="message" id="message" class="message" style="width: 95%; resize: none"></textarea>

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
</div>