<script>
    let update_media = "{{route('rix_update_media')}}",
        delete_image = "{{route('rix_delete_image')}}",
        gallery = "{{route('rix_gallery')}}",
        category = "{{route('rix_new_category')}}",
        tag = "{{route('rix_new_tag')}}",
        new_image = "{{route('rix_new_media')}}",
        posts = "{{route('rix_posts')}}",
        post = "{{route('rix_add_new_post')}}",
        redirectPost = "{{route('rix_post')}}",
        comments = "{{route('rix_comments')}}",
        current = "{{route(Route::getCurrentRoute()->action['as'],Request::except('page'))}}",
        messages = "{{route('rix_messages')}}",
        subscriptions = "{{route('rix_subscriptions')}}",
        users = "{{route('rix_users')}}",
        user = "{{route('rix_user')}}";

</script>
<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="/rix/assets/js/stisla.js"></script>

@yield('general_js')
<!-- Template JS File -->
<script src="/rix/assets/js/scripts.js"></script>
<script src="/rix/assets/js/page/modules-ion-icons.js"></script>

@yield("js")
