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

    <?=HTML::style('adm/css/global.css')?>
    <?=HTML::style('global/css/popup.css')?>
    <?=HTML::style('global/css/bstrap.html5b.fawesome.min.css')?>

    <?=HTML::style('http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css')?>
    <?=HTML::script('global/js/jquery.min.js')?>
    <?=HTML::script('global/js/bootstrap.min.js')?>
    <?=HTML::script('global/js/popup.js')?>
    <?=HTML::script('adm/js/global.js')?>

    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrap">
    <?=$navbar.PHP_EOL?>
    <?=$content.PHP_EOL?>
</div>


</body>
</html>