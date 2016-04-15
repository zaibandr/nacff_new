@extends('default')
@section('content')
                <div class="auth">
                    <h1>АВТОРИЗАЦИЯ</h1>
                    <form class="form-horizontal" role="form" method="POST" action="auth">

                        <span id="ordinary" style="margin-bottom: 20px"> Для заказа анализов и просмотра результатов необходимо войти в систему. </span>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h5 style="color: red">@if(isset($error) && $error!='') {{$error}} @endif</h5>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Имя пользователя</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="login" value="" placeholder="Введите логин" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Пароль</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" placeholder="Введите пароль" required>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Введите код с рисунка</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="captcha" required>
                            </div>
                            <div class="col-md-3">
                                <? echo captcha_img()?>
                            </div>
                        </div-->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Запомнить
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Войти</button>

                                <!--a class="btn btn-link" href="{{ url('/password/email') }}">Забыли пароль?</a-->
                            </div>
                        </div>
                    </form>
                </div>
@stop

