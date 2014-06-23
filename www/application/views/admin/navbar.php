<?=HTML::script('adm/js/nav.js')?>
<style type="text/css">
    @media(min-width:768px) and (max-width:991px) {
        .navbar-fixed-top {
            position: relative;
            top: auto;
        }
        .navbar-collapse {
            max-height: none;
        }
        body {
            margin: 0;
        }

        #wrap {
            margin-top: 0 !important;
        }
    }
    @media(max-width:991px) {
        .navbar-fixed-top {
            position: relative;
            top: auto;
        }
        #wrap {
            margin-top: 0 !important;
        }
    }
    .navbar {
        min-height: 50px;
        margin-bottom: 0;
        -webkit-box-shadow: 0 0 20px rgba(0,0,0,0.5);
        -moz-box-shadow: 0 0 20px rgba(0,0,0,0.5);
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
</style>
<header class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner" style="width: 100%; min-width: 1000px; ">
        <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="<?=URL::site()?>"><i class="icon-home"></i> На сайт</a></li>
                    <li class="active"><a href="<?=URL::site('/admin')?>"><i class="icon-bar-chart"></i> Главная</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-briefcase"></i> Данные<b class="caret"></b></a>
                        <ul class="dropdown-menu" style="width: 250px">
                            <li><a href="<?=URL::site('admin/createdocs')?>"> Добавить слушателя</a></li>
                            <li><a href="<?=URL::site('admin/listeners/distrib')?>"> Подавшие заявку</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=URL::site('admin/group')?>"> Группы</a></li>
                            <li><a href="#distribution" id="cl_distribution" role="button" data-toggle="modal">Распределение по группам</a></li>
                            <li><a href="<?=URL::site('admin/cars')?>">Транспортные средства</a></li>
                            <li><a href="<?=URL::site('admin/staff')?>"> Сотрудники автошколы</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-submenu">
                            <a tabindex="-1" href="<?=URL::site('admin/other')?>">Прочее</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=URL::site('admin/other/national')?>"> Гражданство</a></li>
                                <li><a href="<?=URL::site('admin/other/edu')?>"> Образование</a></li>
                                <li><a href="<?=URL::site('admin/other/office')?>"> Должность</a></li>
                            </ul>
                        </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tasks"></i> Файлы<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=URL::site('admin/files')?>"> Список всех файлов</a></li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Подавшие заявку </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?=URL::site('admin/files/download/distrib_all_info')?>"> Скачать файл</a></li>
                                    <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=distrib_all_info')?>"> Просмотреть</a></li>
                                    <li><a target="_blank" href="<?=URL::site('admin/files/print/distrib_all_info')?>"> Распечатать</a></li>
                                </ul>
                            </li>
                            <li class="divider"></li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Слушатель <span style="margin: 0 10px 0 30px" class="badge" id="listener_slctd"><?=$checked_user?></span></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Заявление (о поступлении) </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/statement')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=statement')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/statement')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Договор </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/contract')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=contract')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/contract')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Квитанция </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/ticket')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=ticket')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/ticket')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Личная карточка </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/personal_card')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=personal_card')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/personal_card')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Группа &nbsp;&nbsp;<span style="margin: 0 10px 0 50px" class="badge group_slctd"><?=$checked_user_group?></span></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Практика </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/group_practice')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=group_practice')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/group_practice')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Медкомиссия </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/listmed')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=listmed')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/listmed')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Книги </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/list_books')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=list_books')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/list_books')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Оплата, документы </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/files/download/pay_doc')?>"> Скачать файл</a></li>
                                            <li><a class="nav_lookjs" href="#" data-url="<?=URL::site('admin/files?lookjs=pay_doc')?>"> Просмотреть</a></li>
                                            <li><a target="_blank" href="<?=URL::site('admin/files/print/pay_doc')?>"> Распечатать</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Пустые бланки</a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?=URL::site('/download/documents/Zaivlenie.doc')?>"> Заявление в АШ</a></li>
                                    <li><a href="<?=URL::site('/download/documents/Dogovor.doc')?>"> Договор</a></li>
                                    <li><a href="<?=URL::site('/download/documents/kvitanciya.doc')?>"> Квитанция</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-envelope"></i> Сообщения<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=URL::site('admin/news')?>"> Новости для группы</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=URL::site('admin/messages')?>"> Раздел помощи</a></li>
                            <li class="divider"></li>
                            <li><a href="#twitter" role="button" data-toggle="modal"> Добавить твит</a></li>
                            <li class="divider"></li>
                            <li><a href="#send_sms" id="sendsms_modal" role="button" data-toggle="modal"> Отправить SMS группе&nbsp;<span style="margin: 0 0 0 10px" class="badge group_slctd"><?=$checked_user_group?></span></a></li>
                        </ul>
                    </li>
                    <!--<li><a href="<?/*=URL::site('admin/sync')*/?>"><i class="icon-random"></i> Cинхронизация</a></li>-->
                    <li><a href="<?=URL::site('admin/help')?>"><i class="icon-question-sign"></i> Справка</a></li>
                </ul>
                <style type="text/css">
                    .selected_listener {
                        margin-right: 40px;
                        color: #ffffff;
                    }
                    .selected_listener > span {
                        font-size: 10pt;
                    }
                </style>
                <ul class="nav pull-right">
                    <li class="selected_listener"><span>Выбран слушатель:</span> <p><?=$checked_user?></p></li>
                    <li class="divider-vertical"></li>
                    <li style="position: relative">
                        <a href="#" id="user_name"><span class="login"><i class="icon-bolt"></i> <?=$info->first_name.'&nbsp;'.$info->family_name?></span><strong class="caret" style="margin-left: 5px;margin-top: 8px; border-top: 4px solid #ffffff;"></strong></a>
                        <div id="popup" style="width: 300px" class="hide">
                            <div class="pull-left">
                                <?if($admin->photo == 'public/img/photo.jpg' || $admin->photo == 'public/img/admin/admin_avatar.png'):?>
                                    <img class="img-login" style="width: 95px; height: 95px" src="<?=URL::site($admin->photo)?>"/>
                                <?else:?>
                                    <img class="img-login" style="width: 95px; height: 95px" src="<?=$admin->photo?>"/>
                                <?endif?>
                            </div>
                            <div class="pull-right" style="width: 197px; margin-top: -5px">
                                <span style="font-weight: bolder"">  <?=$info->first_name.'&nbsp;'.$info->family_name?></span><br>
                                <span class="muted"><?=$admin->email?></span><br>
                                Администратор
                                <div class="buttons">
                                    <div class="btn-group">
                                        <a class="btn" href="<?=URL::site('admin/settings/')?>">Настройки</a>
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                                            <span style="border-top-color: #474747; border-bottom-color: #474747" class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=URL::site('admin/settings')?>">Главная страница</a></li>
                                            <li><a href="<?=URL::site('admin/settings/administrators')?>">Администраторы</a></li>
                                            <li><a href="<?=URL::site('admin/settings/upload')?>">Замена шаблонов</a></li>
                                            <li><a href="<?=URL::site('admin/settings/smtp')?>">SMTP</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?=URL::site('admin/settings/sync')?>">Синхронизация</a></li>
                                            <li><a href="<?=URL::site('admin/settings/backup')?>">Резервное копирование</a></li>
                                        </ul>
                                    </div>
                                    <a class="btn" href="<?=URL::site('users/logout')?>">Выйти</a>
                                </div>
                            </div>
                        </div>
                    <li class="divider-vertical"></li>
                    </li>
                </ul>
            </div><!-- /.nav-collapse -->
    </div><!-- /navbar-inner -->
</header><!-- /navbar -->

