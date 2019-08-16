<div class="select-image w-100">
    <div class="image-preview mx-auto d-flex justify-content-center align-items-center" style="height:50px; background:#edeff0;width:100%">
        <button type="button" class="image-button btn" data-toggle="modal" data-target="#mediaModal" data-before="0"
                data-url="{{route('rix.gallery')}}" id="add_image" style="background:transparent;" data-position="featured">
            Öne çıkan resim (İsteğe bağlı)
        </button>
    </div>
    <div id="image-preview" class="mx-auto d-flex justify-content-center align-items-center" style="display: block;">
        @if(isset($page) && isset($page->selected_featured_image))
            @php($imageData = json_decode($page->selected_featured_image->image_data))
            <img src="{{isset($imageData->url) ? $imageData->url : null}}" id="preview_selected_image" data-id="{{$page->selected_featured_image->image_id}}">
        @else
            <img src="" id="preview_selected_image" style="display: none;" data-id="">
        @endisset
    </div>
    <div class="invalid-feedback" data-name="featured_image"></div>
</div>