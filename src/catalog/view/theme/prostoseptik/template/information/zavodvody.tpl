<?php echo $header; ?>
<div class="wrapper">
    <div class="container container__screen">
        <div class="bread-band" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <?php for ($i = 0; $i < count($breadcrumbs); $i++) { ?>
                <?php if($i == 0):?>
                <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-link" itemprop="item">
                    <span itemprop="name"><?php echo $breadcrumbs[$i]['text']; ?></span>
                    <meta itemprop="position" content="<?= $i + 1; ?>">
                </a>
                <span class="bread-sep">-</span>
                <?php elseif ($i == count($breadcrumbs) - 1): ?>
                <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
                <?php else: ?>
                <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-before">
                    <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
                </a>
                <span class="bread-sep">-</span>
                <?php endif; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper__background" style="background-image: url('/catalog/view/theme/prostoseptik/assets/img/pic2.png')">
    <div class="container container__screen">
        <div class="v-headbaner">
            <div class="v-headbaner-block">
                <h1 class="page-title title__white">Обустройство скважины на воду в Москве и московской области</h1>
                <p class="v-headbaner-block-text">Водоснабжение в частном доме должно быть постоянным и бесперебойным, в противном случае хозяин может забыть даже об
                    элементарном комфорте, проживая в своем загородном особняке. Вода нужна не только для питья и соблюдения гигиенических
                    норм, но и для полноценной работы канализационных систем. Но как добиться подобного результата, если дом находится
                    вдалеке от магистрального трубопровода? Выход существует и заключается он в создании автономного источника
                    водоснабжения. Специалисты в таких случаях рекомендуют бурение и обустройство скважин под воду, которые обеспечат хозяев
                    необходимым количеством водных ресурсов для только для быта, но и для хозяйственных нужд.</p>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container container__screen">
        <div class="wrapper_grey video wrapper__text">
            <div class="content__text">
                <p class="textblock-text">Комплексные услуги по бурению и сооружению скважинных конструкций предлагает профильная компания Простосептик
                    (pro100septik.ru) с многолетним опытом работы в данной сфере. Здесь можно заказать обустройство скважины:</p>
                <ol class="textblock-list">
                    <li class="textblock-list-item">С кессоном;</li>
                    <li class="textblock-list-item">С редуктором;</li>
                    <li class="textblock-list-item">Летник.</li>
                </ol>
                <p class="textblock-text">Все перечисленные варианты имеют свои плюсы и минусы, о которых должен знать любой частник, решивший пользоваться
                    автономным источником водоснабжения. Чтобы разобраться в них, необходимо знать преимущества скважин в сравнении с
                    альтернативными конструкциями водозабора. Выбор и монтажные работы, когда требуется обустройство скважины лучше доверить
                    опытным профессионалам компании. Самодеятельность в таких вопросах вызовет дополнительные траты и создаст проблемы с
                    водоснабжением частного особняка. Специалисты Pro100septik помогут собственникам определиться с выбором необходимых
                    материалов и оборудования, чтобы выполнить обустройство скважины грамотно и без ошибок. Каждое решение инженерами
                    компании принимается индивидуально, исходя из особенностей конструкции и запросов хозяина.</p>
            </div>
        </div>
    </div>

    <div class="wrapper zavod">
        <div class="container container__screen">
            <h2 class="subtitle center zavod-title">Виды и стоимость обустройства скважины на воду</h2>
            <div class="content__text">
                <p class="textblock-text">Прежде чем начинать обустройство скважины, необходимо провести некоторые измерения, включая:</p>
                <ol class="textblock-list">
                    <li class="textblock-list-item">Статичный/динамичный уровни водоносного бассейна;</li>
                    <li class="textblock-list-item">Глубина скважинной шахты;</li>
                    <li class="textblock-list-item">Дебит;</li>
                    <li class="textblock-list-item">Давление в водонапорной системе;</li>
                    <li class="textblock-list-item">Требуемый в санузлах напор.</li>
                </ol>
                <p class="textblock-text">В зависимости от полученных показателей специалист выбирает подходящее оборудование и занимается подготовкой к монтажу.
                    Скважинная шахта - это уникальная конструкция, которая должна эксплуатироваться с соблюдением норм безопасности. Это
                    прежде всего касается предотвращения развития разрушительных процессов и просачивания в добываемую питьевую воду вредных
                    примесей. Защита обеспечивается за счет обсадного трубопровода, который устанавливается после завершения буровых работ.
                    Нижняя часть трубопровода упирается в водоносный горизонт, а верхняя должна быть представлена с оголовком. Скважинные
                    шахты с оголовком надежно защищены от осадочных или грунтовых вод, пыли, грязи и т.д. Здесь же устанавливаются кессон
                    или редуктор, в зависимости от вида обустройства, выбранного заказчиком.</p>
            </div>
        </div>
    </div>

    <div class="wrapper zavod">
        <div class="container container__screen">
            <div class="textblock-wrap wrapper_grey">
                <div class="textblock-wrap-container">
                    <div class="slider-group slider10">
                        <div class="swiper mySwiper10">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1139.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle13119.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1319.webp">
                                </div>
                            </div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper9">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1139.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle13119.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1319.webp">
                                </div>
                            </div>

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <script src="/catalog/view/theme/prostoseptik/assets/js/zavod.js"></script>
                    <div class="textblock-wrap-container-block">
                        <h3 class="title title__indent">Летнее обустройство скважины на воду</h3>
                        <div >
                            <p class="textblock-text">Чтобы выполнить летнее обустройство скважины на воду, так называемый летник, считается наиболее бюджетным вариантом и по
                                этой причине пользуется большой популярностью среди частников. Чаще всего подобную услугу заказывают на этапе
                                строительства частного особняка. В подобных ситуациях разводка по дому не требуется, поэтому достаточно установить один
                                кран со шлангом прямо на оголовке скважины, из которого будет идти чистая артезианская вода. Цена такой услуги в
                                Pro100septik очень низкая, а время - минимальное. Поэтому летнее обустройство скважины на воду пользуется большим
                                спросом среди частников. Следует отметить и простоту эксплуатации такого автономного источника водоснабжения с
                                оголовком.</p>
                            <p class="textblock-text">Компания Простосептик выполняет летнее обустройство скважины на воду поэтапно, с учетом пожеланий заказчика. Стандартная
                                процедура по созданию "летника" подразумевает:</p>
                        </div>
                        <div class="textblock-text">
                            <ol class="textblock-list">
                                <li>Спуск в скважинную шахту насосного агрегата;</li>
                                <li>Сооружение оголовка;</li>
                                <li>Подсоединение насосного электрокабеля в розетку;</li>
                                <li>Установка шарового крана;</li>
                                <li>Пуско-наладочные работы.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="textblock-text">Вода с крана пойдет сразу, как только заработает насос. Для этого нужно лишь подключить кабель к розетке. Со временем
                        летник можно заменить на зимний вариант, установив кессон или адаптер. Простосептик имеет 15-летний опыт создания и
                        пуска в эксплуатацию автономных источников водоснабжения, поэтому для специалистов этой компании неразрешимых проблем не
                        существует. Здесь можно получить гарантию на все выполненные работы и рассчитывать на индивидуальный подход. Скважина с
                        обустройством под ключ здесь вам обойдется гораздо дешевле, чем в компаниях, предлагающих аналогичные услуги. После
                        пуска системы в эксплуатацию домовладелец получит полный пакет разрешительной и технической документации. С такими
                        документами вам не придется краснеть перед представителями контролирующих служб и органов или бояться штрафов за
                        нарушение правил пользования природными ресурсами. Цена летнего варианта в Pro100septik начинается с 20 тыс. руб.</p>
                </div>
            </div>
            <div class="textblock-wrap wrapper_grey">
                <div class="textblock-wrap-container">
                    <div class="slider-group slider11">
                        <div class="swiper mySwiper11">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1139.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle13119.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1319.webp">
                                </div>
                            </div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper12">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1139.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle13119.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1319.webp">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination1"></div>
                    </div>
                    <div class="textblock-wrap-container-block">
                        <h3 class="title title__indent">Обустройство скважины с адаптером</h3>
                        <div >
                            <p class="textblock-text">Адаптером для скважины называется изделие, обеспечивающее переход жидкости из обсадного трубопровода в водопроводные
                                трубы. Монтируется такая деталь ниже точки промерзания грунтовых пластов, обеспечивая тем самым круглогодичную
                                бесперебойную эксплуатацию водозаборной коммуникации. Осуществляется обустройство скважины с адаптером по стандартной
                                схеме, подразумевающей:</p>
                        </div>
                        <div class="textblock-text">
                            <ol class="textblock-list">
                                <li>Рытье траншеи ниже точки промерзания;</li>
                                <li>Сверление отверстия в обсадном трубопроводе;</li>
                                <li>Фиксация адаптера;</li>
                                <li>Подсоединение к водопроводной трубе;</li>
                                <li>Монтаж насосной установки;</li>
                                <li>Стыковка обеих частей переходника;</li>
                                <li>Обрезка сверху трубы;</li>
                                <li>Установка крышки на скважинной шахте с оголовком;</li>
                                <li>Засыпка траншеи землей;</li>
                                <li>Пуско-наладка системы.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="textblock-text">Цена перечисленных работ начинается от 30 тыс. руб и меняется в зависимости от пожеланий хозяина. Благодаря такому
                        переходнику вы сможете легко извлекать из скважины насос для ремонт, если он сломается. Кроме этого через адаптер можно
                        выполнить зимнее сливание воды из системы. Обустройство скважины с адаптером - процесс достаточно сложный и трудоемкий,
                        поэтому самостоятельно такой манипуляцией лучше не заниматься. Рекомендуется обращение к профессионалам Простосептик,
                        которые выполнят вышеперечисленные работы быстро и качественно. В таком случае скважина будет работать бесперебойно,
                        обеспечивая ваш дом нужным количеством воды. Прежде чем начинать обустройство скважины с адаптером, необходимо
                        определиться с выбором подходящей модели. Лучшими считаются изделия следующих брендов:</p>
                </div>
                <div class="textblock-text">
                    <ol class="textblock-list">
                        <li>Baker (США);</li>
                        <li>Robota (Швеция);</li>
                        <li>Debe (Швеция).</li>
                    </ol>
                </div>
            </div>
            <div class="textblock-wrap wrapper_grey">
                <div class="textblock-wrap-container">
                    <div class="slider-group slider12">
                        <div class="swiper mySwiper13">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1139.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle13119.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1319.webp">
                                </div>
                            </div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper14">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1139.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle13119.webp">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/catalog/view/theme/prostoseptik/assets/img/Rectangle1319.webp">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination2"></div>
                    </div>
                    <div class="textblock-wrap-container-block">
                        <h3 class="title title__indent">Обустройство скважины с кессоном</h3>
                        <div >
                            <p class="textblock-text">Наиболее дорогим и оптимальным сегодня считается обустройство скважины с кессоном под ключ цена которой в Pro100septik
                                начинается от 40 тыс. руб. Кессоном называется небольшая герметичная емкость, размещаемая в устье скважинной шахты.
                                Монтаж осуществляется в заранее выбранном и подготовленном месте. Емкость отличается термоустойчивостью и
                                герметичностью, поэтому идеально подходит для защиты всех компонентов автономной водопроводной системы. В такой
                                конструкции легко можно уместить необходимое оборудование, не беспокоясь о вреде, которое могут нанести влага, морозы
                                или температурные перепады. Не попадают в кессон и верховодные воды, под воздействием которых может повредиться
                                автоматика. Обустройство скважины с кессоном под ключ цена зависит от разных факторов, поэтому ее следует обсудить в
                                самом начале, при обращении к менеджерам компании. В зимние месяцы температура внутри емкости остается плюсовой.
                                Следовательно, промерзания оборудования бояться не следует. Кессон также позволяет распределить водные ресурсы,
                                добываемые из недр земли, на несколько домов. Сейчас в продаже представлены кессоны разных форм:</p>
                        </div>
                        <div class="textblock-text">
                            <ol class="textblock-list">
                                <li>Круглые;</li>
                                <li>Прямоугольные;</li>
                                <li>Квадратные.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="textblock-text">Данный элемент позволит обеспечить круглогодичную работу автономного источника водоснабжения, без малейших сбоев. Такой
                        металлический бак надежно защищает дорогостоящее оборудование и продлевает их эксплуатационный срок. Благодаря ему
                        система будет работать в любых погодных или климатических условиях. Сотрудники Простосептик выполняют установку кессона
                        по стандартной схеме:</p>
                </div>
                <div class="textblock-text">
                    <ol class="textblock-list">
                        <li>Рытье монтажного котлована;</li>
                        <li>Подготовка места;</li>
                        <li>Установка стального бака;</li>
                        <li>Сварочные работы;</li>
                        <li>Размещение устройств;</li>
                        <li>Пусконаладочные работы.</li>
                    </ol>
                </div>
                <div>
                    <p class="textblock-text">Заказчик принимает объект в полной готовности, если обустройство скважины с кессоном под ключ цена его устраивает. На
                        финальной стадии оформляется и передается техническая документация на легальное использование инженерной коммуникации.</p>
                    <p class="title center">Что нужно учесть при расчете суммы, необходимой для обустройства скважины?</p>
                    <p class="textblock-text">Окончательная стоимость обустройства скважины на воду зависит от разных факторов. Расчет следует вести вместе с опытным
                        специалистом, так как неосведомленный человек может допустить целый ряд ошибок, которые в дальнейшем вызовут путаницу.
                        Именно профессионал подскажет, какую трубу лучше купить или какая модель насоса подойдет под вашу скважину. Чтобы
                        автоматизировать процесс добычи и распределения артезианской воды потребуется соответствующие устройства. В таком случае
                        итоговая стоимость обустройства скважины на воду будет высокой. Можно установить лишь необходимое оборудование, без
                        автоматики и сократить подобным образом расходы. Дом в таком случае будет обеспечен бесперебойным водоснабжением.</p>
                    <p class="textblock-text">Однако не стоит забывать и о дополнительных расходах, которые могут потребоваться при создании подобных систем. В пример
                        можно привести качество артезианской воды, которое может не соответствовать общепринятым стандартам. Несмотря на то, что
                        она проходит тщательную фильтрацию, пока достигнет артезианского бассейна, все же может содержать опасные для
                        человеческого здоровья вещества. Прежде всего это повышенная концентрация минералов и солей, воздействующие на наш
                        организм отрицательным образом. Поэтому прежде всего нужно провести лабораторные анализы и убедиться в безопасности
                        такой воды. Если концентрация перечисленных веществ превышает норму, придется покупать и устанавливать специальный
                        фильтр. Это дополнительные расходы, поэтому обустройство скважины под ключ обойдется вам дороже, чем в обычных
                        ситуациях.</p>
                    <p class="textblock-text">Чтобы правильно подобрать водонапорный насос, придется посчитать каждый метр от места водозабора до устья скважинной
                        шахты. Именно метраж данной инженерной коммуникации позволяет инженерам подобрать агрегат нужной мощности. В противном
                        случае насос не сможет подавать воду в распределительный трубопровод, а оттуда в санузлы. Вы останетесь без постоянного
                        водоснабжения. Неправильно подобранное оборудование может привести к авариям и сбоям, а это вызывает отказ отдельных
                        элементов системы. Потребуются немалые деньги, чтобы устранить такие неполадки или заменить сломанные устройства на
                        новые.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="container">
            <div class="form">
                <div class="form-left">
                    <h2 class="subtitle title__white">Остались вопросы или нужна помощь с выбором</h2>
                    <p class="form__text">Оставьте заявку и наши инженеры свяжутся с вами!</p>
                    <form id="help-form-bottom" class="form-left-form">
                        <input type="text" name="name" id="name" placeholder="Имя">
                        <input data-tel-input type="tel" name="phone" id="phone" placeholder="Номер телефона">
                        <div id="help-form-bottom-error" style="display: none; color: red;"></div>
                        <button onclick="helpFormSubmit('<?= $action; ?>', 'help-form-bottom', 'help-form-bottom-error', 'name', 'phone')" class="form-button" type="button">Оставить</button>
                    </form>
                </div>
                <div class="form-right">
                    <img src="/catalog/view/theme/prostoseptik/assets/img/img.webp" alt="img">
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php echo $footer; ?>