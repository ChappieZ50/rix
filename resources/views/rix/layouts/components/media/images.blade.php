@foreach($images as $image)
    <div class="col-12 col-lg-6 col-xl-3 col-sm-6 gallery-image-item">
        <label class="imagecheck mb-4">
            <input name="imagecheck" type="@yield('images_select_type','checkbox')" value="{{$image['id']}}" class="imagecheck-input"/>
            <figure class="imagecheck-figure">
                <img src="{{\App\Helpers\Helper::srcImage($image['image_name'])}}" class="imagecheck-image">
            </figure>
        </label>
    </div>
@endforeach
