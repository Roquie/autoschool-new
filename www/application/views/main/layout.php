<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$title?>">

    <?=HTML::style('global/css/bstrap.html5b.fawesome.min.css')?>
    <?=HTML::style('main/css/validation.css')?>
    <?=HTML::style('global/css/pageslide.css')?>
    <?=HTML::style('global/css/twitter.css')?>
    <?=HTML::style('global/css/datepicker.css')?>
    <?=HTML::style('main/css/main.css')?>

    <?=HTML::script('global/js/jquery.min.js')?>
    <?=HTML::script('global/js/jquery-ui.min.js')?>
    <?=HTML::script('global/js/bootstrap.min.js')?>
    <?=HTML::script('main/js/stylizationForm.js')?>
    <?=HTML::script('global/js/placeholder.js')?>
    <?=HTML::script('global/js/notification.js')?>
    <?=HTML::script('main/js/jquery.pageslide.js')?>
    <?=HTML::script('global/js/jquery.maskedinput.min.js')?>
    <?=HTML::script('global/js/general_fns.js')?>
    <?=HTML::script('main/js/main.js')?>

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
<?=$navbar.PHP_EOL?>
<div id="wrap">
    <?=$content.PHP_EOL?>
    <div id="push"></div>
</div>
<?=$footer.PHP_EOL?>

</body>
</html>