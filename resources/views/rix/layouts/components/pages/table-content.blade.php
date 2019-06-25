@foreach($pages as $page)
    <tr>
        <td>{{$page->page_id}}</td>
        <td>
            {{$page->title}}
            <div class="table-links actions" data-id="{{$page->page_id}}">
                <a href="{{action('Rix\PagesController@get_page',$page->page_id)}}" class="text-primary" id="edit">Düzenle</a>
                <a href="javascript:;" class="text-danger" id="delete">Kalıcı Olarak Sil</a>
            </div>
        </td>
        <td>
            @if($page->status === 'ok')
                <div class="badge badge-primary">OK</div>
            @else
                <div class="badge badge-danger">NO</div>
            @endif
        </td>
        <td>
            {{$page->readable_date}}
        </td>
    </tr>
@endforeach