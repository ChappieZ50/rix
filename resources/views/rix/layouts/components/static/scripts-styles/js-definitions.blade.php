<script>
    let update_media = "{{route('rix.update_media')}}",
        delete_image = "{{route('rix.delete_image')}}",
        gallery = "{{route('rix.gallery')}}",
        category = "{{route('rix.new_category')}}",
        tag = "{{route('rix.new_tag')}}",
        new_image = "{{route('rix.new_media')}}",
        posts = "{{route('rix.posts')}}",
        post = "{{route('rix.add_new_post')}}",
        redirectPost = "{{route('rix.post')}}",
        comments = "{{route('rix.comments')}}",
        current = "{{route(Route::getCurrentRoute()->action['as'],Request::except('page'))}}",
        messages = "{{route('rix.messages')}}",
        subscriptions = "{{route('rix.subscriptions')}}",
        users = "{{route('rix.users')}}",
        user = "{{route('rix.user')}}",
        profile = "{{route('rix.profile')}}",
        _pages = "{{route('rix.pages')}}",
        _page = "{{route('rix.page')}}",
        _notifications = "{{route('rix.mark_notifications')}}";
</script>