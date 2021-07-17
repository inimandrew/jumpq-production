<div id="message">
    @foreach($errors->all() as $error)

    @if(Session::has('green'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <center>{{$error}}</center>
    </div>
    @elseif(Session::has('red'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <center>{{$error}}</center>
    </div>
    @endif
    @endforeach
    <?php Session::forget('red'); Session::forget('green');  ?>

    @if (Auth::guard('staff')->check() && Request::is('/staff/*'))
    @if (Auth::guard('staff')->user()->branch->sub_account()->count() < 2)
    <div class="alert alert-warning alert-dismissable">
        <center>Navigate to the Business Account Page under the Settings Menu to Insert your business Account to Recieve
            Payments from Paystack and Flutter</center>
    </div>
    @endif
    @endif

    @if (Auth::guard('ads')->check() && Request::is('ads*'))
    @if (Auth::guard('ads')->user()->status == '0')
    <div class="alert alert-info alert-dismissable">
        <center>Thanks for Registering. Your account details are being Verified and will be activated Soon.</center>
    </div>
    @endif
    @endif
</div>
