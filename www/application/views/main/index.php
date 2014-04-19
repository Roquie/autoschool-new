<?=HTML::script('main/js/jquery.flexslider-min.js')?>
<?=HTML::script('main/js/index.js')?>
<section class="row main">
    <div class="container">
        <div class="row">
            <div class="span7">
                <div class="text">
                </div>
                <img src="<?=URL::site('public/img/main/car.jpeg')?>" alt="KIA SPECTRA"/>
                <img src="<?=URL::site('public/img/main/znaki.png')?>" alt="Дорожные знаки"/>
            </div>
            <div class="span5">
                <h2>Мы предлагаем пройти курс обучения вождению мотоцикла, автомобиля по программам профессиональной подготовки 11442 и 11451.</h2>
                <p>В результате обучения вы получите грамотные наставления учителей и мастеров производственного обучения. Так же вас научат теоретическим и практическим навыкам вождения в городском режиме. </p>
                <p>На основании полученных навыков вы получаете номерной сертификат об окончании автошколы.</p>
                <?if(Auth::instance()->logged_in('user')):?>
                    <a class="btn btn-info btn-docum" href="<?=URL::site('/profile')?>">В личный кабинет</a>
                <?else:?>
                    <?if(!Auth::instance()->logged_in('admin')):?>
                        <a class="btn btn-success btn-docum" href="<?=Route::to('users', 'users#register')?>">Подать документы</a>
                    <?else:?>
                        <a class="btn btn-success btn-docum span2" href="<?=Route::to('users', 'users#login')?>">В админку</a>
                    <?endif?>
                <?endif?>
            </div>
        </div>
    </div>
</section>

<section class="row infoblocks">
    <div class="container">
        <h2>Преимуществом автошколы является работа опытных сотрудников – профессионалов, а так же реализована своя площадка в 30 метрах от учебного класса – автоподготовки. Обучение в городе происходит около здания МПТ, в районе Нахимовского проспекта.</h2>
        <div class="row">
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('public/img/main/clock.png')?>" alt="Часики" />
                    Объемы часов по рабочей программе соответствуют стандарту и составляют <b>106</b> часов теории и <b>50</b> часов практики.
                </div>
            </div>
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('public/img/main/list.png')?>" alt="Лист с баксом" />
                    После прохождения обучения по данной учебной программе <b>сдача экзамена</b> в ГИБДД не составит для Вас проблем.
                </div>
            </div>
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('public/img/main/steering_wheel.png')?>" alt="Руль"/>
                    Наш опыт работы более <b>10 лет</b> и мы выработали свою специфику работы с каждым слушателем.
                </div>
            </div>
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('public/img/main/brain.png')?>" alt="Вопрос в мозгу"/>
                    Остались вопросы? У нас есть недорогие <b>дополнительные занятия</b> помимо базовых практических часов.
                </div>
            </div>

        </div>
    </div>
</section>

<section class="row theory">
    <div class="container" >
        <div class="row">
            <div class="span6">
                <h1>Теория, класс автошколы</h1>
                <div class="flexslider">
                    <ul class="slides">
                        <li><img src="<?=URL::site('public/img/main/auditory/2.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/auditory/3.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/auditory/4.jpg')?>" /></li>
                    </ul>
                </div>
                <p>Автошкола имеет собственное помещение, санузлы, Wi-Fi.</p>
            </div>

            <div class="span6">
                <h1>Подготовка в области</h1>
                <ul class="dash">
                    <li><span>правил дорожного движения Российской Федерации;</span></li>
                    <li><span>основных положений по допуску транспортных средств к эксплуатации и обязанностей должностных лиц по обеспечению безопасности дорожного движения;</span></li>
                    <li><span>законодательства Российской Федерации в части, касающейся обеспечения безопасности дорожного движения, а также уголовной, административной и иной ответственности водителей транспортных средств;</span></li>
                    <li><span>технических аспектов безопасного управления транспортным средством;</span></li>
                    <li><span>факторов, способствующих возникновению дорожно-транспортных происшествий;</span></li>
                    <li><span>элементов конструкции транспортного средства, состояние которых влияет на безопасность дорожного движения;</span></li>
                    <li><span>методов оказания первой помощи лицам, пострадавшим при дорожно-транспортном происшествии.</span></li>
                </ul>
            </div>

        </div>
    </div>
</section>

