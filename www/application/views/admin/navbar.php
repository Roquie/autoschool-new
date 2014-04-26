<div class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
        <div class="nav-collapse">
            <ul class="nav">
                <li><a href="<?=URL::site()?>"><i class="icon-home"></i> Главная</a></li>
                <li class="active"><a href="<?=URL::site('/admin')?>"><i class="icon-bar-chart"></i> Админка</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-briefcase"></i> Данные<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=URL::site('admin/groups')?>"> Группы</a></li>
                        <li><a href="<?=URL::site('admin/other')?>"> Вспомогательная информация</a></li>
                        <li class="divider"></li>
                        <li><a href="<?=URL::site('admin/staff')?>"> Сотрудники</a></li>
                        <!--<li class="dropdown-submenu">
                            <a tabindex="-1" href="<?/*=URL::site('admin/staff')*/?>">Сотрудники</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?/*=URL::site('admin/teachers')*/?>"> Общий список</a></li>
                                <li><a href="<?/*=URL::site('admin/teachers#pdd')*/?>"> Преподаватели ПДД</a></li>
                                <li><a href="<?/*=URL::site('admin/teachers#tu_and_to')*/?>"> Преподаватели ТУ и ТО</a></li>
                                <li><a href="<?/*=URL::site('admin/teachers#opmt')*/?>"> Преподаватели ОПМТ</a></li>
                                <li><a href="<?/*=URL::site('admin/teachers#driver_instructor')*/?>"> Водители - инструкторы</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tasks"></i> Файлы<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=URL::site('admin/files')?>"> Список всех файлов</a></li>
                        <li class="divider"></li>
                        <li><a href="<?=URL::site('admin/files/driver_card')?>"> Водительская карточка</a></li>
                        <li><a href="<?=URL::site('admin/files/statement_in_gibdd')?>"> Заявление в ГИБДД</a></li>
                        <li><a href="<?=URL::site('admin/files/mail_in_mreo_gibdd')?>"> Письмо в МРЭО ГИБДД</a></li>
                        <li><a href="<?=URL::site('admin/files/exam_protocol')?>"> Экзаменационный протокол</a></li>
                        <li><a href="<?=URL::site('admin/files/listeners_group')?>"> Список слушателей группы (образ. и место раб.)</a></li>
                        <li><a href="<?=URL::site('admin/files/listeners_md')?>"> Список слушателей группы (медсправка)</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">Пустые бланки</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=URL::site('/download/documents/Zaivlenie.doc')?>"> Заявление в АШ</a></li>
                                <li><a href="<?=URL::site('/download/documents/Dogovor.doc')?>"> Договор</a></li>
                                <li><a href="<?=URL::site('/download/documents/kvitanciya.doc')?>"> Квитанция</a></li>
                                <li><a href="<?=URL::site('admin/blanks/driver_card')?>"> Водительская карточка</a></li>
                                <li><a href="<?=URL::site('admin/blanks/statement_in_gibdd')?>"> Заявление в ГИБДД</a></li>
                                <li><a href="<?=URL::site('admin/blanks/contract')?>"> Договор со слушателем</a></li>
                                <li><a href="<?=URL::site('admin/blanks/driving_rec')?>"> Карточка учета вождения</a></li>
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
                    <div id="popup" class="hide">
                        <div class="pull-left">
                            <?if($admin->photo == 'public/img/photo.jpg' || $admin->photo == 'public/img/admin/admin_avatar.png'):?>
                                <img class="img-login" style="width: 95px; height: 95px" src="<?=URL::site($admin->photo)?>"/>
                            <?else:?>
                                <img class="img-login" style="width: 95px; height: 95px" src="<?=$admin->photo?>"/>
                            <?endif?>
                        </div>
                        <div class="pull-right" style="width: 180px">
                            <span style="font-weight: bolder"">  <?=$info->first_name.'&nbsp;'.$info->family_name?></span><br>
                            <span class="muted"><?=$admin->email?></span><br>
                            Администратор
                            <div class="buttons">
                                <a href="<?=URL::site('admin/settings/')?>"><button class="btn">Настройки</button></a>
                                <a href="<?=URL::site('users/logout')?>"><button class="btn">Выйти</button></a>
                            </div>
                        </div>
                    </div>
                <li class="divider-vertical"></li>
                </li>
            </ul>
        </div><!-- /.nav-collapse -->
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->

