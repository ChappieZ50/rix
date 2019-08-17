@foreach($subscriptions as $subscription)
    <tr>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$subscription->subscription_id}}"
                       id="checkbox-{{$subscription->subscription_id}}">
                <label for="checkbox-{{$subscription->subscription_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>
            {{$subscription->email}}
            <div class="table-links actions" data-id="{{$subscription->subscription_id}}">
                @if($subscription->send == 'no')
                    <a href="#" class="text-success" id="sub">Gönderimi Aç</a>
                @else
                    <a href="#" class="text-danger" id="unsub">Gönderimi Kapat</a>
                @endif
                <div class="bullet"></div>
                <a href="#" class="text-danger" id="delete">Kalıcı Olarak Sil</a>
            </div>
        </td>
        <td>
            {{$subscription->ip}}
        </td>
        <td>{{$subscription->readable_date}}</td>

        @if(!Request::has('type'))
            <td>
                @if($subscription->send == 'ok')
                    <div class="badge badge-primary">Aktif</div>
                @else
                    <div class="badge badge-danger">Kapalı</div>
                @endif
            </td>
        @endif
    </tr>
@endforeach

