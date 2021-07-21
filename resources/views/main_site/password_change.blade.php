@extends('main_site.includes.master')

@section('content')

@include('main_site.includes.breadcrumb')

<!-- Message Now Area -->
<div class="bigshop_reg_log_area section_padding_100_50">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 ">
                <div class="login_form mb-50">
                    <h5 class="mb-3">CHANGE PASSWORD</h5>

                    <form method="POST" autocomplete="off">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                        <input type="hidden" name="user_id" value='{{$user_id}}'>
                        <button id="submit" type="submit" class="btn btn-primary btn-sm">Change Password</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Message Now Area -->
@endsection
@section('other_scripts')
<script src="{{asset('assets/users/js/change_password.js')}}"></script>

@endsection
