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
                                    <th scope="col">#</th>
                                    <th scope="col">DATE OF TRANSACTION</th>
                                    <th scope="col">STORE NAME</th>
                                    <th scope="col">TRANSACTION ID</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">CART</th>
                                    <th scope="col">SUB-TOTAL AMOUNT</th>
                                    <th scope="col">SERVICE CHARGE</th>
                                    <th scope="col">TOTAL AMOUNT</th>

                                </tr>
                            </thead>
                            <tbody id="transactions">

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
<script src="{{url('assets/users/js/transactions.js')}}"></script>
@endsection
