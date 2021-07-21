<link href="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/css/select2.min.css')}}" rel="stylesheet" />
<meta name="product_unique_id" content="{{$data['product_id']}}">
<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('assets/main/dist/css/dropify.min.css')}}">
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row">


            <h3 class="box-title m-b-0">Edit Product</h3>
<hr>
            <form class="form" autocomplete="off" id="edit-product">
                {{ csrf_field() }}

                <div class="form-group col-lg-6">
                    <label class="col-md-12">Category</label>
                    <div class="col-md-12">
                        <select name="category_id" id="categories" class="form-control select2">
                            <option></option>
                        </select>
                     </div>
                </div>

                <div class="form-group col-lg-6">
                    <label class="col-md-12">Product Type</label>
                    <div class="col-md-12">
                        <select type="text" id="product_type" name="product_type" class="form-control">
                            <option value="0">Products with RFID & Barcode Tags</option>
                                <option value="1">Products With only Barcode Tags</option>
                        </select>
                     </div>
                </div>

                <div class="form-group col-lg-4">
                    <label class="col-md-12">Product Name</label>
                    <div class="col-md-12">
                        <input type="text" name="product_name" class="form-control">
                     </div>
                </div>

                <input type="hidden" name="product" value="{{$data['product_id']}}">

                <div class="form-group col-lg-4" id="price">
                    <label class="col-md-12">Unit Price</label>
                    <div class="col-md-12">
                        <input type="text" name="price" step="0.1" class="form-control">
                     </div>
                </div>

                <div class="form-group col-lg-4" id="cost_price">
                    <label class="col-md-12">Cost Price</label>
                    <div class="col-md-12">
                        <input type="text" name="cost_price" step="0.1" class="form-control">
                     </div>
                </div>

                <div class="form-group col-lg-12">
                    <label class="col-md-12">Product Description</label>
                    <div class="col-md-12">
                        <textarea type="text" rows="4" id="description" name="description" class="form-control" placeholder="Type Product Description here"></textarea>
                     </div>
                </div>



                <div style="margin-left: 30px;">
                    <button class="btn btn-success btn-md " type="submit" id="update">Submit</button>
                    <a class="btn btn-primary btn-md" href="{{route('inventory')}}">Back to Inventory</a>
                </div>

            </form>
        </div>
        </div>
    </div>
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/edit_product.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
<script>
    $('#rescan').click(function (e) {
        $("input[name='barcode']").val('');
        $("input[name='barcode']").focus();
    });
</script>
@endsection
