/**
 * Created by mac on 15.06.14.
 */
$(function() {

    $('#cl_distribution').on('click', function(e) {
        e.preventDefault();
        $('.dist_groups').trigger('change');
    });

    $('body').on('change', '.dist_groups', function() {

        var $this= $(this),
            block = $this.next('.dist_list_user'),
            column = $('.dist_groups').index(this);

        ///block.html('q');

        $.ajax({
            type : 'POST',
            url  : $this.data('url'),
            dataType : 'json',
            data : {
                column : column,
                group_id : $this.val(),
                csrf : $('.csrf').val()
            },
            beforeSend : function() {},
            success : function(response)
            {
                if (response.status == 'success')
                {
                    if (response.data == '') {
                        block.html('<div class="text-center">Слушателей нет</div>');
                    } else {
                        block.html(response.data);
                        var r_col = 0;
                        $( "#sortable1, #sortable2" ).sortable({
                            connectWith: ".connectedSortable",
                            placeholder: "ui-state-highlight",
                            start : function(event, ui) {
                                if (ui.item.parent().hasClass('connectedSortable')) {
                                    r_col = 1;
                                }
                            },
                            stop: function( event, ui ) {
                                if ($(ui.item).parent('ul').hasClass('connectedSortable') && r_col == 0)
                                {
                                    alert('перенесен в группу (заглушка - пока нихуя нет :))');
                                }
                                r_col = 0;
                            }
                        }).disableSelection();
                    }
                }
            },
            error : function(request)
            {
                if (request.status == '200') {
                    console.log('Исключение: ' + request.responseText);
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }
        });
    });
});