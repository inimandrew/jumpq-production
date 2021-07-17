@extends('main_site.includes.master')

@section('content')
@include('main_site.includes.breadcrumb')
<div class="checkout_area section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="order_complated_area clearfix">
                    @if ($transaction->status == '0')
                    <p>Your Payment has not been confirmed.Please Reload after a while to see if Payment has been confirmed</p>
                    @else
                    <h5>Thank You For Your Order.</h5>
                    <p>You will receive an email of your Reciept</p>
                    @endif

                    <p class="orderid mb-0">Your Transaction id #{{$transaction->transaction_id}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('other_scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="{{url('assets/users/js/payment.js')}}"></script>
@endsection
