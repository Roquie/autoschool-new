<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$title?>">

    <script src="public/global/js/headjs.min.js"></script>
    <script type="text/javascript">
        head.load("<?=implode('","', $styles)?>");
    </script>

    <?=HTML::script('global/js/jquery.min.js')?>

    <!--[if IE]>
        <script async src="public/global/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<?=$navbar.PHP_EOL?>
<div id="wrap">
    <?=$content.PHP_EOL?>
    <div id="push"></div>
</div>
<?=$footer.PHP_EOL?>



<?=HTML::script('global/js/jquery-ui.min.js')?>
<?=HTML::script('global/js/bootstrap.min.js')?>
<?=HTML::script('main/js/stylizationForm.js')?>
<?=HTML::script('global/js/placeholder.js')?>
<?//=HTML::script('global/js/notification.js')?>
<?=HTML::script('main/js/jquery.pageslide.js')?>
<?=HTML::script('global/js/jquery.maskedinput.min.js')?>
<?=HTML::script('global/js/general_fns.js')?>
<?=HTML::script('main/js/main.js')?>
<?=HTML::script('global/js/global.js')?>
</body>
</html>