<div class="modal fade bs-example-modal" id="label" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Печать штрих-кодов</h4>
            </div>
            <form action="{{url("print/$id?action=label")}}" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"><i>Код контейнера</i></div>
                        <div class="col-md-6"><i>Количество</i></div>
                    </div><? $a=[] ?>
                    @foreach($order as $val)
                        @if($val['CONTAINERNO']!=='' && isset($val['CONTAINERNO']))
                    @if(!in_array($val['CONTAINERNO'],$a))
                        <? $a[] = $val['CONTAINERNO']; ?>
                    <div class="form-inline">
                        <div class="row" style="margin-bottom: 2%; margin-top: 2%">
                            <div class="col-md-6"><label for="{{$val['CONTAINERNO']}}">{{$val['CONTAINERNO']}}</label></div>
                            <div class="col-md-6"><input type="number" name="{{$val['CONTAINERNO']}}" value="1" class="form-control"></div>
                        </div>
                    </div>
                    @endif
                        @endif
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary"> Печать </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>