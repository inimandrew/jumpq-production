<link href="{{url('assets/administrator/plugins/bower_components/footable/css/footable.core.css')}}" rel="stylesheet">

<meta name="unique_id" content="{{$data['store_id']}}">

<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Store Branches for {{$data['store_name']}}</h3>
                <div class="scrollable">
                    <div class="table-responsive">
                        <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list color-table dark-table"
                            data-page-size="10">
                            <thead>
                                <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                    <th>#</th>
                                    <th>Branch Name</th>
                                    <th>Branch ID</th>
                                    <th>No of Staffs</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Currency</th>
                                    <th>Maximum Items</th>
                                    <th>Registered Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="branches_data" style="text-align:left;">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        @if (Auth::guard('admin')->check())
                                        <a href="{{route('new_branch_page')}}" class="btn btn-info btn-rounded">Add New
                                            Branch</a>
                                        @elseif(Auth::guard('staff')->check())
                                        <a href="{{route('staff_create_branch')}}" class="btn btn-info btn-rounded">Add
                                            New Branch</a>

                                        @endif


                                        @if (Auth::guard('admin')->check())
                                        <a href="{{route('view_stores_page')}}" class="btn btn-primary btn-rounded">View
                                            Stores</a>
                                        @endif
                                    </td>

                    </div>
                    <td colspan="8">
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
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/branches.js')}}"></script>

@endsection
