@foreach($images as $image)
    <button type="button" class="media-details-btn" id="imageDetailsBtn" data-toggle="modal"
            data-target="#imageDetails" data-id="{{$image->image_id}}" name="imageDetailsBtn">
        <label class="imagecheck mb-4">
            <input name="imagecheck" type="hidden" value="{{$image->image_id}}" class="imagecheck-input"/>
            <figure class="imagecheck-figure">
                <img src="{{\App\Helpers\Helper::srcImage($image->image_name)}}" class="imagecheck-image">
            </figure>
        </label>
    </button>
@endforeach