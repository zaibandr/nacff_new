<script src="{{asset('resources/assets/bootstrap/js/jQuery 2.1.4.js')}}"></script>
<script src="{{asset('resources/assets/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('resources/assets/scripts/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu ul").hide();
        $('#menu ul').each(function(){
            var i=0;
            $(this).find("li").each(function(){
                if($(this).find("a").attr("href")==window.location.href){
                    $(this).addClass('active-row');
                    i=1;
                }
            })
            if(i==1)
                $(this).show();
        });
        $("#menu li span").click(function() { $(this).next().slideToggle("normal"); });
        $(window).scroll(function() {
            if($(this).scrollTop() != 0) {
                $('#scrollup').fadeIn();
            } else {
                $('#scrollup').fadeOut();
            }
        });
        $('#scrollup').click(function() {
            $('body,html').animate({scrollTop:0},800);

        });
    });
</script>