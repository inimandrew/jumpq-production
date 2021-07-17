@extends('main_site.includes.master')

@section('content')
@include('main_site.includes.breadcrumb')

<div class="cart_area section_padding_100_70 clearfix">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12">
                <div class="cart-table">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-30">
                            <thead>
                                <tr>
                                    <th scope="col">Action</i></th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody id="cart_details">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <input value="{{$service_charge}}" type="hidden" name="service_charge">

            <div class="col-12 col-lg-5 offset-lg-7">
                <div class="cart-total-area mb-30">
                    <h5 class="mb-3">Cart Total</h5>
                    <div class="table-responsive">
                        <table class="table mb-3">
                            <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td id="sub_total"></td>
                                </tr>
                                <tr>
                                    <td>Service Charge ({{$service_charge}}%)</td>
                                    <td id="vat"></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td id="total"></td>
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
@section('other_scripts')
<script src="{{url('assets/main/js/checkout.js')}}"></script>
@endsection
