<div class="col-lg-6 col-md-12 col-12 col-sm-12">
    <div class="card shadow-dark shadow-sm">
        <div class="card-header">
            <h4>Son Mesajlar</h4>
            <div class="card-header-action">
                <a href="{{route('rix.messages')}}" class="btn btn-primary">Hepsini Göster</a>
            </div>
        </div>
        @if($records['messages']->isEmpty())
            <div class="text-center m-3">Hiç mesaj gönderilmemiş</div>
        @else
            <div class="card-body p-0 ">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 25%;">İsim</th>
                            <th>E-Posta</th>
                            <th>Konu</th>
                            <th>Mesaj</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records['messages'] as $message)
                            <tr>
                                <td>{{$message->message_id}}</td>
                                <td>
                                    {{$message->name}}
                                    <div class="table-links">
                                        <a href="{{route('rix.messages',['message' => $message->message_id])}}" class="text-primary" target="_blank">Git</a>
                                    </div>
                                </td>
                                <td>
                                    {{$message->email}}
                                </td>
                                <td>
                                    {{$message->subject}}
                                </td>
                                <td style="padding: 10px;">
                                    {{\App\Helpers\Helper::longText($message->message,['len' => 80])}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>