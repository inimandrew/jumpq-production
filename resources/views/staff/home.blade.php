<link href="{{url('assets/administrator/plugins/bower_components/footable/css/footable.core.css')}}" rel="stylesheet">
<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"
    rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Sales</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash"></div>
                </li>
                <li class="text-right"><i class="text-success"></i> <span>{{$data['sales']}}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Staffs</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash2"></div>
                </li>
                <li class="text-right"><i class="text-purple"></i> <span>{{$data['staffs']}}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Products</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash3"></div>
                </li>
                <li class="text-right"><i class="text-info"></i> <span>{{$data['products']}}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Available Tags</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash4"></div>
                </li>
                <li class="text-right"><i class="text-danger"></i> <span>{{$data['available_tags']}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">SALES </h3>
            <form autocomplete="off">
            <div class="example">
                <p class="text-muted m-b-20">Select Date Range</p>
                <div class="input-daterange input-group" id="date-range">
                    <input type="text" class="form-control" name="start"> <span
                        class="input-group-addon bg-info b-0 text-white">to</span>
                    <input type="text" class="form-control" name="end">
                </div>
                <button type="button" style="margin-top:20px;margin-bottom:20px;" id="date_picker"
                    class="btn btn-primary">Submit</button>
                <button type="button" style="margin-top:20px;margin-bottom:20px;" class="btn btn-info" data-toggle="modal"
                    data-target="#exampleModal">Sales Report</button>
                </form>
            </div>
            <div class="scrollable">
                <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list color-table dark-table table-bordered"
                        data-page-size="10">
                        <thead>
                            <?php $i=1;
                                        $buyers_arr = [];
                                ?>
                            <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                <th>#</th>
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
                                <th>Reciept</th>
                            </tr>
                        </thead>
                        <tbody id="products_data" style="text-align:left;color:black;">


                        </tbody>
                        <tfoot>
                            <tr>

                                <td colspan="12">
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Sales Record Parameters</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('sales_report')}}" id="sales_form" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="start" class="form-control mydatepicker"
                            max="<?php echo date("Y-m-d",time()); ?>" placeholder="Start Date" required> </div>
                    <div class="form-group">
                        <input type="text" name="end" class="form-control mydatepicker"
                            max="<?php echo date("Y-m-d",time()); ?>" placeholder="End Date" required> </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="sales_form" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/sales.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}">
</script>
<script>
    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });
    jQuery('.mydatepicker, #datepicker').datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });

</script>
@endsection
