<link href="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/css/select2.min.css')}}"
    rel="stylesheet" />
<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet"
    type="text/css" />
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Allocate Prooduct to Tags</h3>
            <hr>
            <form class="form" autocomplete="off" id="allocate-tags">
                {{ csrf_field() }}

                <div class="form-group col-lg-12">
                    <label class="col-md-12">Select a Product</label>
                    <div class="col-md-12">
                        <select name="product" id="products" class="form-control ">
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-lg-12" >
                    <label class="col-md-12">Select Tags (<span id="unallocated_count">0</span>)</label>
                    <div class="col-md-12">
                        <select name="tags" id="tags" class="form-control select2" required multiple>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-left: 10px;" id="tags_inputs">
                    <div class="checkbox checkbox-success">
                        <input id="select_all" type="checkbox">
                        <label for="select_all">Allocate All</label>
                    </div>
                </div>


                <button style="margin-left:30px;" class="btn btn-success btn-md " type="submit" id="submit">Allocate
                    Tags</button>
                <a class="btn btn-primary btn-md " href="{{route('inventory')}}">Back to Inventory</a>
            </form>
        </div>
    </div>
</div>


@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/allocation.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/js/select2.min.js')}}"
    type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
@endsection
