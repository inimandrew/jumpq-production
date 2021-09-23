@extends('landing.includes.master')

@section('content')
<div class="w-full bg-white flex items-center justify-center">
    <div class="mx-auto w-11/12 md:w-3/5 py-4 my-20">
        <h3 class=" font-bold text-lg tracking-wide capitalize my-2">Cart</h3>

        <div class="overflow-x-auto w-full">
            <table class="table table-auto w-full">
                <thead>
                    <tr>
                        <th class="border border-black p-2">Image</th>
                        <th class="border border-black p-2">Product</th>
                        <th class="border border-black p-2">Unit Price</th>
                        <th class="border border-black p-2">Quantity</th>
                        <th class="border border-black p-2">Total Amount</th>
                    </tr>
                </thead>
                <tbody id="cart_details">

                </tbody>
            </table>
        </div>

        <div class="mt-6 w-full grid grid-rows-1 md:grid-cols-3">
            <input value="{{$service_charge}}" type="hidden" name="service_charge">

            <div class="border border-app px-2 py-4">
                <div class="cart-total-area mb-30">
                    <h5 class="mb-3 px-2 color-app font-bold">Cart Total</h5>
                    <div class="w-full">
                        <table class="table table-auto w-full">
                            <tbody>
                                <tr>
                                    <td class=" px-2 py-2 color-app font-semibold">Sub Total</td>
                                    <td class=" px-2 py-2 color-app font-semibold" id="sub_total"></td>
                                </tr>
                                <tr>
                                    <td class=" px-2 py-2 color-app font-semibold">Service Charge ({{$service_charge}}%)</td>
                                    <td class=" px-2 py-2 color-app font-semibold" id="vat"></td>
                                </tr>
                                <tr>
                                    <td class=" px-2 py-2 color-app font-semibold">Total</td>
                                    <td class=" px-2 py-2 color-app font-semibold" id="total"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{url('assets/main/js/checkout.js')}}"></script>
@endsection