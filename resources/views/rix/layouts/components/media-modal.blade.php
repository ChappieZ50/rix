<div class="modal fade media-modal" tabindex="-1" role="dialog" id="mediaModal" aria-modal="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title"><strong>Resim Galerisi</strong></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="add-media-tab" data-toggle="tab" href="#add-media" role="tab"
                           aria-controls="add-media" aria-selected="false">Resim Yükle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="media-tab" data-toggle="tab" href="#media" role="tab"
                           aria-controls="media" aria-selected="true">Resim Seç</a>
                    </li>
                </ul>
                <div class="tab-content tab-bordered media-tabs-content" id="media-tabs-content">
                    {{-- Tab 1 --}}
                    <div class="tab-pane fade add-media-tab" id="add-media" role="tabpanel"
                         aria-labelledby="add-media-tab">
                        @include('rix.layouts.components.media.new_media')
                    </div>
                    {{-- Tab 2--}}
                    <div class="tab-pane fade show active media-tab" id="media" role="tabpanel" aria-labelledby="media-tab">
                        <div class="media-content pt-3">
                            <div class="modal-media-items"></div>
                        </div>
                        <div class="media-details">
                            <div class="content">
                                <div class="title">
                                    <h6>Resim Bilgileri</h6>
                                </div>

                                <div class="image mb-4"><img src=""></div>
                                <div class="details">
                                    <div class="date"></div>
                                    <div class="size"></div>
                                    <div class="pixels"></div>
                                    <div class="delete-image">
                                        <button type="button" class="btn" id="delete_image">Resmi
                                            Sil
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="inputs mt-3">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label col-12">URL</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control" readonly
                                                   value=""
                                                   name="image_url">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label col-12">Başlık</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="image_title">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label col-12">Altyazı</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="image_alt">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger mb-4" id="select_image">Seç</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@append
@section('js')
    <script src="/rix/assets/js/endless-scroll.js"></script>
    <script src="/rix/assets/js/media-modal.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
@append
