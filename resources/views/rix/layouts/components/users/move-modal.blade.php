<div class="modal fade" id="moveAnOtherUser" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Yazı Aktarma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text">
                   <span class="text-primary"> Merhaba, seçtiğiniz kullanıcının göndermiş olduğu yazılar bulunmaktadır.
                    Eğer bu kullanıcıyı silerseniz yazılarınıda silersiniz. İsterseniz herhangi bir yönetici veya yazara kullanıcının yazdığı yazıları aktarabilirsiniz.</span>
                    <div class="col-12 border border-primary p-3 mt-2 admins">
                        @foreach($admins as $key => $value)
                            <div class="custom-control custom-radio custom-control-inline mb-1">
                                <input type="radio" id="admin-{{$key}}" name="transferAdmin" class="custom-control-input"
                                      value="{{$value->user_id}}">
                                <label class="custom-control-label" for="admin-{{$key}}">{{$value->username}}</label>
                            </div>
                            <div class="clearfix"></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="moveUserModalActions">
                <button type="button" class="btn btn-primary" id="transfer">Aktar</button>
                <button type="button" class="btn btn-danger" id="delete">İçerikle Beraber Sil</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $('#moveAnOtherUser').appendTo("body");
    </script>
@append