<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$title?>">

    <script src="<?=URL::site('public/global/js/headjs.min.js')?>"></script>
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

<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter25347593 = new Ya.Metrika({id:25347593, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/25347593" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->

</body>
</html>