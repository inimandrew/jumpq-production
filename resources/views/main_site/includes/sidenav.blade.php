<div class="col-12 col-lg-3">
    @if (Auth::guard('user')->check() && Request::is('user*'))
    <div class="my-account-navigation mb-50">
        <ul>
            <li><a href="{{route('user_home')}}">Dashboard</a></li>
            <li><a href="{{route('cart')}}">Cart</a></li>
            <li><a href="{{route('transactions')}}">Transactions</a></li>
            <li><a href="{{route('user_profile')}}">Account Details</a></li>
        </ul>
    </div>
    @elseif(Auth::guard('ads')->check() && Request::is('ads*'))
    <div class="my-account-navigation mb-50">
        <ul>
            <li><a href="{{route('ads-home')}}">Dashboard</a></li>
            <li><a href="{{route('create-ads-campaign')}}">Campaigns</a></li>
        </ul>
    </div>
    @endif



</div>
