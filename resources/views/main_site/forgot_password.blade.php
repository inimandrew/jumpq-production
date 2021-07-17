@extends('main_site.includes.master')

@section('content')

@include('main_site.includes.breadcrumb')

<!-- Message Now Area -->
<div class="bigshop_reg_log_area section_padding_100_50">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 ">
                <div class="login_form mb-50">
                    <h5 class="mb-3">Recover Password</h5>

                    <form method="POST" autocomplete="off" id="login-user">
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Enter your Email Address">
                        </div>
                        <button id="submit" type="submit" class="btn btn-info btn-sm">Reset</button>
                    </form>
                    <!-- Forget Password -->
                    <div class="forget_pass mt-15">
                        <a href="{{route('sign_in')}}">Log-in</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('other_scripts')
<script src="{{asset('assets/users/js/recover_password.js')}}"></script>

@endsection
