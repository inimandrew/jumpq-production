<link href="{{url('assets/administrator/plugins/bower_components/footable/css/footable.core.css')}}" rel="stylesheet">


<div class="row">

        <div class="row">
            <div class="col-md-12">
                 <div class="white-box">
                 <h3 class="box-title">Stores</h3>
                     <div class="scrollable">
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list color-table dark-table" data-page-size="10">
                                            <thead>
                                                <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Number of Branches</th>
                                                    <th>Registered Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="stores_data" style="text-align:left;">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">
                                                        <a href="{{route('new_store_page')}}"  class="btn btn-info btn-rounded" >Add New Store</a>
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
<script src="{{url('assets/administrator/js/stores.js')}}"></script>
@endsection
