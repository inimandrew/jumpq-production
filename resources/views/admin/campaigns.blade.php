<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Campaigns</h3>
                <div class="scrollable">
                    <div class="table-responsive">
                        <table style="text-align: center;"
                            class="table m-t-30 table-hover table-bordered contact-list color-table dark-table">
                            <thead>
                                <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Account Name</th>
                                    <th class="text-center">Account Email</th>
                                    <th class="text-center">Account Phone</th>
                                    <th class="text-center">Campaign Title</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Approval Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data['campaigns']->count())
                                <?php $i = 0; ?>
                                @foreach ($data['campaigns'] as $campaign)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td class="text-capitalize">{{$campaign->account->company_name}}</td>
                                    <td>{{$campaign->account->email}}</td>
                                    <td>{{$campaign->account->phone}}</td>
                                    <td>{{$campaign->title}}</td>
                                    <td>{{$campaign->start_date}}</td>
                                    <td>{{$campaign->end_date}}</td>
                                    <td>
                                        @if ($campaign->status == '0')
                                        <span class=" badge badge-info">Inactive</span>
                                        @else
                                        <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($campaign->paid == '0')
                                        <span class=" badge badge-info">Awaiting Payment</span>
                                        @else
                                        <span class="badge badge-success">Payment Recieved</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($campaign->approved == 0)
                                        <span class=" badge badge-info">Waiting Approval</span>
                                        @elseif($campaign->approved == 1)
                                        <span class="badge badge-success">Approved</span>
                                        @elseif($campaign->approved == 2)
                                        <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($campaign->approved == '1')
                                        @if ($campaign->status == '0')
                                        <a title="Activate Campaign"
                                            href="{{route('toggle-campaign-status',[$campaign->id,'1'])}}"
                                            class="btn btn-success btn-outline btn-circle btn-lg m-r-5"><i
                                                class="fa fa-chain-broken"></i></a>
                                        @else
                                        <a title="Deactivate Campaign"
                                            href="{{route('toggle-campaign-status',[$campaign->id,'0'])}}"
                                            class="btn btn-warning btn-outline btn-circle btn-lg m-r-5"><i
                                                class="fa fa-power-off"></i></a>
                                        @endif
                                        @endif

                                        @if ($campaign->approved != 1)
                                        <a title="Approve Campaign"
                                            href="{{route('toggle-approval-status',[$campaign->id,'1'])}}"
                                            class="btn btn-success btn-outline btn-circle btn-lg m-r-5"><i
                                                class="fa fa-thumbs-up"></i></a>
                                        @endif

                                        @if ($campaign->approved != 2)
                                        <a title="Disapprove Campaign"
                                            href="{{route('toggle-approval-status',[$campaign->id,'2'])}}"
                                            class="btn btn-danger btn-outline btn-circle btn-lg m-r-5"><i
                                                class="fa fa-thumbs-down"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="11" class="text-center">No Campaigns has been Created At this time</td>
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
