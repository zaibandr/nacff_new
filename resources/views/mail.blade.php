@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/mail.css')}}" rel="stylesheet">
    <div id="mail">
        <h1>ОТПРАВКА РЕЗУЛЬТАТОВ НА ПОЧТУ</h1>
    <form action="" method="post">
        {{csrf_field()}}
        <input type="hidden" name="mode" value="sent">
        <input type="hidden" name="folderno" value="<?php echo $folderno; ?>">
        <table id="frm_mail">
            <tr><td style="width:150px;">Отправитель:</td><td>
                    @if(is_array($c))
                        <select name="from" class="form-control">
                            @foreach($c as $val)
                            <option value="{{$val['DEPT']}}">{{$val['DEPT']}}</option>
                                @endforeach
                        </select>
                    @else
                    <input style="width:250px;background-color:rgb(240,240,240);border:1px inset" type="text" name="from" value="<?php echo htmlspecialchars($c[0]['DEPT']); ?>" readonly>
                        @endif
                </td></tr>
            <tr><td colspan="2"><p style="font-size:11px;color:gray;">* Для изменения поля "Отправитель", пожалуйста, обратитесь в клиентский отдел ООО "НАКФФ".</p></td></tr>
            <tr><td style="width:150px;">Получатель:</td><td><input style="width:250px" type="text" name="to" value="" required></td></tr>
            <tr><td style="width:150px;">Тема письма:</td><td><input style="width:250px" type="text" name="theme" value="Результаты исследований" required></td></tr>
            <tr><td style="width:150px;">Текст письма:</td><td><textarea name="body" cols="60" rows="10" required>В приложении - результаты исследований по заявке №<?php echo $folderno.chr(13).chr(13)?>Пациент: <?php echo $row[0]['SURNAME']." ".$row[0]['NAME']." ".$row[0]['PATRONYMIC']; ?>, год рождения <?php echo date("Y", strtotime($row[0]['DATE_BIRTH'])); ?></textarea></td></tr>
            <tr><td colspan="2"><input type="submit" value="Отправить" class="btn btn-default"></td></tr>
        </table>
    </form>
    </div>
@stop