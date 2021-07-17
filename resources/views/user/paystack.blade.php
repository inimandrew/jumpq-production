@extends('main_site.includes.master')

@section('content')
@include('main_site.includes.breadcrumb')

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
                        <label for="firstName">Email Address: {{$transaction->payer->email}}</label>
                        <input type="hidden" id="email" class="form-control" disabled
                            value="{{$transaction->payer->email}}">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="firstName">Amount:
                            {{$transaction->branch->currency->symbol}} {{number_format(($transaction->total + $transaction->service_charge),2)}}</label>
                        <input type="hidden" id="amount" class="form-control" disabled value="{{$transaction->total + $transaction->service_charge}}">
                    </div>
                </div>
                <input type="hidden" id="reference" value="{{$transaction->transaction_id}}">
                <input type="hidden" id="key" value="{{$public_key}}">
                <input type="hidden" id="sub_account" value="{{$sub_account}}">
                <input type="hidden" id="flat_fee" value="{{$transaction->service_charge}}">

                <div class="form-submit">
                    <button class="btn btn-success" type="button" onclick="payWithPaystack()"> Pay </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('other_scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="{{url('assets/users/js/payment.js')}}"></script>
@endsection
