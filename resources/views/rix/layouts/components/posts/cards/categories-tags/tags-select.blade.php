<input type="text" name="tags">
@section('general_js')
    <script src="/rix/assets/js/tagify.min.js"></script>
@append

@section('js')
    <script>
        let tags = document.querySelector('input[name=tags]');
        new Tagify(tags, {
            whitelist: [@if(!empty($tags)) @foreach($tags as $tag) "{{$tag->name}}", @endforeach @endif],
        });
    </script>
@append

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/tagify.css">
@append
