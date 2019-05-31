<div class="modal fade" tabindex="-1" role="dialog" id="imageDetails" aria-modal="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><strong>Resim Detayları</strong></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="image-preview-area col-lg-8 col-md-12">
                        <img src="" id="imageSrc">
                    </div>
                    <div class="image-details-area col-lg-4 col-md-12">
                        <div class="details">
                            <div class="filename"><strong>Resim Adı: </strong> <span></span></div>
                            <div class="file-type"><strong>Resim Tipi: </strong><span></span></div>
                            <div class="uploaded"><strong>Eklenme Tarihi: </strong><span></span></div>
                            <div class="file-size"><strong>Resim Boyutu: </strong><span></span></div>
                            <div class="dimensions"><strong>Boyutlar: </strong><span></span></div>
                        </div>
                        <div class="inputs mt-3">
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-12">URL</label>
                                <div class="col-12">
                                    <input type="text" class="form-control" readonly="" name="image_url">
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
                        <div class="actions">
                            <a href="javascript:;"  class="delete">Kalıcı olarak sil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('css')

@append
@section('js')

@append
