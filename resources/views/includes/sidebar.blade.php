<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
        </div>
        <ul class="nav" id="side-menu">

            <li> <a href="{{ route('admin_home') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard </span></a>
            </li>

            <li> <a href="{{ route('admin_home') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard </span></a>
            </li>
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-account-circle fa-fw"></i> <span class="hide-menu">User Management<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="&#xe008;" class="mdi mdi-account-multiple-plus fa-fw"></i><span class="hide-menu">Admin Accounts
                            </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li> <a href="{{ route('createAdmin') }}"><i class="mdi mdi-account fa-fw"></i><span class="hide-menu">New Admin
                                        Account</span></a> </li>
                            <li> <a href="{{ route('returnAdmins') }}"><i class="mdi mdi-account-edit fa-fw"></i><span class="hide-menu">View
                                        Admins</span></a> </li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span class="hide-menu">Store Management<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{ route('new_store_page') }}"><i class="mdi mdi-new-box fa-fw"></i><span class="hide-menu">New Store</span></a> </li>
                    <li> <a href="{{ route('view_stores_page') }}"><i class="mdi mdi-store fa-fw"></i><span class="hide-menu">View Stores</span></a> </li>
                    <li> <a href="{{ route('new_branch_page') }}"><i class="mdi mdi-account-switch fa-fw"></i><span class="hide-menu">New Branch</span></a>
                    </li>
                    <li> <a href="{{ route('admin_edit_branch') }}"><i class="mdi mdi-account-switch fa-fw"></i><span class="hide-menu">Edit Branch</span></a>
                    </li>
                    <li> <a href="{{ route('new_staff_page') }}"><i class="mdi mdi-account-switch fa-fw"></i><span class="hide-menu">New Staff</span></a>
                    </li>

                </ul>
            </li>

            <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span class="hide-menu">Ads Management<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="{{ route("ads-plans") }}"><i class="mdi mdi-new-box fa-fw"></i><span class="hide-menu">Plans</span></a> </li>
                    <li> <a href="{{ route('ads-accounts') }}"><i class="mdi mdi-store fa-fw"></i><span class="hide-menu">View Ads Accounts</span></a>
                    </li>
                    <li> <a href="{{ route('campaign-page') }}"><i class="mdi mdi-account-switch fa-fw"></i><span class="hide-menu">Campaigns</span></a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>