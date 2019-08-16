<div class="col-lg-6 col-md-12 col-12 col-sm-12">
    <div class="card shadow-dark shadow-sm">
        <div class="card-header">
            <h4>Son Yorumlar</h4>
            <div class="card-header-action">
                <a href="{{route('rix.comments')}}" class="btn btn-primary">Hepsini Göster</a>
            </div>
        </div>
        @if($records['comments']->isEmpty())
            <div class="text-center m-3">Hiç yorum yazılmamış</div>
        @else
            <div class="card-body p-0 ">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 25%;">İsim</th>
                            <th>E-Posta</th>
                            <th>Mesaj</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records['comments'] as $comment)
                            <tr>
                                <td>{{$comment->comment_id}}</td>
                                <td>
                                    {{$comment->name}}
                                    <div class="table-links">
                                        <a href="{{route('rix.comments',['comment' => $comment->comment_id])}}" class="text-primary" target="_blank">Git</a>
                                    </div>
                                </td>
                                <td>
                                    {{$comment->email}}
                                </td>
                                <td style="padding: 10px;">
                                    {{\App\Helpers\Helper::longText($comment->comment,['len' => 80])}}
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