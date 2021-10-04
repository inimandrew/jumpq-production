<?php

if (Auth::guard('user')->check()) {
    $navs = ['Home' => 'new-landing', 'Profile' => 'user_profile', 'Cart' => 'cart', 'Transactions' => 'transactions'];
} else if (Auth::guard('ads')->check()) {
    $navs = ['Home' => 'ads-home', 'Create Campaign' => 'create-ads-campaign', 'Profile' => 'ads-profile'];
} else {
    $navs = ['Home' => 'new-landing', 'Ads' => 'plans', 'Privacy' => 'privacy-page', 'Contact Us' => 'contact', 'Download App' => 'download'];
}
?>
<nav class="w-full bg-white z-20 lg:bg-transparent" id="nav">
    <div class="flex items-center justify-between mx-auto space-x-20 w-4/5 lg:bg-transparent">
        <a href="{{route('new-landing')}}" class=" w-20 h-20 py-6 px-4 flex items-center"><img
                src="{{asset('assets/jump/imgs/jumpq-logo.png')}}" alt="logo"
                class="object-center object-cover w-full"></a>
        <div class="hidden uppercase lg:flex items-center justify-between w-3/5 text-black text-sm">
            @foreach($navs as $index => $nav)
            <a href="{{route($nav)}}" class="mainLink tracking-wide font-semibold ">{{$index}}</a>
            @endforeach

            @if(Request::is('/'))
            <a href="#video" class="mainLink tracking-wide font-semibold">Video Info</a>
            @endif

            @if(Auth::guard('user')->check())
            <a href="{{route('auth-logout')}}"
                class="authLink tracking-wide font-semibold border border-app px-8 py-2 rounded-md color-app ">Logout</a>
            @elseif(Auth::guard('ads')->check())
            <a href="{{route('ads-logout')}}"
                class="authLink tracking-wide font-semibold border border-app px-8 py-2 rounded-md color-app ">Logout</a>
            @else
            <a href="{{route('sign_in')}}"
                class="authLink tracking-wide font-semibold border border-app px-8 py-2 rounded-md color-app ">Login</a>
            @endif
        </div>
        <button id="button-mobile" class="block  lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" id="open-icon" class="fill-current text-black w-8 h-8" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" id="close-icon" fill="none"
                class="fill-current text-black w-8 h-8 hidden" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div id="mobile-nav"
        class="hidden uppercase items-center justify-between w-full font-medium text-black text-base text-center space-y-2 py-2 bg-white z-20">
        @foreach($navs as $index => $nav)
        <a href="{{route($nav)}}" class="mainLink tracking-wide block z-20">{{$index}}</a>
        @endforeach
        <a class="mainLink tracking-wide block z-20">Login</a>
    </div>
</nav>