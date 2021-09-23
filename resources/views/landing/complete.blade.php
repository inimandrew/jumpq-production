@extends('landing.includes.master')

@section('content')
<div class="bg-white w-full">
    <div class=" py-4 w-11/12 md:w-4/5 mx-auto flex items-center justify-center">

        <div class=" my-10 border-4 border-gray-400 rounded-md color-app py-6 px-4 space-y-4">
            @if ($transaction->status == '0')
            <p>Your Payment has not been confirmed.Please Reload after a while to see if Payment has been confirmed</p>
            @else
            <h5 class="font-bold text-sm text-black uppercase">Thank You For Your Order.</h5>
            <p class="font-medium text-lg text-gray-600 ">You will receive an email of your Reciept</p>
            @endif

            <p class="font-medium text-lg text-gray-600 ">Your Transaction id <span class="color-app">#{{$transaction->transaction_id}}</span></p>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="{{url('assets/users/js/payment.js')}}"></script>
@endsection