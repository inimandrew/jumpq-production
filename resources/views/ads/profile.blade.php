@extends('main_site.includes.master')
@section('content')
@include('main_site.includes.breadcrumb')

<section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            @include('main_site.includes.sidenav')


            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                    <h5 class="mb-3">Account Details</h5>

                    <form method="POST" autocomplete="off" action="{{route('update-ads-profile')}}">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="firstName">Company Name </label>
                                    <input type="text" class="form-control" name="company_name" value="{{Auth::guard('ads')->user()->company_name}}" required>
                                </div>
                                {{ csrf_field() }}
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Phone </label>
                                    <input type="text" class="form-control" name="phone" value="{{Auth::guard('ads')->user()->phone}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="firstName">Email Address </label>
                                    <input type="email" class="form-control" disabled name="email" value="{{Auth::guard('ads')->user()->email}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{Auth::guard('ads')->user()->address}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">CAC Number </label>
                                    <input type="text" class="form-control" name="cac_number" value="{{Auth::guard('ads')->user()->cac_number}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Website Url</label>
                                    <input type="text" class="form-control" name="website_url" value="{{Auth::guard('ads')->user()->website_url}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="newPass">New Password (Leave blank to leave unchanged)</label>
                                    <input type="password" class="form-control" name="password" value="{{old('password')}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="confirmPass">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <button id="update" type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection