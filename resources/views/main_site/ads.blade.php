@extends('main_site.includes.master')

@section('content')


@include('main_site.includes.breadcrumb')

<section class="singl-blog-post-area" style="padding: 20px 0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Blog Details Area -->
                <div class="blog-details-area mb-50">
                    <h3 class="mb-30" style="font-weight: bold;">ADVERT PLACEMENT</h3>
                    <!-- Single Blog Details Area -->
                    <p>To make an advert placement on our Android App. Please Fill in the details below to create an Ad
                        Account.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="bigshop_reg_log_area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="login_form mb-50">
                    <h5 class="mb-3">Login</h5>

                    <form action="{{route('advert-login')}}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" class="form-control" name="email_login" placeholder="Email"
                                value="{{old('email_login')}}" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_login" placeholder="Password"
                                value="{{old('password_login')}}" required>
                        </div>
                        <div class="form-check">
                            <div class="custom-control custom-checkbox mb-3 pl-1">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember me for this
                                    computer</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Login</button>
                    </form>
                    <!-- Forget Password -->
                    <div class="forget_pass mt-15">
                        <a href="#">Forget Password?</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="login_form mb-50">
                    <h5 class="mb-3">Register</h5>

                    <form action="{{route('advert-registration')}}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="company_name" placeholder="Company Name"
                                required value="{{old('company_name')}}">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required
                                value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" required
                                value="{{old('phone')}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Head Office Address"
                                required value="{{old('address')}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="cac_number" placeholder="CAC Number" required
                                value="{{old('cac_number')}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="website_url"
                                placeholder="Website Link (Optional)" value="{{old('website_url')}}">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
