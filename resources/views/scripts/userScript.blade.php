<script>
    function isDel(){
        return confirm('adas');
    }
    function validateForm(){
        var login = $('#formUserAdd #login');
        var checks = $('#formUserAdd').find('input:checked');
        if(checks.length<1){
            alert('Выберите минимум одно отделение');
            return false;
        }
        if($('label[for="login"]').next("p").text())
            $('label[for="login"]').next("p").remove();
        v = $.get("app/Http/Controllers/UserValidate.php", {
                    'login': login.val()
                            },
                function (data) {
                    //console.log(data.COUNT);
                    if(data.COUNT==1) {
                        $('label[for="login"]').after("<p style='color:red' > Пользователь с таким логином уже существует</p>");
                        return false;
                    }
                    else
                        return true;
                }, 'json');
        return v;
    }
    function validateFormEdit(){
        var checks = $('#formUserEdit').find('input:checked');
        if(checks.length<1){
            alert('Выберите минимум одно отделение');
            return false;
        }
        return true;
    }
    function modal(a, b){
        tr = a.closest('tr');
        $('#login').val(tr.cells[0].innerHTML);
        $('#name').val(tr.cells[1].innerHTML);
        $('#password').val(tr.cells[2].innerHTML);
        $('#userEdit form').attr('action','page6/'+b);
    }
</script>