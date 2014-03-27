<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$description?>">

    <?=HTML::style('adm/css/global.css')?>
    <?=HTML::style('global/css/popup.css')?>
    <?=HTML::style('global/css/bstrap.html5b.fawesome.min.css')?>
    <?=HTML::style('global/css/datepicker.css')?>

    <?=HTML::style('http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css')?>
    <?=HTML::script('global/js/jquery.min.js')?>
    <?=HTML::script('global/js/jquery-ui.min.js')?>
    <?=HTML::script('global/js/bootstrap.min.js')?>
    <?=HTML::script('global/js/popup.js')?>
    <?=HTML::script('global/js/ajaxSend.js')?>
    <?=HTML::script('global/js/jquery.maskedinput.min.js')?>
    <?=HTML::script('adm/js/global.js')?>

    <script type="text/javascript">
        $(function() {
            /*
             * Настройки для календаря
             * @type {{monthNames: Array, monthNamesShort: Array, dayNames: Array, dayNamesMin: Array}}
             */
            $.datepicker.regional['ru'] = {
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
                    'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
                    'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
                dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
            };

            $.datepicker.setDefaults($.datepicker.regional['ru']);

            $('.datepicker').datepicker({
                maxDate: "+0D",
                nextText: "&raquo;",
                prevText: "&laquo;",
                yearRange: "1950:<?=date('Y')?>",
                dateFormat: 'dd.mm.yy',
                changeMonth: true,
                changeYear: true
            }).mask('99.99.9999');

            // Отображение календаря при нажатии на иконку календаря
            $('body')
                .on('click', '#calendar', function() {
                    $(this).closest('.input-append').find('input').datepicker( "show" );
                })
                .on('click', '.btns > a', function() {
                    $('.btns').find('a').removeClass('active');
                    $(this).addClass('active');
                });

            $(".telephone").mask("8 (999) 999-99-99");
        });

    </script>


    <!--[if IE]>
    <script src="public/global/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrap">
    <?=$navbar.PHP_EOL?>
    <?=$content.PHP_EOL?>
</div>


</body>
</html>