<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span
                    class="hide-menu">Navigation</span></h3>
        </div>
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true"
                    aria-expanded="false">{{Auth::guard('staff')->user()->firstname}}
                    {{Auth::guard('staff')->user()->lastname}}</a>

            </div>
        </div>
        <ul class="nav" id="side-menu">

            <li> <a href="{{route('staff_home')}}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw"
                        data-icon="v"></i> <span class="hide-menu"> Dashboard </span></a> </li>

            <li class="devider"></li>
            <?php   $store = encrypt(Auth::guard('staff')->user()->branch->store->id);
                    $branch = encrypt(Auth::guard('staff')->user()->branch->id);
             ?>
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span
                        class="hide-menu">Branch Management<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('staff_create_branch')}}"><i class="mdi mdi-new-box fa-fw"></i><span
                                class="hide-menu">New Branch</span></a> </li>
                    <li> <a href="{{route('staff_branches',[$store])}}"><i class="mdi mdi-store fa-fw"></i><span
                                class="hide-menu">View Branches</span></a> </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-account-key fa-fw"></i> <span
                        class="hide-menu">Staff Management<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('staff_create_staff')}}"><i class="mdi mdi-account-switch fa-fw"></i><span
                                class="hide-menu">New Staff</span></a> </li>
                    <li> <a href="{{route('branch_staffs',[$branch])}}"><i
                                class="mdi mdi-account-switch fa-fw"></i><span class="hide-menu">View Staffs</span></a>
                    </li>
                </ul>
            </li>
            @if (Auth::guard('staff')->user()->branch->sub_account()->count())
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span
                        class="hide-menu">Product Management<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('category_page')}}"><i class="fa fa-list-ul fa-fw"></i><span
                                class="hide-menu">New Category</span></a> </li>
                    <li> <a href="{{route('product_page')}}"><i class="fa fa fa-shopping-basket fa-fw"></i><span
                                class="hide-menu">New Products</span></a> </li>
                    <li> <a href="{{route('inventory')}}"><i class="fa fa-book fa-fw"></i><span
                                class="hide-menu">Inventory</span></a> </li>
                    <li class="active"> <a href="javascript:void(0)" class="waves-effect"><i data-icon=""
                                class="fa fa-tags fa-fw"></i><span class="hide-menu">Check In</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse in" aria-expanded="true" style="">
                            <li> <a href="{{route('tags_allocation')}}"><span class="hide-menu">RFID and Barcode
                                    </span></a> </li>
                            <li> <a href="{{route('barcode_only_check_in')}}"><span class="hide-menu">Only
                                        Barcode</span></a> </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endif

            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span
                        class="hide-menu">Sales<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('products_checkout')}}"><i class="fa fa-shopping-cart fa-fw"></i><span
                                class="hide-menu">Checkout</span></a> </li>
                    <li> <a href="{{route('transaction')}}"><i class="fa fa-folder-open fa-fw"></i><span
                                class="hide-menu">Confirmation Scan</span></a> </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-tag fa-fw"></i> <span
                        class="hide-menu">Log<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('log_checkout')}}"><i class="fa fa-history fa-fw"></i><span
                                class="hide-menu">Checked-Out Tags</span></a> </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-settings"></i> <span
                        class="hide-menu">Settings<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('add_account')}}"><i class="mdi mdi-account-settings-variant"></i><span
                                class="hide-menu"> Business Account</span></a> </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
