<header class="header_area">
    <!-- Top Header Area-->
    <div class="top-header-area">

        <div class="bigshop-main-menu" id="sticker">
            <div class="container">
                <div class="classy-nav-container breakpoint-off">
                    <nav class="classy-navbar" id="bigshopNav">
                        <!-- Nav Brand--><a class="nav-brand" href="{{url('/')}}"><img src="{{asset('assets/main/JumPQ-logo/default.png')}}" alt="logo" width="140" height="35"></a>
                        <!-- Toggler-->
                        <div class="classy-navbar-toggler"><span class="navbarToggler"><span></span><span></span><span></span></span></div>
                        <!-- Menu-->
                        <div class="classy-menu">
                            <!-- Close-->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>
                            <!-- Nav-->
                            <div class="classynav">
                                <ul>
                                    @if(!Request::is('/'))
                                    <li><a href="{{url('/')}}">Home</a> </li>
                                    @endif
                                    @if (!Request::is('/'))
                                    <li><a href="#">Stores</a>
                                        <div class="megamenu">
                                        </div>
                                    </li>
                                    @endif
                                    @unless (Request::is('about-us'))
                                    <li><a href="{{route('about_us')}}">About Us</a></li>
                                    @endunless
                                    @unless (Request::is('contact-us'))
                                    <li><a href="{{route('contact_us')}}">Contact</a></li>
                                    @endunless

                                    <li class="cn-dropdown-item has-down"><a href="#">Ads</a>
                                        <ul class="dropdown">
                                            <li><a href="{{route('advert-pricing')}}">Pricing</a></li>
                                            @if (Auth::guard('ads')->check())
                                            <li><a href="{{route('ads-home')}}">Dashboard</a></li>
                                            @else
                                            <li><a href="{{route('advert-placement')}}">Register & Login</a></li>
                                            @endif
                                        </ul>
                                        <span class="dd-trigger"></span>
                                    </li>

                                    @unless (Request::is('privacy'))
                                    <li><a href="{{route('privacy')}}">Privacy</a></li>
                                    @endunless
                                </ul>
                            </div>
                        </div>
                        <!-- Hero Meta-->
                        <div class="hero_meta_area ml-auto d-flex align-items-center justify-content-end">

                            @if (Auth::guard('user')->check() && Request::is('user*'))

                            <div class="account-area">
                                <div class="user-thumbnail"><img src="{{route('profile_pic',[Auth::guard('user')->user()->profile_image_location])}}" width="40" height="40"></div>
                                <ul class="user-meta-dropdown">
                                    <li class="user-title"><span>Hello,</span>
                                        {{Auth::guard('user')->user()->firstname}}
                                    </li>
                                    <li><a href="{{route('user_profile')}}">My Account</a></li>
                                    <li><a href="{{route('transactions')}}">Transactions</a></li>
                                    <li><a href="#" id="logout"><i class="icofont-logout"></i> Logout</a></li>
                                </ul>
                            </div>
                            @elseif(Auth::guard('ads')->check())
                            <div class="account-area">
                                <div class="user-thumbnail">
                                    <img src="{{route('profile_pic',["images.jpg"])}}" width="40" height="40">
                                </div>
                                <ul class="user-meta-dropdown">
                                    <li class="user-title"><span>Hello,</span>
                                        {{Auth::guard('ads')->user()->company_name}}
                                    </li>
                                    <li><a href="{{route('ads-profile')}}">My Account</a></li>
                                    <li><a href="{{route('transactions')}}">Campaigns</a></li>
                                    <li><a href="{{route('ads-logout')}}"><i class="icofont-logout"></i> Logout</a></li>
                                </ul>
                            </div>
                            @else
                            <div class="account-area">
                                <div><span class="fa fa-user" style="margin-right:12px; font-size:28px;"> </span> Log-in
                                    <i class="fa fa-caret-down"></i>
                                </div>
                                <ul class="user-meta-dropdown">
                                    <li><a class="btn btn-success btn-sm auth-buttons" style="color:white;font-size:18px;font-weight:bold;" href="{{route('sign_in')}}">Login</a></li>
                                    <li><a class="btn btn-primary btn-sm auth-buttons" style="color:white;font-size:18px;font-weight:bold;" href="{{route('sign_up')}}">Sign-up</a></li>

                                </ul>
                            </div>
                            @endif
                        </div>
                    </nav>
                </div>
            </div>
        </div>
</header>