$(function() {

    var body = $('body');

    $("input:checkbox").on('click', function() {

        if ($(this).is(":checked")) {
            var group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(group).prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", true);
            return;
        }

        $('#user_id').val($(this).val())

        var f_statement = $('#statement'),
            listeners = $('#listeners');

        listeners.find('.loader').remove();
        $(this).parent().append('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

        f_statement.find('input,select').each(function() {
            if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                $(this).val('');
        });

        f_statement.find('input,select').each(function() {
            if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'hidden')
                $(this).val('');
        });

        $.post(
            listeners.data('url'),
            {
                csrf : listeners.prev('input').val(),
                user_id : $(this).val()
            },
            function(response)
            {
                if (response.status == 'success')
                {
                    $.each(response.data.listener, function(key, value) {
                        f_statement.find('[name="'+key+'"]').val(value);
                    });
                }
                if (response.status == 'error')
                {
                    //wtf
                }
                listeners.prev('input').val(response.csrf);
                listeners.find('.loader').remove();
            },
            'json'
        );

    });

    $('#listeners').find('input:checkbox').first().trigger('click');


/*
    $('#select2').on('change', function() {

        var $this = $(this),
            block = $('#listeners');

        block.html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

        $.post(
            $this.data('url'),
            {
                csrf : $this.prev('input').val(),
                group_id : $this.val()
            },
            function(response)
            {
                if (response.status == 'success')
                {
                    block.html(response.data);
                }
                if (response.status == 'error')
                {

                }
                $this.prev('input').val(response.csrf);
            },
            'json'
        );

    });

    $('#select3').on('change', function() {

        var $this = $(this),
            block = $('#listeners');

        block.html('<div class="loader"><i class="icon-refresh icon-spin icon-large"></i></div>');

        $.post(
            $this.data('url'),
            {
                csrf : $this.prev('input').val(),
                group_id : $this.val()
            },
            function(response)
            {
                if (response.status == 'success')
                {
                    block.html(response.data);
                }
                if (response.status == 'error')
                {

                }
                $this.prev('input').val(response.csrf);
            },
            'json'
        );

    });*/
});