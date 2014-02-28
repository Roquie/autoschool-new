<header class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">

            <ul class="nav">
                <a href="<?=URL::site()?>">
                    <img src="<?=URL::site('img/main/logo.png')?>" alt="Автошкола МПТ"/>
                </a>
                <div class="text">
                    <div class="phone">
                        <span>+7 (925) 800 10 24</span>
                        <span>+7 (499) 317 04 09</span><br>
                    </div>
                        <span class="email">
                            <?=HTML::mailto('&#97;&#117;&#116;&#111;&#64;&#109;&#112;&#116;&#46;&#114;&#117;?subject=Вопрос по Автошколе МПТ', '&#97;&#117;&#116;&#111;&#64;&#109;&#112;&#116;&#46;&#114;&#117;', array('target' => '_blank'))?>
                        </span>
                </div>
            </ul>
            <nav class="nav-collapse">
                <ul class="nav pull-right">
                    <li><a href="#secondary" id="slide-left" data-url="<?=URL::site('twitter/tweets')?>"><i class="icon-twitter"></i> Новости</a></li><!--http://twitter.com/autompt-->
                    <li><a href="<?=URL::site('/#price')?>" id="ajax"><i class="icon-tags"></i> Цены</a></li>
                    <li><a href="<?=URL::site('/#contacts')?>" id="ajax"><i class="icon-book"></i> Контакты</a></li>
                    <!--<li><a href="<?/*=URL::site('/about')*/?>"><i class="icon-info-sign"></i> О нас</a></li>-->
                    <?if(Auth::instance()->logged_in()):?>
                        <li><a href="<?=URL::site('/users/logout')?>"><i class="icon-signin"></i> Выйти</a></li>
                    <?else:?>
                        <li>
                            <a href="<?=Route::to('users', 'users#login')?>" id="sign_in"><i class="icon-lock"></i> Вход </a>
                        </li>
                    <?endif?>
                </ul>
            </nav>
        </div>
    </div>
</header>

<?=View::factory('main/html/twits')?>






