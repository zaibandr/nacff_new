<script type="text/javascript">
    $(function() {
        @foreach($matdept as $val)
    @if($val['PARENT']==2)
        $('table#lab').append("<tr><td>{{$val['MATERIAL']}}</td><td>{{$val['UNIT']}}</td><td>{{$val['UNITPACK']}}</td><td>{{$val['DEPT']}}</td></tr>");
        @elseif($val['PARENT']==1)
            $('table#lec').append("<tr><td>{{$val['MATERIAL']}}</td><td>{{$val['UNIT']}}</td><td>{{$val['UNITPACK']}}</td><td>{{$val['DEPT']}}</td></tr>");
        @endif
    @endforeach
    $("#materials li span, #materials li li span").click(function() {
            var i = $(this).find('i');
            if($(this).next().css('display')=='block')
                i.switchClass("glyphicon-minus","glyphicon-plus",0);
            if($(this).next().css('display')=='none')
                i.switchClass("glyphicon-plus","glyphicon-minus",0);
            $(this).next().slideToggle("normal");

        });
    });
</script>
