<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Ad Accounts</h3>
                <div class="scrollable">
                    <div class="table-responsive">
                        <table style="text-align: center;"
                            class="table m-t-30 table-hover table-bordered contact-list color-table dark-table">
                            <thead>
                                <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Company Name</th>
                                    <th class="text-center">Company Email</th>
                                    <th class="text-center">Company Phone</th>
                                    <th class="text-center">Company Address</th>
                                    <th class="text-center">Company CAC Number</th>
                                    <th class="text-center">Company Website Url</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data['accounts']->count())
                                <?php $i = 0; ?>
                                @foreach ($data['accounts'] as $account)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td class="text-capitalize">{{$account->company_name}}</td>
                                    <td>{{$account->email}}</td>
                                    <td>{{$account->phone}}</td>
                                    <td>{{$account->address}}</td>
                                    <td>{{$account->cac_number}}</td>
                                    <td>{{$account->website_url}}</td>
                                    <td>
                                        @if ($account->status == '0')
                                        <span class=" badge badge-info">Inactive</span>
                                        @else
                                        <span class="badge badge-success">Activated</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($account->status == '0')
                                    <a title="Activate Plan" href="{{route('toggle-account-status',[$account->id,'1'])}}" class="btn btn-success btn-outline btn-circle btn-lg m-r-5"><i
                                            class="fa fa-chain-broken"></i></a>
                                    @else
                                    <a title="Deactivate Plan" href="{{route('toggle-account-status',[$account->id,'0'])}}" class="btn btn-warning btn-outline btn-circle btn-lg m-r-5"><i
                                            class="fa fa-power-off"></i></a>
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">No Ad Accounts Created At this time</td>
                                </tr>

                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
