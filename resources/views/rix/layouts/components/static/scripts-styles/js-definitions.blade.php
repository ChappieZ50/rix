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
        user = "{{route('rix_user')}}",
        profile = "{{route('rix_profile')}}";
</script>