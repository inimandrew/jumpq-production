<link href="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />
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
                        <select name="product" id="products" class="form-control select2">
                            <option></option>
                        </select>
                     </div>
                </div>


                    <button style="margin-left:30px;" class="btn btn-success btn-md " type="submit" id="submit">Allocate Tags</button>
                    <a class="btn btn-primary btn-md " href="{{route('inventory')}}">Back to Inventory</a>
            </form>
        </div>
    </div>
</div>

<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4> </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" id="allocate">Allocate</button>
            </div>
        </div>
    </div>
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/allocate.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
@endsection
