<div>
    @foreach($errors->all() as $error)

    @if(Session::has('green'))
    <div class="text-center py-2 bg-green-400 text-white font-semibold rounded-sm">
        <span>{{$error}}</span>
    </div>
    @elseif(Session::has('red'))
    <div class="text-center py-2 bg-red-400 text-white font-semibold rounded-sm">
        <span>{{$error}}</span>
    </div>
    @endif
    @endforeach
    <?php Session::forget('red');
    Session::forget('green');  ?>



    @if (Auth::guard('ads')->check() && Request::is('ads*'))
    @if (Auth::guard('ads')->user()->status == '0')
    <div class="text-center py-2 bg-blue-400 text-white font-semibold rounded-sm">
        <span>Thanks for Registering. Your account details are being Verified and will be activated Soon.</span>
    </div>
    @endif
    @endif
</div>