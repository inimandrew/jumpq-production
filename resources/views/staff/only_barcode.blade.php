<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Check In Products with only Barcode</h3>
            <hr>
            <div class="row">
                <form class="form" autocomplete="off" id="allocate-tags">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="input-group m-t-10">
                            <input type="text" name="barcode" class="form-control" autofocus
                                placeholder="Scan Product Barcode"> <span class="input-group-btn">
                                <button type="button" id="rescan"
                                    class="btn waves-effect waves-light btn-info">Scan</button>
                            </span> </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 10px;">
                        <button type="button" class="btn btn-primary btn-lg" id="alternative">Submit</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <div class="row">
                <h3 class="box-title m-b-0">Scanned Product Details</h3>
                <div class="table-responsive">
                    <table id="mainTable"
                        class="table editable-table table-bordered table-striped color-table inverse-table m-b-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Selling Price</th>
                                <th>Cost Price</th>
                                <th>New Stock Quantity</th>
                                <th>Reorder Level</th>
                            </tr>
                        </thead>

                        <tbody id="product_details">

                        </tbody>

                    </table>
                </div>

                <button type="button" id="submit" class="btn btn-info m-t-10">Submit</button>
            </div>

        </div>
    </div>
</div>



@section('other_scripts')
<script src="{{ url('assets/administrator/js/staff/product_barcode.js') }}"></script>

@endsection
