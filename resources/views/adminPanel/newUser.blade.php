@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    <div id="lpu">
        <h1>Добавить ЛПУ</h1>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <form action="{{route('page66.store')}}" method="post" id="formUserAdd">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input type="text" id='login' name="login" class="form-control" onblur="validateLogin(this.value)" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Полное имя</label>
                            <input type="text" id='name' name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="text" name="password" id='password' class="form-control" required>
                        </div>
                        <div class="lpu-group">
                            <div class="form-group">
                                <label for="lpu">Номер ЛПУ</label>
                                <input type="number" name="lpu" class="form-control lpuItem" required>
                            </div>
                            <div class="form-group" id="deps"></div>
                        </div>
                        <hr>
                        <i id="moreLpu" class="fa fa-plus-circle" style="margin: 5% 0">Добавить еще ЛПУ</i>
                        <div class="form-group">
                            <label for="roleD">Гл.врач</label>
                            <input type="radio" name="role" id="roleM" value="7" required>
                            <label for="roleM">Медсестра</label>
                            <input type="radio" name="role" id="roleD" value="15" required>
                            <label for="roleM">Администратор</label>
                            <input type="radio" name="role" id="role" value="16" required>
                            <label for="roleM">IT</label>
                            <input type="radio" name="role" id="role" value="19" required>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:history.go(-1)" class="btn btn-default" >Отмена</a>
                            <button type="submit" class="btn btn-primary"> Сохранить </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
        <script>
            $(function(){
                var clpu = 0;
                $("input.lpuItem").change(function(){
                    var lpu=this.value;
                    v = $.get("{{asset('app/Http/Controllers/LPUDeps.php')}}", {
                                'lpu': lpu
                            },
                            function (data) {
                                $("#deps").empty();
                                $.each(data,function(i,item){
                                    $("#deps").append("<label for='"+item.DEPT+"'>"+item.DEPT+"</label>");
                                    $("#deps").append("<input type='checkbox' name='dept"+i+"' value='"+item.DEPT+"' />");
                                    //console.log(item);
                                });

                            }, 'json');
                    //console.log(lpu);
                });
                $("#moreLpu").click(function(){
                    clpu++;
                    $(".lpu-group").append("<div class=\"form-group\"><label for=\"lpu"+clpu+"\">Номер ЛПУ</label><input type=\"text\" name=\"lpu"+clpu+"\" class=\"form-control lpuItem"+clpu+"\"></div><div class=\"form-group\" id=\"deps"+clpu+"\"></div>");
                    $("input.lpuItem"+ clpu).change(function(){
                        lpu=this.value;
                        v = $.get("app/Http/Controllers/LPUDeps.php", {
                                    'lpu': lpu
                                },
                                function (data) {
                                    $("#deps"+clpu).empty();
                                    $.each(data,function(i,item){console.log($("#deps"+clpu));
                                        $("#deps"+clpu).append("<label for='"+item.DEPT+"'>"+item.DEPT+"</label>");
                                        $("#deps"+clpu).append("<input type='checkbox' name='dept"+i+clpu+"' value='"+item.DEPT+"' />");
                                    });

                                }, 'json');
                        //console.log(lpu);
                    });
                });
            });
            function validateLogin(a){
                var userCheck;
                if($('label[for="login"]').next("p").text())
                    $('label[for="login"]').next("p").remove();
                v = $.get("{{asset('app/Http/Controllers/UserValidate.php')}}", {
                            'login': a
                        },
                        function (data) {
                            //console.log(data.COUNT);
                            if(data.COUNT==1) {
                                $('label[for="login"]').after("<p style='color:red' id='error'> Пользователь с таким логином уже существует</p>");
                            }
                        }, 'json');
                    return false;
            }
        </script>
    @stop