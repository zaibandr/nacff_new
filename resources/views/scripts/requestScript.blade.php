<script src="{{secure_asset('public/js/bootstrap-datepicker.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.ru.min.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.cookie.js')}}"></script>
<script>
    $(function() {
        $( ".datepicker" ).datepicker({
            format: 'dd.mm.yyyy',
            language: 'ru',
            autoclose: true,
            clearBtn: true
        });
        $('#popover').popover({
            content: getPopover(),
            html: true

        });

        $(document).on('change', '.popover-content input[type=checkbox]', function() {
            var checked = $(this).is(':checked');
            var c = $(this).attr('id');
            var index   = $('th.'+c).index();
            $('.table tr').each(function(){
                if(checked){
                    $(this).find("td").eq(index).show();
                    $(this).find("th").eq(index).show();
                    $.cookie(c,1);
                }else{
                    $(this).find("td").eq(index).hide();
                    $(this).find("th").eq(index).hide();
                    $.cookie(c,0);
                }
            });
        });

    });
    function formReset(){
        var now         = new Date();
        var last        = new Date(now.getTime()-3*3600*24*1000);
        var day         = ("0" + (last.getDate())).slice(-2);
        var day2        = ("0" + (now.getDate())).slice(-2);
        var month       = ("0" + (last.getMonth() + 1)).slice(-2);
        var month2      = ("0" + (now.getMonth() + 1)).slice(-2);
        var yesterday   = day+'.'+month+'.'+last.getFullYear();
        var today       = day2+'.'+month2+'.'+now.getFullYear();

        $('#date_st').val(yesterday);
        $('#date_en').val(today);
        $('#positive').val('');
        $('#status').val('');
    }
    function printSel() {
        if ($('.prn-cbox:checkbox:checked').length<1)
        //alert('Вы не выбрали ни одного направления!');
            selectAll(300);
        else deselectAll(300);
    }

    function printAll(){
        if ($('.prn-cbox:checkbox:checked').length<1)
            alert('Вы не выбрали ни одного направления!');
        else {
            var i = "";
            $(".prn-cbox").each(function () {
                if (this.checked) i += this.id + ",";
            });
            window.open("print/" + i.substr(0, i.length - 1) + "?action=massPrint&logo=1");
        }
    }
    function selectAll(_max) {
        var i=0;
        $(".prn-cbox").each(function() {
            if(i>=_max) return;
            this.checked = true;
            i++;
        });
    }
    function deselectAll(_max) {
        var i=0;
        $(".prn-cbox").each(function() {
            if(i>=_max) return;
            this.checked = false;
            i++;
        });
    }
    function getPopover(){
        var pop = '<ul><li><input type="checkbox" ';
        if(typeof $.cookie('birth_column') == 'undefined' || $.cookie('birth_column') == 1)
            pop+="checked ";
        pop += 'id="birth_column">Дата рождения</li><li><input type="checkbox" ';
        if(typeof $.cookie('lpu_column') == 'undefined' || $.cookie('lpu_column') == 1)
            pop+="checked ";
        pop += 'id="lpu_column">Организация</li><li><input type="checkbox" ';
        if((typeof $.cookie('doctor_column') == 'undefined') || ($.cookie('doctor_column') == 1))
            pop+="checked ";
        pop += 'id="doctor_column">Врач</li><li><input type="checkbox" ';
        if(typeof $.cookie('policy_column') == 'undefined' || $.cookie('policy_column') == 1)
            pop+="checked ";
        pop += 'id="policy_column">Страховая компания</li><li><input type="checkbox" ';
        if(typeof $.cookie('comment_column') == 'undefined' || $.cookie('comment_column') == 1)
            pop+="checked ";
        pop += 'id="comment_column">Комментарии</li><li><input type="checkbox" ';
        if(typeof $.cookie('price_column') == 'undefined' || $.cookie('price_column') == 1)
            pop+="checked ";
        pop += 'id="price_column">Цена по прайсу</li><li><input type="checkbox" ';
        if(typeof $.cookie('cost_column') == 'undefined' || $.cookie('cost_column') == 1)
            pop+="checked ";
        pop += 'id="cost_column">Цена со скидкой</li><li><input type="checkbox" ';
        if(typeof $.cookie('procent_column') == 'undefined' || $.cookie('procent_column') == 1)
            pop+="checked ";
        pop += 'id="procent_column">Скидка</li></ul>';
        return pop;
    }
</script>
