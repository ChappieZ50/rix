<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Başlık</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control input-title">
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Url</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control input-url">
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">İçerik</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="summernote" name="message"></textarea>
    </div>
</div>
<div class="form-group row mb-4">
    <div class="offset-3"></div>
    <div class="col-sm-12 col-md-7">
        <a href="javascript:;" class="btn btn-icon icon-left btn-info media-btn" data-toggle="modal"
            data-target="#mediaModal" data-before="0" data-url="{{route('rix_gallery')}}" id="add_image"><i class="far fa-image"></i> Resim
            Ekle</a>
    </div>
</div>
<div class="form-group">
    <div class="offset-3"></div>
    <div class="col-sm-12 col-md-7">

    </div>
</div>
@include('rix.layouts.components.media-modal')
@section('js')
<script type="text/javascript">
    $(document).ready(function () {
            let title = $('.input-title');
            let url = $('.input-url');
            title.on('keyup', function () {
                let str = $(this).val();
                str = replaceSpecialChars(str);
                $(url).val(str);
            });

            function replaceSpecialChars(str) {
                let specialChars = [["ş", "s"], ["ğ", "g"], ["ü", "u"], ["ı", "i"], ["_", "-"],
                    ["ö", "o"], ["Ş", "S"], ["Ğ", "G"], ["Ç", "C"], ["ç", "c"],
                    ["Ü", "U"], ["İ", "I"], ["Ö", "O"], ["ş", "s"]];

                for (let i = 0; i < specialChars.length; i++)
                    str = str.replace(eval("/" + specialChars[i][0] + "/ig"), specialChars[i][1]);
                return str.toLowerCase().replace(/\s\s+/g, ' ').replace(/[^a-z0-9\s]/gi, '').replace(/[^\w]/ig, "-");
            }

            // Modal Fix modal backdrop
            $('#mediaModal').appendTo("body");
        });
</script>
@append
