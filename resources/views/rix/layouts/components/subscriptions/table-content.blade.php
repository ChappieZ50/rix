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
        </td>
        <td>
            {{$subscription->ip}}
        </td>
        <td>{{$subscription->readable_date}}</td>
        <td>
            <div class="btn-group dropleft">
                <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"></button>
                <div class="dropdown-menu dropleft actions" data-id="{{$subscription->subscription_id}}">
                    <a class="dropdown-item has-icon" href="javascript:;" id="delete" style="color:red;"><i class="far fa-trash-alt"></i>Kalıcı Olarak Sil</a>
                </div>
            </div>
        </td>
    </tr>
@endforeach
