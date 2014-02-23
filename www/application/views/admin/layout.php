<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="ru" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="ru" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="ru" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="ru" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$description?>">
<<<<<<< Updated upstream
    <meta name="viewport" content="width=device-width, initial-scale=1">
=======
>>>>>>> Stashed changes
    <?=HTML::style('css/vendor/html5b/normalize.css')?>
    <?=HTML::style('css/vendor/html5b/main.css')?>
    <?=HTML::style('http://yandex.st/bootstrap/2.3.2/css/bootstrap.min.css')?>
    <?=HTML::style('http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css')?>

    <?=HTML::script('http://yandex.st/jquery/1.10.2/jquery.min.js') ?>
    <?=HTML::script('js/vendor/html5b/plugins.js') ?>
    <?=HTML::script('http://yandex.st/bootstrap/2.3.2/js/bootstrap.min.js') ?>


    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<?//=$navbar.PHP_EOL?>
<?=$content.PHP_EOL?>
<?//=$footer.PHP_EOL?>


</body>
</html>