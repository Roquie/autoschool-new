<?=HTML::style('css/vendor/flexslider.css')?>
<?=HTML::script('js/vendor/jquery.flexslider-min.js')?>
<?=HTML::script('js/main/index.js')?>
<section class="row main">
    <div class="container">
        <div class="row">
            <div class="span7">
                <div class="text">
                </div>
                <img src="<?=URL::site('img/main/car.jpeg')?>" alt="KIA SPECTRA"/>
                <img src="<?=URL::site('img/main/znaki.png')?>" alt="Дорожные знаки"/>
            </div>
            <div class="span5">
                <h2>Мы предлагаем пройти курс обучения вождению мотоцикла, автомобиля по программам профессиональной подготовки 11442 и 11451.</h2>
                <p>В результате обучения вы получите грамотные наставления учителей и мастеров производственного обучения. Так же вас научат теоретическим и практическим навыкам вождения в городском режиме. </p>
                <p>На основании полученных навыков вы получаете номерной сертификат об окончании автошколы.</p>
                <?
                    $email = Cookie::get('userEmail');
                    if (is_null($email)) :
                ?>
                    <a class="btn btn-success btn-docum" href="<?=URL::site('/statement')?>">Подать документы</a>
                <? else : ?>
                        <a class="btn btn-info btn-docum" href="<?=URL::site('/lk')?>">В личный кабинет</a>
                <? endif; ?>
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
                    <img src="<?=URL::site('img/main/clock.png')?>" alt="Часики" />
                    Объемы часов по рабочей программе соответствуют стандарту и составляют <b>106</b> часов теории и <b>50</b> часов практики.
                </div>
            </div>
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('img/main/list.png')?>" alt="Лист с баксом" />
                    После прохождения обучения по данной учебной программе <b>сдача экзамена</b> в ГИБДД не составит для Вас проблем.
                </div>
            </div>
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('img/main/steering_wheel.png')?>" alt="Руль"/>
                    Наш опыт работы более <b>10 лет</b> и мы выработали свою специфику работы с каждым слушателем.
                </div>
            </div>
            <div class="span3">
                <div class="grid">
                    <img src="<?=URL::site('img/main/brain.png')?>" alt="Вопрос в мозгу"/>
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
                        <li><img src="<?=URL::site('img/main/auditory/2.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/auditory/3.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/auditory/4.jpg')?>" /></li>
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
                        <li><img src="<?=URL::site('img/main/practice/5.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/6.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/7.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/8.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/9.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/10.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/11.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/19.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/20.jpg')?>" /></li>
                        <li><img src="<?=URL::site('img/main/practice/21.jpg')?>" /></li>
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
                    <li><span>заявление, <a href="<?=URL::site('media/download/documents/Zaivlenie.doc')?>">скачать</a>;</span></li>
                    <li><span>договор, <a href="<?=URL::site('media/download/documents/Dogovor.doc')?>">скачать</a>;</span></li>
                    <li><span>квитанция, <a href="<?=URL::site('media/download/documents/kvitanciya.doc')?>">скачать</a>;</span></li>
                    <li><span>фотографии 3х4 – 3 шт (любые);</span></li>
                    <li><span>копия паспорта – первой страницы и прописки;</span></li>
                    <li><span>для жителей других городов – временная регистрация минимум на пол года.</span></li>
                </ul>
                <br>

            </div>

        </div>
    </div>
</section>

<script>
    var FileAPI = {
        debug: true,
        staticPath: '<?=URL::site('js/FileAPI-dev/dist')?>'
    };
</script>
<script src="<?=URL::site('js/FileAPI-dev/dist/FileAPI.js')?>"></script>
<script src="<?=URL::site('js/FileAPI-dev/plugins/FileAPI.id3.js')?>"></script>
<script src="<?=URL::site('js/FileAPI-dev/plugins/FileAPI.exif.js')?>"></script>

<section class="row contacts" target="contacts">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1>Контакты</h1>
                <div class="">
                    <abbr title="Телефон">Тел. 1</abbr>: +7 (925) 800 10 24,
                    <abbr title="Телефон" style="margin-left: 10px">Тел. 2</abbr>: +7 (499) 317 04 09<br>
                    <p style="margin-top: 12px">Адрес: г. Москва, нахимовский проспект, 21</p>
                    <p>Напишите нам: </p>
                    <?=View::factory('main/html/contact', compact('captcha'))?>
                </div>
            </div>
            <div class="span6">
                <iframe src="https://mapsengine.google.com/map/embed?mid=zKAGAuy1eND8.kCKg1x6jjPxk" width="100%" height="330" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</section>






