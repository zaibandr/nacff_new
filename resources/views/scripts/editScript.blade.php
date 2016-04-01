<script src="{{asset('resources/assets/scripts/jquery.steps.js')}}"></script>
<script src="{{asset('resources/assets/scripts/jquery.validate.min.js')}}"></script>
<script src="{{asset('resources/assets/scripts/jQuery.DynaTree/jquery.dynatree.js')}}"></script>
<script src="{{asset('public/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('public/js/bootstrap-datepicker.ru.min.js')}}"></script>
<script>
    var max=0;
    $(function ()
    {
        var form = $("#RegAll");
        var dept;
        var rules = [];
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                confirm: {
                    equalTo: "#password"
                }
            }
        });
        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            labels: {
                cancel: "Отмена",
                current: "Текущий шаг:",
                pagination: "Pagination",
                finish: "Финиш",
                next: "Следующий",
                previous: "Предыдущий",
                loading: "Загрузка ..."
            },
            onInit: function (event, currentIndex){
        $.get("{{asset("app/Http/Controllers/docAndRule.php")}}", {
                    'dept': {{$folders[0]['CLIENTID']}},
                    'rule': 1,
                    'd':{{Session::get('dept')}}
                            },
                function (data) {
                    //console.log(data);
                    $('#discount').empty();
                    $('#discount').append('<option value=""></option>');
                    for (var i = 0; i < data.length; i++){
                        if(data[i].PER=={{$folders[0]['DISCOUNT']}})
                            $('#discount').append('<option value="' + data[i].PER + '" selected>' + data[i].RULENAME + '</option>');
                        else
                        $('#discount').append('<option value="' + data[i].PER + '">' + data[i].RULENAME + '</option>');
                        privilege = '';
                        var day = new Date();
                        if (eval(data[i].SQL)) {
                            rules.push(data[i].PER);
                        }
                    }
                }, "json");
        $.get("{{asset("app/Http/Controllers/docAndRule.php")}}", {
                    'dept': {{$folders[0]['CLIENTID']}},
                    'doc': 1,
                    'd':{{Session::get('dept')}}
                            },
                function (data) {
                    //console.log(data);
                    $(".doctor").autocomplete({
                        minLength: 0,
                        source: data,
                        select: function (event, ui) {
                            $(".doctor").val(ui.item.label);
                            $("#Rdoc").val(ui.item.id);

                            return false;
                        }
                    }).data("ui-autocomplete")._renderItem = function (ul, item) {
                        return $( "<li>" )
                                .append( "<a>" + item.label + "</a>" )
                                .appendTo( ul );
                    }}, "json");
    },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                form.validate().settings.ignore = ":disabled,:hidden";
                if(document.getElementById("steps-uid-0-p-1").className=='body current'){
                    $("#Rname").val($("#name").val());
                    $("#Rsurname").val($("#surname").val());
                    $("#Rb_d").val($("#b_d").val());
                    $("#Rsex").val($("#sex").val());
                    $('input#discount').val($('#cost').val());
                    var pan = $("#tree-dest").text();
                    if(pan!='') {
                        $("#orderP table tr").remove();
                        b = pan.split('  ');
                        tabl = "<tr><th>Код панели</th><th>Наименование</th><th>Цена</th></tr>";
                        $("#orderP table").append(tabl);
                        for (var i = 1; i < (b.length - 2); i += 3) {
                            tabl = "<tr><td>" + b[i] + "</td><td>" + b[i + 1] + "</td><td>" + b[i + 2] + "</td></tr>";
                            $("#orderP table").append(tabl);
                        }
                        tabl = "<tr><td></td><td style='text-align: right; color: darkred;'><b>Стоимость с учетом скидки</b></td><td><b>" + $('#cost').val() + "</b></td></tr>";
                        $("#orderP table").append(tabl);
                    }
                    Rshow('phone');
                    Rshow('namepatr');
                    Rshow('email');
                    Rshow('n_p');
                    Rshow('s_p');
                    Rshow('address');
                    Rshow('weight');
                    Rshow('height');
                    Rshow('s_b');
                    Rshow('diarez');
                    Rshow('n_k');
                    Rshow('AIS');
                    Rshow('diagnoz');
                    Rshow('org');
                    Rshow('str');
                    Rshow('polis');
                    Rshow('cito');
                    Rshow('prob');
                    Rshow('antib_e');
                    Rshow('antib_s');
                    Rshow('comments');
                    Rshow('issued');
                    Rshow('docc');
                    if($(".doctor").val()!='') {
                        $("#Rdoctor").val($(".doctor").val());
                        $("label[for='Rdoctor']").show();
                        $("#Rdoctor").show();
                    } else {
                        $("label[for='Rdoctor']").hide();
                        $("#Rdoctor").hide();
                    }
                    if($("#f_c option:selected").val()!='') {
                        $("#Rf_c").val($("#f_c option:selected").text());
                        $("label[for='Rf_c']").show();
                        $("#Rf_c").show();
                    } else {
                        $("label[for='Rf_c']").hide();
                        $("#Rf_c").hide();
                    }
                    if($("#backref option:selected").val()!='') {
                        $("#Rbackref").val($("#backref option:selected").text());
                        $("label[for='Rbackref']").show();
                        $("#Rbackref").show()
                    } else {
                        $("label[for='Rbackref']").hide();
                        $("#Rbackref").hide();
                    }
                    if($("#cash option:selected").val()!='') {
                        $("#Rcash").val($("#cash option:selected").text());
                        $("label[for='Rcash']").show();
                        $("#Rcash").show();
                    } else {
                        $("label[for='Rcash']").hide();
                        $("#Rcash").hide();
                    }
                    if($("#prime option:selected").val()!='') {
                        $("#Rprime").val($("#prime option:selected").text());
                        $("label[for='Rprime']").hide();
                        $("#Rprime").hide();
                    } else {
                        $("label[for='Rprime']").hide();
                        $("#Rprime").hide();
                    }
                    if($("select#discount option:selected").val()!='' && $("select#discount option:selected")) {
                        $("#Rdiscount").val($("select#discount option:selected").text());
                        $("label[for='Rdiscount']").hide();
                        $("#Rdiscount").hide();
                    } else {
                        $("label[for='Rdiscount']").hide();
                        $("#Rdiscount").hide();
                    }
                    dis = Math.round($('#cost').val()*max/(100-max));
                    $('input#discount').val(dis);
                }
                if(document.getElementById("steps-uid-0-p-0").className=='body current') {
                    oldmax = max;
                    max=0;
                    var privilege = $('select#discount option:selected').val();
                    rules.push(parseInt(privilege));
                    //console.log(rules);
                    if(!isNaN(rules)) {
                        max = Math.max.apply(null, rules);
                    }
                    rules.pop();
                    //console.log(max);
                    if(max!=0) {
                        $('div#discount').text('Скидка на услуги: ' + max + '%');
                    }
                    oldcost = 100*$('#cost').val()/(100-oldmax);
                    $('#cost').val(oldcost*(100-max)/100);
                    dept = $('#price').val();
                    $("#tree-source").dynatree({
                        initAjax: {
                            url: "../app/Http/Controllers/tree.php?dept=" + dept + "&clientcode=<?php echo Session::get('clientcode');?>&t=1"
                        },
                        ajaxDefaults: {
                            timeout: 0
                        },
                        onClick: function (node) {
                            if (!node.data.isFolder) getLegend(node.data.icon); else $("#legend2").hide('fade');
                        },
                        onDblClick: function (node) {
                            if (!node.data.isFolder) {
                                var a = parseInt(node.data.cost);
                                //console.log(node.data);
                                var b = parseInt($("#cost").val());
                                var a1 = parseInt(node.data.ncost);
                                var b1 = parseInt($("#nacppCost").val());
                                if (node.data.id !== -1 && !node.data.multi) {
                                    if (!findDuplicate(node.data.id)) {
                                        $("#tree-dest").dynatree("getRoot").addChild(node.data);
                                        global_formNavigate = false;
                                        //$("select#m"+node.data.id+" [value='"+node.data.biodef+"']").attr('selected','selected');
                                        checkCito();
                                        a = a*(100-max)/100;
                                        $("#cost").val(a+b);
                                        $("#nacppCost").val(a1+b1);
                                    }
                                } else if (node.data.multi) {
                                    $.each(node.data.panels, function (index, value) {
                                        if (!findDuplicate(value.id)) {
                                            $("#tree-dest").dynatree("getRoot").addChild(value);
                                            global_formNavigate = false;
                                            checkCito();
                                            a = a*(100-max)/100;
                                            $("#cost").val(a+b);
                                            $("#nacppCost").val(a1+b1);
                                        }
                                    });
                                }
                            }
                        },
                        onExpand: function (flag, dtnode) {
                            if (!flag) {
                                if (!dtnode.data.children || (dtnode.data.children[0].id < 0 && dtnode.data.children.length == 1)) {
                                    dtnode.resetLazy();
                                }
                            }
                        },
                        onLazyRead: function (node) {
                            node.appendAjax({
                                url: "../app/Http/Controllers/tree.php?dept=" + dept + "&clientcode=<?php echo Session::get('clientcode')."&";?>t=1",
                                data: {"p": node.data.id, "g": node.data.parent}
                            });
                        }
                    });
                    $("#searchp").autocomplete({
                        source: "../app/Http/Controllers/tree.php?dept=" + dept + "&clientcode=<?php echo Session::get('clientcode')."&";?>s=1",
                        minLength: 2,
                        search: function (event, ui) {
                            this.value = this.value.replace(",", ".");
                            return true;

                        },
                        select: function (event, ui) {
                            if(ui.item.bio)
                                var title = "<font style='background:" + ui.item.color + "'></font> " + ui.item.title + "  (" + ui.item.cost + "руб.)" + "(" + ui.item.bio + ")";
                            else
                                var title = "<font style='background:" + ui.item.color + "'></font> " + ui.item.title + "  (" + ui.item.cost + "руб.)";
                            if (!findDuplicate(ui.item.id)) {
                                global_formNavigate = false;
                                $("#tree-dest").dynatree("getRoot").addChild({
                                    "icon": ui.item.icon,
                                    "title": title,
                                    "id": ui.item.id,
                                    "color": ui.item.color,
                                    "code": ui.item.value,
                                    "cost": ui.item.cost
                                });
                                var a = parseInt(ui.item.cost);
                                var b = parseInt($("#cost").val());
                                var a1 = parseInt(ui.item.ncost);
                                var b1 = parseInt($("#nacppCost").val());
                                $("#nacppCost").val(a1+b1);
                                a = a*(100-max)/100;
                                $("#cost").val(a+b);
                                $("#searchp").autocomplete("close");
                                //if (ui.item.bioset == "") $("#tree-dest select#m"+ui.item.id+" [value='" + ui.item.biodef + "']").attr('selected','selected');
                                //	else $("#tree-dest select#m"+ui.item.id+" [value='" + ui.item.bioset + "']").attr('selected','selected');
                            }
                            $("input#searchp").autocomplete("close");
                            $("input#searchp").val('');
                            return false;
                        },
                        close: function (event, ui) {
                        }
                    });
                    @foreach($panels as $val)
                    obj = <? echo htmlspecialchars_decode($val,ENT_QUOTES) ?>;
                    //console.log(obj);
                    if (!findDuplicate(obj.id)) {
                        title = obj.label;
                        $("#tree-dest").dynatree('getRoot').addChild(obj);
                        a = parseInt(obj.cost);
                        b = parseInt($("#cost").val());
                        a1 = parseInt(obj.ncost);
                        b1 = parseInt($("#nacppCost").val());
                        $("#nacppCost").val(a1 + b1);
                        a = a * (100 - max) / 100;
                        $("#cost").val(a + b);
                        $("#oldcost").val(a + b);
                    }
                    @endforeach
                            }


                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                if(validateFrm())
                    return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                submitRegForm('{{url("edit")}}');
                //alert("Submitted!");
            }
        });

        $( ".datepicker" ).datepicker({
            format: 'dd.mm.yyyy',
            language: 'ru',
            autoclose: true,
            clearBtn: true
        });
        $("#tree-dest").dynatree({
            onClick: function (node) {
                if (!node.data.isFolder) getLegend(node.data.icon); else $("#legend2").hide('fade');
            },
            onDblClick: function (node, event) {
                if (this.count() < 2) alert("Вы не можете удалить последнюю панель из заявки. Хотя бы одна панель должна присутствовать в заявке."); else if (confirm("Вы уверены, что хотите удалить выбранную панель?")) {
                    node.remove();
                    var a = parseInt(node.data.cost);
                    var b = parseInt($("#cost").val());
                    var a1 = parseInt(node.data.ncost);
                    var b1 = parseInt($("#nacppCost").val());
                    a = a*(100-max)/100;
                    $("#cost").val(b-a);
                    $("#nacppCost").val(b1-a1);
                    $("#p-cnt").html(this.count());
                    checkCito();
                }
            },
            onRender: function (node, nodeSpan) {
                $("#p-cnt").html(this.count());
                if ($('#additional' + node.data.id)) {
                    $("#tree-dest #additional" + node.data.id).css("display", "block");
                    $("#tree-dest #m" + node.data.id).removeAttr("disabled", "disabled");
                }
                $("#tree-dest #additional" + node.data.id).bind("dblclick", function (e) {
                    if (e.stopPropagation) e.stopPropagation(); else e.cancelBubble = true;
                });
                if (node.data.bioset == "") {
                    if (node.data.biodef !== "")
                        $("#tree-dest select#m" + node.data.id + " [value='" + node.data.biodef + "']").attr('selected', 'selected');
                    else $("#tree-dest select#m" + node.data.id + " [value='70']").attr('selected', 'selected');
                } else $("#tree-dest select#m" + node.data.id + " [value='" + node.data.bioset + "']").attr('selected', 'selected');
            }
        });
    });
    function toggleBio(a) {
        if (a.checked) {
            $('#antib_s').removeAttr('disabled');
            $('#antib_e').removeAttr('disabled');
            $('#prob').removeAttr('disabled');
        } else {
            $('#antib_s').attr('disabled','');
            $('#antib_e').attr('disabled','');
            $('#prob').attr('disabled','');
        }
    }
    function checkCito() {
        var x=0;
        $("#tree-dest").dynatree("getRoot").visit(function(node){
            if (node.data.icon.search("l-10.png")!==-1) { $("#cito").removeAttr('disabled','disabled'); x = 1; }
            return true;
        });
        if (x==0) {
            $("select#cito :first").attr('selected','selected');
            $("select#cito").attr('disabled','disabled');
            return false;
        }
    }
    function getLegend(i) {
        var x = new Array ("<img width='16px' src='images/l-1.png' /> - Стерильный контейнер объемом 30-60 мл.<br/>",
                "<img width='16px' src='images/l-2.png' /> - Транспортная система - тампон в транспортной среде Эймса с углем<br/>",
                "<img width='16px' src='images/l-3.png' /> - Чашка с питательной средой<br/>",
                "<img width='16px' src='images/l-4.png' /> - Стерильный контейнер с ложечкой для кала. Забирается одна ложечка<br/>",
                "<img width='16px' src='images/l-5.png' /> - Предметное стекло, перед передачей курьеру поместить в чашку Петри<br/>",
                "<img width='16px' src='images/l-6.png' /> - Для посева крови у взрослых: флакон для выделения анаэробов с красной крышкой, флакон для выделения аэробов с зеленой крышкой или универсальный флакон с желтой крышкой. Для посева крови у детей: флакон с желтой крышкой<br/>",
                "<img width='16px' src='images/l-7.png' /> - Для посева крови у взрослых: флакон для выделения анаэробов с красной крышкой, флакон для выделения аэробов с зеленой крышкой или универсальный флакон с желтой крышкой. Для посева крови у детей: флакон с желтой крышкой<br/>",
                "<img width='16px' src='images/l-8.png' /> - Для посева крови у взрослых: флакон для выделения анаэробов с красной крышкой, флакон для выделения аэробов с зеленой крышкой или универсальный флакон с желтой крышкой. Для посева крови у детей: флакон с желтой крышкой<br/>",
                "<img width='16px' src='images/l-9.png' /> - Флакон (пробирка) с транспортной средой на уреаплазмы-микоплазмы<br/>",
                "<img width='16px' src='images/l-10.png' /> - <b>В режиме CITO!</b> исследования выполняются в течение 5 часов с момента поступления в лабораторию<br/>",
                "<img width='16px' src='images/l-11.png' /> - После взятия крови, пробирку поместить в емкость со льдом. Не помещать в морозильную камеру!<br/>",
                "<img width='16px' src='images/l-12.png' /> - По предварительному звонку в лабораторию!<br/>",
                "<img height='16px' src='images/l-13.png' /> - Для посева крови у взрослых: флакон для выделения анаэробов с красной крышкой, флакон для выделения аэробов с зеленой крышкой или универсальный флакон с желтой крышкой. Для посева крови у детей: флакон с желтой крышкой<br/>"
        );
        if ((i!=='false') && (i!=='null') && (i!=='')) {
            i = i.split(';'); var idx = 0; $("#legend2").html("");
            for(var a in i) {
                idx = i[a].substring( i[a].indexOf('-')+1, i[a].indexOf('.') );
                $("#legend2").html( $("#legend2").html() + x[idx-1] );
            }
            $("#legend2").show('fade');
        } else $("#legend2").hide('fade');
    }
    function findDuplicate(id) {
        var d = false;
        $("#tree-dest").dynatree("getRoot").visit(function(node){
            if (id == node.data.id) { d = true; return; }
        });
        return d;
    }
    function setBio(val,id) {
        $("#tree-dest").dynatree("getTree").getNodeByID(id).data.bioset = val;
    }
    function getTimeStamp() {
        var c = new Date(); return c.getTime();
    }
    function addPanel(event,o) {
        var p=""; var dept=$("#price").val();
        event = event || window.event //For IE
        if (event == undefined) { event = window.event; }
        if (event.keyCode == 13) {
            $.get("{{asset('app/Http/Controllers/tree.php')}}", {"term":o.value.replace(",","."),"dept":dept,"clientcode":<?php echo Session::get('clientcode');?>, "a":1 }, function(data) {
                if (data!="") {
                    var obj = jQuery.parseJSON(data);
                    var title = obj.label;
                    if (!findDuplicate(obj.id)) {
                        $("#tree-dest").dynatree("getRoot").addChild({"icon":obj.icon, "bioset":obj.bioset, "biodef":obj.biodef, "title": title, "id":obj.id, "color":obj.color, "code":obj.value});
                        checkCito();
                        $("#searchp").val('');
                        var a = parseInt(obj.cost);
                        var b = parseInt($("#cost").val());
                        var a1 = parseInt(obj.ncost);
                        var b1 = parseInt($("#nacppCost").val());
                        $("#nacppCost").val(a1+b1);
                        a = a*(100-max)/100;
                        $("#cost").val(a+b);
                    }
                } else return false;
            });
            $("input#searchp").autocomplete('close');
            $("input#searchp").val('');
            return false;
        }
    }
    function validateFrm() {
        var b = true;
        var o = true;
        $("#tree-dest").dynatree("getRoot").visit(function (node) {
            if (!node.data.isFolder)
                if (($("#tree-dest #m" + node.data.id).val() == '1') && ($("input#comments").val() == '')) {
                    alert("Вы не указали в коментарии тип биоматериала для исследования '" + node.data.code + "'");
                    o = false;
                    return o;
                }
            if($("#tree-dest #m" + obj.id).val()) {
                if (($("#tree-dest #m" + node.data.id).val() == '70') ||
                        ($("#tree-dest #m" + node.data.id).val() == '')) {
                    b = false;
                    return b;
                }
            }
        });
        if ($("#tree-dest").dynatree("getTree").count() == 0) {
            alert('Вы не выбрали ни одной панели!');
            return false;
        }
        if (!b) {
            alert('Вы не выбрали биоматериал!');
            return false;
        }
        global_formNavigate = true;
        return b & o;
        //$("#tree-dest .dynatree-container").css("border", "2px red solid");

    }
    function submitRegForm($url) {
        var qString = $("#RegAll").serializeArray();
        var ids = "";
        $("#tree-dest").dynatree("getRoot").visit(function(node){
            ids += node.data.code+",";
        });

        qString.push({name: "panels", value: ids});
        $.ajax({
            data: qString,
            traditional: true,
            beforeSend: function(jqXHR, settings){
                //$('#save').attr('disabled','disabled');
                $('#infoFrm').html('<img style="vertical-align: inherit; padding-right: 15px; margin:0px; border:0;" src="{{asset('images/ajax_loader.gif')}}" /><b>Пожалуйста, подождите. Идет сохранение...</b>');
                $('#infoFrm').show('fade');
            },
            type: "GET",
            url: $url,
            cache: false,
            timeout : 10000,
            error: function(jqXHR, textStatus, errorThrown){
                $('#infoFrm').html('Ошибка: ' + textStatus + '. Тайм-аут операции. Повторите попытку сохранения чуть позже.');
                $('#save').removeAttr('disabled','disabled');
            },
            success: function(data, textStatus, jqXHR){
                $('#infoFrm').html(jqXHR);
                $('#infoFrm').show('fade');
                setTimeout(function() { $('#infoFrm').hide('fade'); }, 5000)
            },
            complete: function(jqXHR, textStatus){
                if ($('#folderno').text() !== 'N/A') document.location = "{{url("draft")}}/"+$('#folderno').text();
            },
            statusCode:{
                404:function(){
                    $('#infoFrm').html('<p>Сервер сообщает, что страница не найдена. Обратитесь к слубже поддержки.</p>');
                },
                200: function(data){
                    $('#infoFrm').html(data);
                }
            }
        });
    }
    function Rshow(s){
        rs = "R"+s;
        if($("#"+s).val()!='') {
            $("#"+rs).val($("#"+s).val());
            $("label[for='"+rs+"']").show();
            $("#"+rs).show();
        } else {
            $("label[for='"+rs+"']").hide();
            $("#"+rs).hide();
        }
    }
</script>
