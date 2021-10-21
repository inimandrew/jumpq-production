@extends('landing.includes.master')

@section('content')
<div class="w-full bg-white">
    <div class="flex items-center justify-center py-10">
        <div class=" border-4 border-gray-900 rounded-md p-2">
            <h5 class="font-bold uppercase text-black tracking-tight underline">Payment Details</h5>

            <form id="paymentForm">
                <div class="px-2 py-2 font-medium tracking-wide">
                    <label for="firstName">First Name:<span class=" color-app"> {{$transaction->payer->firstname}}</span></label>
                    <input type="hidden" class="form-control" id="firstname" value="{{$transaction->payer->firstname}}">
                </div>
                <div class="px-2 py-2 font-medium tracking-wide">
                    <label for="lastName">Last Name: <span class=" color-app">{{$transaction->payer->lastname}}</span></label>
                    <input type="hidden" class="form-control" id="lastname" disabled value="{{$transaction->payer->lastname}}">
                </div>
                <div class="px-2 py-2 font-medium tracking-wide">
                    <label for="firstName">Email Address: <span class=" color-app">{{$transaction->payer->email}}</span></label>
                    <input type="hidden" id="email" class="form-control" disabled value="{{$transaction->payer->email}}">
                </div>
                 <div class="px-2 py-2 font-medium tracking-wide">
                    <label for="firstName">Phone: <span class=" color-app">{{$transaction->payer->phone}}</span></label>
                    <input type="hidden" id="phone" class="form-control" disabled value="{{$transaction->payer->phone}}">
                </div>
                <div class="px-2 py-2 font-medium tracking-wide">
                    <label for="firstName">Amount:
                        <span class=" color-app">{{$transaction->branch->currency->symbol}} {{number_format(($transaction->total + $transaction->service_charge),2)}}</span></label>
                    <input type="hidden" id="amount" class="form-control" disabled value="{{$transaction->total + $transaction->service_charge}}">
                </div>
                
                <input type="hidden" id="reference" value="{{$transaction->transaction_id}}">
                <input type="hidden" id="key" value="{{$public_key}}">
                <input type="hidden" id="sub_account" value="{{$sub_account}}">
                <input type="hidden" id="flat_fee" value="{{$transaction->service_charge}}">

                <div class="">
                    <button class="px-2 py-2 text-white bg-green-500 rounded-md w-full font-bold uppercase" type="button" onclick="makePayment()"> Pay </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="{{url('assets/users/js/flutter.js')}}"></script>
@endsection