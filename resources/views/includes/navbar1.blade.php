<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo" href="{{route('staff_home')}}">
                <!-- Logo icon image, you can use font-icon also --><b>
                <!--This is dark logo icon--><img src="{{url('assets/administrator/plugins/images/admin-logo.png')}}" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="{{url('assets/administrator/plugins/images/admin-logo-dark.png')}}" alt="home" class="light-logo" />
             </b>
                <!-- Logo text image you can use text also --><span class="hidden-xs">
                <!--This is dark logo text--><img src="{{url('assets/administrator/plugins/images/admin-text.png')}}" alt="home" class="dark-logo" /><!--This is light logo text--><img src="{{url('assets/administrator/plugins/images/admin-text-dark.png')}}" alt="home" class="light-logo" />
             </span> </a>
        </div>
        <!-- /Logo -->
        <!-- Search input and Toggle icon -->
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>



        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
            <li>
                <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                    <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{route('profile_pic',Auth::guard('staff')->user()->profile_image_location)}}" alt="user-img" width="40" height="40" class="img-circle"><b class="hidden-xs">{{Auth::guard('staff')->user()->firstname}}</b><span class="caret"></span> </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img"><img src="{{route('profile_pic',Auth::guard('staff')->user()->profile_image_location)}}" alt="user" /></div>
                            <div class="u-text"><h4>{{Auth::guard('staff')->user()->firstname}} {{Auth::guard('staff')->user()->lastname}}</h4><p class="text-muted">{{Auth::guard('staff')->user()->email}}</p></div>
                        </div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{route('staff_profile')}}"><i class="ti-user"></i> My Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" id="logout"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>

            <!-- /.dropdown -->
        </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>
