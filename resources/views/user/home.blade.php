@extends('main_site.includes.master')
@section('content')
@include('main_site.includes.breadcrumb')
<section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
                @include('main_site.includes.sidenav')

            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                    <p>Hello <strong>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</strong> </p>
                    <p>From your account dashboard you can view your recent Transactions and <a href="{{route('user_profile')}}">edit your password and account details</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
