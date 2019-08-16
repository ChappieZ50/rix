@extends("rix.layouts.master")
@section('content')
    <div class="row">
        @include('rix.layouts.components.index.cards.statistic')
    </div>
    <div class="row">
        @isset($records['messages'])
            @include('rix.layouts.components.index.cards.latest-messages')
        @endisset
        @isset($records['comments'])
            @include('rix.layouts.components.index.cards.latest-comments')
        @endisset
        @isset($records['users'])
            @include('rix.layouts.components.index.cards.latest-users')
        @endisset
    </div>

@endsection