
$(function() {

    $('#select2').on('change', function() {
        $('.chat').html('');
    });

    $('#send').on('submit', function(e) {

        e.preventDefault();

        var $this = $(this);

        $this.find('.user_id').val($('#listeners').find('input:checkbox:checked').val());

        $.ajax({
            type : 'POST',
            url : $this.attr('action'),
            data : $this.serialize(),
            dataType : 'json',
            beforeSend : function() {
                un_message();
                wait($this.find('button'));
            },
            success : function(response) {
                if (response.status == 'success' || response.status == 'error') {
                    fn_success(response);
                }
                if (response.status == 'success') {
                    $('.chat').prepend(response.data);
                    if ($('#clear-block').length > 0) {
                        $('#clear-block').remove();
                    }
                }
                after_wait($this.find('button'));
                $this[0].reset();
            },
            error : function(request) {
                if (request.status == '200') {
                    console.log('Исключение: ' + request.responseText);
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }
        });
    });

});