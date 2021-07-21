@extends('main_site.includes.master')

@section('content')

@include('main_site.includes.breadcrumb')

<!-- Message Now Area -->
<div class="bigshop_reg_log_area section_padding_100_50">
    <div class="container">
        <div class="row">

            <div class="col-12 col-md-12">
                <div class="login_form mb-50">
                    <h5 class="mb-3">SIGN-UP</h5>

                    <form method="POST" autocomplete="off" id="register-user">
                        <div class="form-row">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <input type="text" name="firstname" class="form-control" placeholder="First-Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="lastname" class="form-control" placeholder="Last-Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <button id="submit" type="submit" class="btn btn-primary btn-sm">Register</button>
                    </form>
                    <div class="forget_pass mt-15">
                        <a href="{{route('sign_in')}}">Already Registered? Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Message Now Area -->
@endsection

@section('other_scripts')
<script src="{{asset('assets/general_assets/utility.js')}}"></script>
<script src="{{asset('assets/users/js/register.js')}}"></script>

@endsection
