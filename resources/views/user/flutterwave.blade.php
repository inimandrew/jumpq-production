@extends('main_site.includes.master')

@section('content')
@include('main_site.includes.breadcrumb')
<style>
    .hide{
        display: none;
    }
</style>
<div class="col-12 col-lg-6 offset-lg-3" style="margin-top: 20px;">
    <div class="my-account-content mb-50">
        <h5 class="mb-3">Payment Details</h5>

        <form id="paymentForm">
            <div class="row">
                <div class="col-12 col-lg-6 ">
                    <div class="form-group">
                        <label for="firstName">First Name: {{$transaction->payer->firstname}}</label>
                        <input type="hidden" class="form-control" id="firstname"
                            value="{{$transaction->payer->firstname}}">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="lastName">Last Name: {{$transaction->payer->lastname}}</label>
                        <input type="hidden" class="form-control" id="lastname" disabled
                            value="{{$transaction->payer->lastname}}">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="Email">Email Address: {{$transaction->payer->email}}</label>
                        <input type="hidden" id="email" class="form-control" disabled
                            value="{{$transaction->payer->email}}">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="Phone">Phone: {{$transaction->payer->phone}}</label>
                        <input type="hidden" id="phone" class="form-control" disabled
                            value="{{$transaction->payer->phone}}">
                    </div>
                </div>
                <div class="col-12 col-lg-12">
                    <div class="form-group">
                        <label for="Amount">Amount:
                            {{$transaction->branch->currency->symbol}} {{number_format(($transaction->total + $transaction->service_charge),2)}}</label>
                        <input type="hidden" id="amount" class="form-control" disabled value="{{$transaction->total + $transaction->service_charge}}">
                    </div>
                </div>
                <input type="hidden" id="reference" value="{{$transaction->transaction_id}}">
                <input type="hidden" id="key" value="{{$public_key}}">
                <input type="hidden" id="sub_account" value="{{$sub_account}}">
                <input type="hidden" id="total" value="{{$transaction->total}}">

                <div class="form-submit ml-2">
                    <button class="btn btn-success" id="submit" type="button" onclick="makePayment()"> Pay </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('other_scripts')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="{{url('assets/users/js/flutter.js')}}"></script>
@endsection
