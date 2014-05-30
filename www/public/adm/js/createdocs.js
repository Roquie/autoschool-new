$(function(){

    "use strict";
    var f_contract = $('#f_contract'),
        f_statement = $('#f_statement');

    $('#is_individual').on('click', function()
    {
        var values = {},
            indy = $('[name="statement[is_individual]"]');

        if($(this).is(':checked'))
        {
            indy.val(0);
            $.each(f_statement.serializeArray(), function(i, field)
            {
                values[field.name.substring(10, field.name.length-1)] = field.value;
            });

            $.each(values, function(key, value)
            {
                if (key == 'vrem_reg')
                {
                    f_contract.find('[name="contract['+key+']"]').prop('checked', true);
                }
                f_contract.find('[name="contract['+key+']"]').val(value);
            });
        }
        else
        {
            indy.val(1);
            f_contract.trigger('reset');
        }
    });

    $('#generateContract').on('click', function(e)
    {
        e.preventDefault();

        $.post(
            $(this).closest('form').attr('action'),
            f_statement.serialize() + '&' + f_contract.serialize(),
            function(response)
            {
                $("body").append("<iframe src='"+response.data.file+"' style='display: none;'></iframe>");
            },
            'json'
        );

    });

    $('#save_to_db').on('click', function(e)
    {
        var btn_loader = $('#btn_loader'),
            $this = $(this);

        e.preventDefault();
        $this.hide();
        btn_loader.show();


        $.post(
            $(this).data('url'),
            f_statement.serialize() + '&' + f_contract.serialize(),
            function(response)
            {
                btn_loader.hide();
                $this.show();
                f_statement[0].reset();
                f_contract[0].reset();
                $('.nav-tabs a:first').tab('show');
                message($('.container'), response.msg, response.status)
            },
            'json'
        );
    });
});