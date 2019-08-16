@if(session()->has('success'))
    <div id="output-status"><div class="alert alert-success">{{session('success')}}</div></div>
@elseif(session()->has('error'))
    <div id="output-status"><div class="alert alert-danger">{{session('error')}}</div></div>
@endif