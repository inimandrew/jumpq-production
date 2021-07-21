<style>
    th {
        text-align: center;
    }

    td {
        text-align: center;
    }

    .remove {
        color: red;
    }

</style>
<div class="row">
    <div class="col-md-8">
        <div class="white-box">

            <h3 class="box-title m-b-0">Check Out</h3>
            <hr>
            <div class="row">
                <form class="form" autocomplete="off" id="buyer">
                    {{ csrf_field() }}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Customer's Full Name" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="number" name="phone" class="form-control"
                                    placeholder="Customer's Phone Number" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="margin-top:15px;">
                        <div class="form-group">
                            <div class="col-md-12">
                                <select name="payment_type_id" class="form-control m-b-10 text-capitalize"
                                    id="payment_types">
                                    <option value="">Select a Payment Type</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12" style="margin-top: 10px;">
                        <div class="form-group" style="padding: 0 15px;">
                            <div class="input-group m-t-10">
                                <input type="text" name="barcode" class="form-control" autofocus
                                    placeholder="Scan Product Barcode"> <span class="input-group-btn">
                                    <button type="button" id="rescan"
                                        class="btn waves-effect waves-light btn-info">Scan</button>
                                </span> </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div id="led" class="white-box" style="text-align: center;height:311px;">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <div class="row">
                <h3 class="box-title m-b-0">Cart</h3>
                <div class="table-responsive">
                    <table id="mainTable" class="table table-bordered table-striped color-table inverse-table m-b-0">
                        <thead>
                            <tr style="text-align:center;">
                                <th>Product Name</th>
                                <th>Unit
                                    Price({{ Auth::guard('staff')->user()->branch->currency->symbol }})
                                </th>
                                <th>Quantity</th>
                                <th>Total
                                    Amount({{ Auth::guard('staff')->user()->branch->currency->symbol }})
                                </th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody id="cart_details">

                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-4 col-md-offset-8">
        <div class="white-box">
            <div class="row">
                <div>
                    <h5 style="background:black;color:white; padding:20px;">Cart Information</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td>{{ Auth::guard('staff')->user()->branch->currency->symbol }}<span
                                            id="sub_total">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Service Charge ({{ $data['service_charge']->value }}%)
                                    </td>
                                    <td>{{ Auth::guard('staff')->user()->branch->currency->symbol }}<span
                                            id="vat">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ Auth::guard('staff')->user()->branch->currency->symbol }}<span
                                            id="total">0.00</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="submit" class="btn btn-success d-block pull-right">Clear Payment</a>
                        <input type="hidden" name="service_charge"
                            value="{{ $data['service_charge']->value }}">
                </div>
            </div>
        </div>
    </div>

</div>



<?php
$service = $data['service_charge']->value;
?>

@section('other_scripts')
<script src="{{ url('assets/administrator/js/staff/checkout.js') }}"></script>

@endsection
