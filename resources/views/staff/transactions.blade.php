<div class="row">
    <div class="col-md-8">
        <div class="white-box">

            <h3 class="box-title m-b-0">Transaction ID</h3>
            <hr>
            <div class="row">
                <form class="form" autocomplete="off" >
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="unique_id" class="form-control" autofocus
                                placeholder="Enter Transaction ID" required>  </div>
                    </div>
                    <div class="col-lg-12 hide" id="bcode" style="margin-top: 10px;">
                        <div class="form-group" style="padding: 0 15px;">
                            <div class="input-group m-t-10">
                                <input type="text" name="barcode" class="form-control" autofocus
                                    placeholder="Scan Product Barcode"> <span class="input-group-btn">
                                    <button type="button" id="rescan"
                                        class="btn waves-effect waves-light btn-info">Scan</button>
                                </span> </div>
                        </div>

                    </div>
                    <button style="margin-left:15px;" type="button" id="submit" class="btn btn-info m-t-10">Submit</button>

                </form>
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="white-box" id="led" style="text-align: center;height:311px;">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <div class="row">
                <h3 class="box-title m-b-0">Transaction Details</h3>
                <div class="table-responsive">
                    <table class="table editable-table table-bordered table-striped color-table inverse-table m-b-0">
                        <thead>
                            <tr  style="color:black;text-transform:uppercase;font-weight:bold;">
                                <th>TRANSACTION DATE</th>
                                <th>TRANSACTION ID</th>
                                <th>TRANSACTION STATUS</th>
                                <th>ATTENDING STAFF</th>
                                <th>BUYER'S NAME</th>
                                <th>Buyer's Phone</th>
                                <th>Cart</th>
                                <th>Sub-Total Amount</th>
                                <th>Service Charge</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                            <tbody id="transaction">

                            </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/sale.js')}}"></script>

@endsection
