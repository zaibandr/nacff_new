
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Удаленная регистрация образцов </title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="{{asset('resources/assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/default.css')}}" rel="stylesheet">


    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link href='{{asset('resources/assets/css/MyriadPro.css')}}' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>
<body>
<div class="container-fluid header">
    <div class="row">

        <div class="col-xs-5 col-xs-offset-1" style="padding-top: 5%; padding-bottom: 5%">
            <img src="{{url('images/logo.png')}}" alt="" width="90%">
        </div>
        <div class="col-xs-5" style="padding-top: 5%; ">
            <div style="float: right">
                <a href="{{url('auth')}}"><div id="Login"><img src="{{url('images/key.png')}}" alt=""><img src="{{url('images/line.png')}}" alt="" style="margin-right: 10px; margin-left: 10px">Личный кабинет</div></a>
                <a href="{{url('logout')}}"><div id="out">Выйти</div></a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid wrapper">
            <?php //var_dump(Session::all()); ?>
    <div class="row" style="padding-left: 3%; padding-right: 3%;">
        <div class="col-md-offset-3 col-md-8 xx">
            <p style="float: left;"><a href="http://www.nacpp.ru/">Главная</a>&nbsp;>&nbsp;<a href="https://nacpp.info/">Удаленная регистрация образцов</a></p>
            <p style="float: right;">Пользователь:  <i><b style="color: #00989e;">{{Session::get('login')}}</b></i></p>
        </div>
    </div>
    <div class="row" style="margin-top: 1%;">
        <div class="col-md-offset-1 col-md-2">
            <div class="menu">
                <ul id="menu">
                    <?
                        if(Session::has('userCheck') && Session::get('userCheck')==1){
                    $i=1;
                    foreach(Session::get('menu') as $key=>$arr){
                        echo "<li><span>$key</span><ul>";
                        $b = [];
                        foreach($arr as $k=>$v){
                            if(!in_array($k,$b))
                            {
                                echo "<li><a href='".url("page$v")."'> $k</a></li>";
                                $b[] = $k;
                            }
                        }
                        echo "</ul></li>";
                        }
                    }
                    ?><li>
                        <span>Информация</span>
                        <ul>
                            <li><a href="{{url('messages')}}">Сообщения</a></li>
                            <li><a href="{{url('integration')}}">Интеграция</a></li>
                            <li><a href="{{url('help')}}">Справка</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-8 cont">
            @include('scripts.mainPageScript')
            @yield('content')
        </div>
    </div>
</div>
<div class="container-fluid footer">
    <div class="row">
        <div class="col-lg-12">
            <p>&copy; НАКФФ, 2007-{{date('Y')}} laboratory@nacpp.ru <br>
                Россия, 115088, Москва, ул. Угрешская, д.2, стр. 8. <br>
                +7 495  259-44-44, схема проезда</p>
        </div>
    </div>
</div>
</body>


</body>
</html>