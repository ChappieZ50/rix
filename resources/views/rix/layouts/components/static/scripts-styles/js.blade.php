<script>
    var update_media = "{{route('rix_update_media')}}";
    var delete_image = "{{route('rix_delete_image')}}";
    var add_post = "{{route('rix_add_new_post')}}";
    var add_category = "{{route('rix_new_category')}}";
    var add_tag = "{{route('rix_new_tag')}}";
    var route = "{{route('rix_new_media')}}";
</script>
<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="/rix/assets/js/stisla.js"></script>

@yield('general_js')
<!-- Template JS File -->
<script src="/rix/assets/js/scripts.js"></script>
<script src="/rix/assets/js/page/modules-ion-icons.js"></script>
@yield("js")
