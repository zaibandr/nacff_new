@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    @include('scripts.deptAdminScript')
    <div id="lpu">
        <h1>Отделения</h1>
        <div class="col-lg-12">
            <a href="{{route("page68.create")}}" class="btn btn-primary" style="margin: 2%">Добавить отделение</a>
        </div>
        <table class="tablesorter">
            <thead>
            <tr>
                <th>ЛПУ</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Автоматическая отправка почты</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($depts as $val)
                <tr>
                    <td>{{$val['DEPTCODE']}}</td>
                    <td>{{stripslashes($val['DEPT'])}}</td>
                    <td>{{stripslashes($val['DESCRIPTION'])}}</td>
                    <td>{!! $val['EMAIL_SENDER']=='Y'?"<i class='fa fa-check'></i>":"<i class='fa fa-times'></i>" !!}</td>
                    <td><a href="{{url('page68/'.$val['ID'])}}">Прайс</a></td>
                    <td><a href="#" data-toggle="modal" data-target="#modify" data-email="{{$val['EMAIL_SENDER']}}" data-content="{{$val['ID']}}" data-name="{{$val['DEPT']}}" data-desc="{{$val['DESCRIPTION']}}" data-net="{{$val['NET_ID']}}">Редактировать</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade bs-example-modal" id="modify" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать Отделение</h4>
                </div>
                <form method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="desc">Описание</label>
                            <input type="text" name="desc" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="net">Сети</label>
                            <select name="net" class="form-control">
                                <option value=""></option>
                                @foreach($nets as $net)
                                    <option value="{{$net['ID']}}">{{$net['NETNAME']}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email_send">Сети</label>
                            <input type="checkbox" name="email_send">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary"> Сохранить </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#modify').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('content') // Extract info from data-* attributes
            var name = button.data('name') // Extract info from data-* attributes
            var desc = button.data('desc') // Extract info from data-* attributes
            var net = button.data('net') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action','page68/'+id)
            modal.find('input[name="name"]').val(name)
            modal.find('input[name="desc"]').val(desc)
            modal.find('select[name="net"]').val(net)
            if(email=='Y')
                modal.find('select[name="email_sender"]').attr('checked','checked')
        })
    </script>
    @stop