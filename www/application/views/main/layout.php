<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$title?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=HTML::style('global/css/bstrap.html5b.fawesome.min.css')?>
    <?=HTML::style('main/css/validation.css')?>
    <?=HTML::style('global/css/pageslide.css')?>
    <?=HTML::style('global/css/twitter.css')?>
    <?=HTML::style('main/css/main.css')?>


    <?=HTML::script('global/js/jquery.min.js')?>
    <?=HTML::script('global/js/jquery-ui.min.js')?>
    <?=HTML::script('global/js/bootstrap.min.js')?>
    <?=HTML::script('main/js/stylizationForm.js')?>
    <?=HTML::script('global/js/placeholder.js')?>
    <?=HTML::script('global/js/notification.js')?>
    <?=HTML::script('main/js/jquery.pageslide.js')?>
    <?=HTML::script('global/js/general_fns.js')?>
    <?=HTML::script('main/js/main.js')?> <!--flexslider крашится-->


    <!--[if IE]>
        <script src="/global/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<?php ProfilerToolbar::render(true); ?>
<?=$navbar.PHP_EOL?>
<div id="wrap">
    <?=$content.PHP_EOL?>
    <div id="push"></div>
</div>
<?=$footer.PHP_EOL?>

</body>
</html>