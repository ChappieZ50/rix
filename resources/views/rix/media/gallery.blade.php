@extends("rix.layouts.master")
@section('page_title','Resimler')
@section('title','Resimler - Rix Admin')
{{--  JS --}}
@section('js')
    <script src="/rix/assets/js/page/gallery.js"></script>
@endsection
{{--  CSS --}}
@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('general_js')
    <script>
        $('#imageDetails').appendTo("body");
    </script>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="gallery pl-4">
                    @foreach($images as $image)
                        <button type="button" class="media-details-btn" id="imageDetailsBtn" data-toggle="modal" data-target="#imageDetails" data-id="{{$image->image_id}}">
                            <label class="imagecheck mb-4">
                                <input name="imagecheck" type="hidden" value="{{$image->image_id}}" class="imagecheck-input"/>
                                <figure class="imagecheck-figure">
                                    <img src="{{\App\Helpers\Helper::srcImage($image->image_name)}}" class="imagecheck-image">
                                </figure>
                            </label>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('rix.layouts.components.media.gallery-modal')
@endsection
