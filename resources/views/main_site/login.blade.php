@extends('main_site.includes.master')

@section('content')

@include('main_site.includes.breadcrumb')

<!-- Message Now Area -->
<div class="bigshop_reg_log_area section_padding_100_50">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 ">
                <div class="login_form mb-50">
                    <h5 class="mb-3">SIGN-IN</h5>

                    <form method="POST" autocomplete="off" id="login-user">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="form-check">
                            <div class="custom-control custom-checkbox mb-3 pl-1">
                                <input type="checkbox" class="custom-control-input" id="customChe">
                                <label class="custom-control-label" for="customChe">Remember me</label>
                            </div>
                        </div>
                        <button id="submit" type="submit" class="btn btn-primary btn-sm">Login</button>
                    </form>
                    <!-- Forget Password -->
                    <div class="forget_pass mt-15">
                        <a href="{{route('forgot_password')}}">Forget Password?</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Message Now Area -->
@endsection
@section('other_scripts')
<script src="{{asset('assets/users/js/login.js')}}"></script>

@endsection
