<script src="{{asset('resources/assets/bootstrap/js/jQuery 2.1.4.js')}}"></script>
<script src="{{asset('resources/assets/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('resources/assets/scripts/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu ul").hide();
        $("#menu li span").click(function() { $(this).next().slideToggle("normal"); });
    });
</script>