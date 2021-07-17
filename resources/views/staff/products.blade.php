<link href="{{url('assets/administrator/plugins/bower_components/footable/css/footable.core.css')}}" rel="stylesheet">
<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"
    rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Inventory</h3>
            <div class="example">
                <p class="text-muted m-b-20">Select Date Range</p>
                <div class="input-daterange input-group" id="date-range">
                    <input type="text" class="form-control" name="start"> <span
                        class="input-group-addon bg-info b-0 text-white">to</span>
                    <input type="text" class="form-control" name="end">
                </div>
                <button style="margin-top:20px;margin-bottom:20px;" id="date_picker"
                    class="btn btn-primary">Submit</button>
            </div>
            <div class="scrollable">
                <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list color-table dark-table"
                        data-page-size="10">
                        <thead>
                            <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                <th>#</th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Product Type</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Cost Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="products_data" style="text-align:left;">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <a href="{{route('product_page')}}" class="btn btn-info btn-rounded">Add New
                                        Product</a>
                                    <a href="{{route('download_report')}}" class="btn btn-primary btn-rounded">Download Stock Availabilty Report</a>
                                </td>


                                <td colspan="7">
                                    <div class="text-right">
                                        <ul class="pagination">

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light final_delete">Delete</button>
            </div>
        </div>
    </div>
</div>



@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/products.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}">
</script>
<script>
    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });
</script>
@endsection
