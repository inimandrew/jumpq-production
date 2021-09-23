@extends('main_site.includes.master')

@section('content')
<style>
    .demo {
        padding: 50px 0;
    }

    .heading-title {
        margin-bottom: 50px;
    }

    .pricingTable {
        border: 1px solid #dbdbdb;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.14);
        margin: 0 -15px;
        text-align: center;
        transition: all 0.4s ease-in-out 0s;
    }

    .pricingTable:hover {
        border: 2px solid #232767;
        margin-top: -30px;
    }

    .pricingTable .pricingTable-header {
        padding: 30px 10px;
    }

    .pricingTable .heading {
        display: block;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 21px;
    }

    .pricingTable .pricing-plans {
        padding-bottom: 25px;
        border-bottom: 1px solid #d0d0d0;
        color: #000;
        font-weight: 900;
    }

    .pricingTable .price-value {
        color: #474747;
        display: block;
        font-size: 25px;
        font-weight: 800;
        line-height: 35px;
        padding: 0 10px;
    }

    .pricingTable .price-value span {
        font-size: 50px;
    }

    .pricingTable .subtitle {
        color: #82919f;
        display: block;
        font-size: 15px;
        margin-top: 15px;
        font-weight: 100;
    }

    .pricingTable .pricingContent ul {
        padding: 0;
        list-style: none;
        margin-bottom: 0;
    }

    .pricingTable .pricingContent ul li {
        padding: 20px 0;
    }

    .pricingTable .pricingContent ul li:nth-child(odd) {
        background-color: #fff;
    }

    .pricingTable .pricingContent ul li:last-child {
        border-bottom: 1px solid #dbdbdb;
    }

    .pricingTable .pricingTable-sign-up {
        padding: 25px 0;
    }

    .pricingTable .btn-block {
        width: 50%;
        margin: 0 auto;
        background: #232767;
        border: 1px solid transparent;
        padding: 2px 5px;
        color: #fff;
        text-transform: capitalize;
        border-radius: 5px;
        transition: 0.3s ease;
    }

    .pricingTable .btn-block:after {
        content: "\f090";
        font-family: 'FontAwesome';
        padding-left: 10px;
        font-size: 15px;
    }

    .pricingTable:hover .btn-block {
        background: #fff;
        color: #232767;
        border: 1px solid #232767;
    }

    @media screen and (max-width:990px) {
        .pricingTable {
            margin-bottom: 30px;
        }
    }

    @media screen and (max-width:767px) {
        .pricingTable {
            margin: 0 0 30px 0;
        }
    }
</style>


@include('main_site.includes.breadcrumb')


<div class="bigshop_reg_log_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="demo">
                    <div class="container">
                        <div class="row">
                            @foreach ($plans as $plan)
                            <div class="col-md-4 col-sm-6">
                                <div class="pricingTable">
                                    <div class="pricingTable-header">
                                        <span class="heading">
                                            {{$plan->name}}
                                        </span>
                                    </div>
                                    <div class="pricing-plans">
                                        <span class="price-value"><i class="fa">₦</i><span>{{$plan->price}}</span></span>
                                        <span class="subtitle">Daily</span>
                                    </div>
                                    <div class="pricingContent">
                                        <ul>
                                            <li><b>{{$plan->daily_counts}}</b> Daily showings</li>
                                            @foreach ($plan->assets_allowed as $asset)
                                            <li><b>{{Str::ucfirst($asset->type)}}</b> Files Allowed</li>
                                            @endforeach
                                        </ul>
                                    </div><!-- /  CONTENT BOX-->
                                    @unless(Auth::guard('ads')->check())
                                    <div class="pricingTable-sign-up">
                                        <!-- BUTTON BOX-->
                                        <a href="{{route('advert-placement')}}" class="btn btn-block btn-default">Register</a>
                                    </div><!-- BUTTON BOX-->
                                    @endunless
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection