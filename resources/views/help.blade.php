@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    <div id="lpu">
        <h1>Справка</h1>
        <ul style="margin: 3% 0">
            <li><a href="#p1" style="color: #3c3c3c; font-size: 1.2em; font-weight: bold">1. Начало работы</a></li>
            <li><a href="#p2" style="color: #3c3c3c; font-size: 1.2em; font-weight: bold">2. Регистрация</a></li>
            <li><a href="#p3" style="color: #3c3c3c; font-size: 1.2em; font-weight: bold">3. Направления</a></li>
            <li><a href="#p4" style="color: #3c3c3c; font-size: 1.2em; font-weight: bold">4. Курьер</a></li>
            <li><a href="#p5" style="color: #3c3c3c; font-size: 1.2em; font-weight: bold">5. Требования</a></li>
        </ul>
        <div class="row">
            <div class="col-lg-12 alert alert-success" id="p1">
                <p style="font-size: 1.2em;">Начало работы</p>
            </div>
            <div class="col-lg-7">
                    При переходе на сайт, открывается станица с основными новостями НАКФФ, так
                    как изображено на рис.1. Для входа в систему необходимо пройти авторизацию(п.1).
                    Для вывода интересующих новостей есть полнотекстный поиск (п.2)
            </div>
            <div class="col-lg-5">
                <a href="{{asset('images/help/image013.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image013.jpg')}}"></image></a>
                <p style="text-align: center">рис.1</p>
            </div>

            <div class="col-lg-12 alert alert-success" id="p2">
                <p style="font-size: 1.2em;">Регистрация</p>
            </div>
            <div class="col-lg-7">
                Процесс регистрации анализов состоит из 3 страниц. На первой странице (рис.2) необходимо
                заполнить пункты помеченные *. Также можно заполнить дополнительные сведения раскрыв
                соответственные пункт. Поддерживается автоматическое заполнение, если пациент раннее сдавал
                в вашем центре анализе, то при вводе фамилии, в выпадающем списке будут отображаться пациенты
                с соответствующей фамилией. Если нажать на нужного пациента в списке, заполнятся все остальные
                пункты меню заполнятся уже известными данными.<br>
                На второй странице регистрации (рис.3) осуществляется заказ требуемых панелей. Панели можно
                выбрать тремя способами: дерево панелей на левой части странице; строка поиска по названиям или
                номерам панелей, в процессе ввода будут отображаться возможные для заказа панели; в строке
                поиска вписать номер панели и нажать "enter". Также будут отображаться цены этих панелей<br>
                На третьей странице (рис.4) выводятся данные которые Вы вносили в предыдущих страницах.
                Проверьте эти данные и нажмите "Финиш"
            </div>
            <div class="col-lg-5">
                <a href="{{asset('images/help/image009.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image009.jpg')}}"></image></a>
                <p style="text-align: center">рис.2</p>
                <a href="{{asset('images/help/image010.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image010.jpg')}}"></image></a>
                <p style="text-align: center">рис.3</p>
                <a href="{{asset('images/help/image011.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image011.jpg')}}"></image></a>
                <p style="text-align: center">рис.4</p>
            </div>
            <div class="col-lg-7">
                После регистрации Вы перейдете на страницу отображающую Вашу заявку (рис.5). На данной странице вы можете
                распечатать штрих-коды. При нажатии кнопки "Штрих-код" откроется
                <a href="{{asset('images/help/image002.jpg')}}" target="_blank">меню</a> с выводом количества
                штрих кодов, необходимых для данной заявки. При необходимости Вы можете изменить. Далее при
                нажатии кнопки "печать" произойдет автоматическая печать, при условии что принтер назван "NAKFF"
                и по умолчанию браузер просматривает файл с помощью adobe acrobat не ниже 9, иначе откроется в
                пдф просмотрщике. Также возможность распечатать акт, копировать, редактировать и удалить заявку.
            </div>
            <div class="col-lg-5">
                <a href="{{asset('images/help/image012.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image012.jpg')}}"></image></a>
                <p style="text-align: center">рис.5</p>
            </div>
            <div class="col-lg-7">
                 После взятия анализов у пациентов, необходимо пройти на страницу процедурный кабинет. Там
                отображаются все зарегистрированные центром заявки, анализы которых еще не взяты.
                На данной странице необходимо нажать по соответствующему направлению "Анализы взяты"
            </div>
            <div class="col-lg-5">
                <a href="{{asset('images/help/image003.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image003.jpg')}}"></image></a>
                <p style="text-align: center">рис.5</p>
            </div>

            <div class="col-lg-12 alert alert-success" id="p3">
                <p style="font-size: 1.2em;">Направления</p>
            </div>
            <div class="col-lg-7">
                Страница где отображаются все направления зарегистрированные за последние 3 дня по умолчанию (рис. 5).
                Можно изменить отображаемые столбцы (п.1),
                <a href="{{asset('images/help/image005.jpg')}}" target="_blank">фильтр</a>(п.2),
                печать результатов исследований(п.3),
                <a href="{{asset('images/help/image006.jpg')}}" target="_blank">выгрузка в excel</a>(п.4).
                Для поиска по столбцам, достаточно навести на строку(п.5), раскроется строка поиска по каждому столбцу.<br>
                По нажатию на номер направления раскроется страница с результатами(рис.6). Нв данной странице
                есть возможность распечатать в форматах А4,А5, сохранить, отправить по
                <a href="{{asset('images/help/image008.jpg')}}" target="_blank">почте</a>
            </div>
            <div class="col-lg-5">
                <a href="{{asset('images/help/image001.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image001.jpg')}}"></image></a>
                <p style="text-align: center">рис.5</p>
                <a href="{{asset('images/help/image007.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image007.jpg')}}"></image></a>
                <p style="text-align: center">рис.6</p>
            </div>

            <div class="col-lg-12 alert alert-success" id="p4">
                <p style="font-size: 1.2em;">Курьер</p>
            </div>
            <div class="col-lg-7">
                На странице выводится список контейнеров зарегистрированные с момента последнего забора
                курьером контейнеров(рис.7). Формируется акт приема-передачи в который занесены все контейнеры.
                ОБЯЗАТЕЛЬНО - перепроверить наличие всех материалов! Заполнить акт и нажать кнопку "Отправлено"
            </div>
            <div class="col-lg-5">
                <a href="{{asset('images/help/image004.jpg')}}" target="_blank"><image src="{{asset('images/help/thumbs/image004.jpg')}}"></image></a>
                <p style="text-align: center">рис.7</p>
            </div>
            <div class="col-lg-12 alert alert-success" id="p4">
                <p style="font-size: 1.2em;">Требования к работе</p>
            </div>
            <div class="col-lg-12">
                <b>Для корректной работы удаленной работы рекомендуется использовать в качестве браузера
                Mozilla Firefox последних версий, программное обеспечение Adobe Acrobat версии не ниже 9.
                Установленный принтер должен быть под названием "NAKFF"</b>
            </div>

        </div>
    </div>
    <script>
        jQuery( document ).ready(function() {
            jQuery('#scrollup img').mouseover( function(){
                jQuery( this ).animate({opacity: 0.65},100);
            }).mouseout( function(){
                jQuery( this ).animate({opacity: 1},100);
            }).click( function(){
                window.scroll(0 ,0);
                return false;
            });

            jQuery(window).scroll(function(){
                if ( jQuery(document).scrollTop() > 0 ) {
                    jQuery('#scrollup').fadeIn('fast');
                } else {
                    jQuery('#scrollup').fadeOut('fast');
                }
            });
        })
    </script>
    @stop