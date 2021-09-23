@extends('main_site.includes.master')
@section('content')
@include('main_site.includes.breadcrumb')
<style>
    .mb-50 .row {
        gap: 10px;
        padding: 0 10px;
    }

    .main {
        padding: 15px 15px;
        width: 100%;
        border: 1px solid rgb(243, 239, 239);
        background-color: #f8f8ff;
        border-radius: 5px;
    }

    .badge {
        padding: 10px 10px;
    }

    .main span {
        display: block;
        color: black;
    }

    .main span:first-of-type {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .main span:last-of-type {
        font-size: 1.2rem;
        font-weight: 400;
    }
</style>
<section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            @include('main_site.includes.sidenav')


            <div class="col-12 col-lg-9">
                <div class="mb-50">
                    <div class="row">
                        <div class="col-12 col-md-3 main">
                            <span class="block text-left">Total Campaigns</span>
                            <span class="block text-right">{{Auth::guard('ads')->user()->campaign()->count()}}</span>
                        </div>

                        <div class="col-12 col-md-3 main">
                            <span class="block text-left">Approved Campaigns</span>
                            <span class="block text-right">{{Auth::guard('ads')->user()->campaign()->where('approved','1')->count()}}</span>
                        </div>

                        <div class="col-12 col-md-3 main">
                            <span class="block text-left">Rejected Campaigns</span>
                            <span class="block text-right">{{Auth::guard('ads')->user()->campaign()->where('approved','2')->count()}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="cart-table">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-30">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Amount (₦)</th>
                                    <th scope="col">Payment Service</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Approval Status</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @forelse (Auth::guard('ads')->user()->campaign as $campaign)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{$campaign->title}}</td>
                                    <td>{{$campaign->start_date}}</td>
                                    <td>{{$campaign->end_date}}</td>
                                    <td>{{$campaign->amount}}</td>
                                    <td>{{$campaign->payment->name}}</td>
                                    <td>
                                        @if ($campaign->status == '0')
                                        <span class="badge badge-info">Inactive</span>
                                        @else
                                        <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($campaign->paid == '0')
                                        <span class="badge badge-info">Awaiting Payment</span>
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
                                        @if ($campaign->approved == 1 && $campaign->paid == 0)
                                        <button @if ($campaign->payment_type_id == 3 )
                                            class="btn btn-info paystack"
                                            data-key="{{$data['paystack']->value}}"
                                            @elseif($campaign->payment_type_id == 4)
                                            class="btn btn-info flutter"
                                            data-key="{{$data['flutter']->value}}"
                                            @endif
                                            data-amount="{{$campaign->amount}}" data-id="{{$campaign->id}}"
                                            data-email="{{Auth::guard('ads')->user()->email}}"
                                            data-name="{{Auth::guard('ads')->user()->company_name}}"
                                            type="button">Payment</button>
                                        @endif
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        No Campaigns Created
                                    </td>

                                </tr>

                                @endforelse




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
@endsection
@section('other_scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="{{asset('assets/ads/js/paystack.js')}}"></script>
<script src="{{asset('assets/ads/js/flutterwave.js')}}"></script>

@endsection