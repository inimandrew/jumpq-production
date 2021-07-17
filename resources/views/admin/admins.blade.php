<link href="{{url('assets/administrator/plugins/bower_components/footable/css/footable.core.css')}}" rel="stylesheet">


<div class="row">

        <div class="row">
            <div class="col-md-12">
                 <div class="white-box">
                 <h3 class="box-title">Administrator</h3>
                     <div class="scrollable">
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list color-table dark-table" data-page-size="10">
                                            <thead>
                                                <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Username</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>Registered On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="admin_data" style="text-align:left;">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">
                                                        <a href="{{route('createAdmin')}}"  class="btn btn-info btn-rounded" >Add New Admin</a>
                                                    </td>

                                                    </div>
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
    </div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/admin.js')}}"></script>

@endsection