<section class="row practice">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1>Практика</h1>
                <p>Курсы автовождения проводят спокойные, опытные, понимающие, адекватные автоинструктора. Как мужчины, так и женщины с большим стажем работы. </p>
                <p>Наши авто оснащены вторыми педалями и зеркалами, что позволяет контролировать процесс вождения. Обучение проводятся индивидуально для каждого ученика, как на механической коробке переключения передач, так и на «автомате».</p>
                <p>С учетом новой дорожной обстановки и интенсивности транспортных потоков в городе, в корне, изменилось обучение безопасному управлению автомобилем.</p>
                <p> Получение водительских прав – это только первый шаг на пути к захватывающему миру управлением автомобилем.</p>
            </div>
            <div class="span6">
                <div class="flexslider">
                    <ul class="slides">
                        <li><img src="<?=URL::site('public/img/main/practice/5.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/6.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/7.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/8.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/9.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/10.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/11.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/19.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/20.jpg')?>" /></li>
                        <li><img src="<?=URL::site('public/img/main/practice/21.jpg')?>" /></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row price" target="price">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1>Цены</h1>
                <ul class="dash">
                    <li><span>Сроки обучения составляют 2-2,5 месяца;</span></li>
                    <li><span>Стоимость обучения от 25 000 <abbr title="рублей">Р.</abbr> с возможностью поблочной оплаты;</span></li>
                    <li><span>Предоставление медицинской комиссии (на данный момент стоимость составляет 1300 <abbr title="рублей">Р.</abbr>);</span></li>
                    <li><span>Комплект литературы (стоимость минимального комплекта 600 <abbr title="рублей">Р.</abbr> – максимального 900 <abbr title="рублей">Р.</abbr>);</span></li>
                    <li><span>Дополнительные занятия помимо базовых практических часов стоят 1200 <abbr title="рублей">Р.</abbr>  и составляют 2 академических часа.</span></li>
                </ul>
                </div>
            <div class="span6">
                <h1>Документы для поступления</h1>
                <ul class="dash">
                    <li><span>заявление, <a href="<?=URL::site('download/documents/Zaivlenie.doc')?>">скачать</a>;</span></li>
                    <li><span>договор, <a href="<?=URL::site('download/documents/Dogovor.doc')?>">скачать</a>;</span></li>
                    <li><span>квитанция, <a href="<?=URL::site('download/documents/kvitanciya.doc')?>">скачать</a>;</span></li>
                    <li><span>фотографии 3х4 – 3 шт (любые);</span></li>
                    <li><span>копия паспорта – первой страницы и прописки;</span></li>
                    <li><span>для жителей других городов – временная регистрация минимум на пол года.</span></li>
                </ul>
                <br>

            </div>

        </div>
    </div>
</section>

<section class="row contacts" target="contacts">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1>Контакты</h1>
                <div class="">
                    <abbr title="Телефон">Тел. 1</abbr>: <?=$settings->get('tel1')?>,
                    <abbr title="Телефон" style="margin-left: 10px">Тел. 2</abbr>: <?=$settings->get('tel2')?><br>
                    <p style="margin-top: 12px">Адрес: <?=$settings->get('address')?></p>
                    <p>Напишите нам: </p>
                    <style>
                        .b-button {
                            display: inline-block;
                            *display: inline;
                            *zoom: 1;
                            position: relative;
                            overflow: hidden;
                            cursor: pointer;
                        }
                        .b-button__input {
                            cursor: pointer;
                            opacity: 0;
                            filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
                            top: 0px;
                            right: -50px;
                            font-size: 50px;
                            position: absolute;
                        }
                    </style>
                    <form id="send" action="<?=URL::site('mail/send')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <input id="c_name" name="name" type="text" class="span2 in-name" data-placement="top" data-req="true" placeholder="Имя">
                        <input id="c_email" name="email" type="text" class="input-large" data-placement="top" data-req="true" placeholder="Email адрес">
                    <span style="position: relative">
                        <textarea id="c_msg" name="message" class="span5" rows="5" data-req="true" placeholder="Сообщение"></textarea>
                    </span>
                        <div class="row">
                            <div class="span2">
                                <img src="<?=URL::site('captcha.png')?>" alt=""/><br><input type="text" name="captcha" style="margin-top: 5px;width: 117px" placeholder="проверка" data-req="true"/>
                            </div>
                            <div class="span2 file_upload" style="display: none; margin-bottom: 4px;">
                                <div class="input-append">
                                    <div style="width: 170px" class="uneditable-input">
                                        <i class="icon-file"></i>
                                        <span class="text"></span>
                                    </div>
                                    <a href="#" class="btn clearFile"><i class="icon-trash"></i></a>
                                </div>
                            </div>
                            <div class="b-button" style="margin-bottom: 10px; margin-left: 101px">
                                <a class="b-button__text btn" href="#" data-url="<?=URL::site('main/mail/upload')?>">Загрузить файл</a>
                                <input name="files" class="b-button__input" type="file"/>
                                <input type="hidden" name="file_name" id="file_name"/>
                            </div>
                            <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                            <input type="submit" style="margin-bottom: 4px; margin-left: 101px; width: 140px" class="btn btn-primary span2 btn_send" value="Отправить"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span6" id="google_map">
                <img style="cursor: pointer" rel="tooltip" title="Кликните для подгрузки &laquo;живой&raquo; карты ;)" src="<?=URL::site('public/img/main/map.png')?>" alt="google maps"/>
            </div>
        </div>
    </div>
</section>






