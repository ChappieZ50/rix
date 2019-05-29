<input type="text" name="tags">


@section('general_js')
    <script src="/rix/assets/js/tagify.min.js"></script>
@append

@section('js')
    <script>
        let tags = document.querySelector('input[name=tags]');
        let tagify = new Tagify(tags, {
            whitelist: [@if(!empty($tags)) @foreach($tags as $tag) {"value": "{{$tag->name}}", "id": "{{$tag->term_id}}"}, @endforeach @endif],
        });
        let activeTags = [];
        @isset($post)
        @foreach($post->termRelationships as $relation)
        @if($relation->taxonomy == 'post_tag')
        activeTags.push({"value": "{{$relation->name}}", "id": "{{$relation->term_id}}"});
        @endif
        @endforeach
        @endisset
        tagify.addTags(activeTags);
    </script>
@append
@section('css')
    <link rel="stylesheet" href="/rix/assets/css/tagify.css">
@append
