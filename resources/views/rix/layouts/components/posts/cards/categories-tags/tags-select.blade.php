<input type="text" name="tags">


@section('general_js')
    <script src="/rix/assets/js/tagify.min.js"></script>
@append

@section('js')
    @isset($post) @foreach($post->termRelationships as $relation)  @php($arr[] = $relation->name) @endforeach @endisset
    <script>
        let tags = document.querySelector('input[name=tags]');
        let tagify = new Tagify(tags, {
            whitelist: [@if(!empty($tags)) @foreach($tags as $tag) "{{$tag->name}}", @endforeach @endif],
        });
        tagify.addTags('{{isset($arr) ? rtrim(implode(',',$arr),',') : null}}')
    </script>
@append

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/tagify.css">
@append
