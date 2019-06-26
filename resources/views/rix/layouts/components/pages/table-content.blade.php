@foreach($pages as $page)
    <tr>
        <td>{{$page->page_id}}</td>
        <td>
            {{$page->title}}
            <div class="table-links actions" data-id="{{$page->page_id}}">
                <a href="{{action('Rix\PagesController@get_page',$page->page_id)}}" class="text-primary" id="edit">Düzenle</a>
                <div class="bullet"></div>
                <a href="javascript:;" class="text-danger" id="delete">Kalıcı Olarak Sil</a>
            </div>
        </td>
        <td>
            @if($page->status == 1)
                <i class="ion ion-checkmark-circled text-primary" style="font-size: 20px;"></i>
            @else
                <i class="ion ion-close-circled text-danger" style="font-size: 20px;"></i>
            @endif
        </td>
        <td>
            {{$page->readable_date}}
        </td>
    </tr>
@endforeach