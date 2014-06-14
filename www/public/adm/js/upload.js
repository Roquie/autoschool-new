/**
 * Created by mac on 08.03.14.
 */
$(function() {

    $("input:checkbox").on('click', function() {
        var $this = $(this);


        if ($(this).is(':checked'))
        {
            //$(this).parent('td').parent('tr').css('background-color', '#034462');
            var group = "input:checkbox[name='" + $(this).attr('name') + "']";
            $(group).prop('checked', false);
            $(this).prop('checked', true);
        }
        else
        {
            //$(this).parent('td').parent('tr').css('background-color', '#f5f5f5');
            $(this).prop('checked', true);
        }

        $('#type_file').val($this.val());
    });


    $('table').on('click', 'tr', function()
    {
        $(this).find('input:checkbox').trigger('click');
    });

    $('input[type="file"]').on('change', function () {
        $(this).closest('form').trigger('submit');
    });

});
