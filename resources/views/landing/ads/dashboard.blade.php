@extends('landing.includes.master')

@section('content')
<div class=" w-full h-full bg-white">

    <div class="grid grid-rows-1 gap-4 md:grid-cols-3 mx-auto w-11/12 md:w-3/5 py-6">
        <div class=" px-4 py-4 border-2 border-black color-app rounded-md">
            <span class="block text-left">Total Campaigns</span>
            <span class="block text-right">{{Auth::guard('ads')->user()->campaign()->count()}}</span>
        </div>

        <div class=" px-4 py-4 border-2 border-black color-app rounded-md">
            <span class="block text-left">Approved Campaigns</span>
            <span class="block text-right">{{Auth::guard('ads')->user()->campaign()->where('approved','1')->count()}}</span>
        </div>

        <div class=" px-4 py-4 border-2 border-black color-app rounded-md">
            <span class="block text-left">Rejected Campaigns</span>
            <span class="block text-right">{{Auth::guard('ads')->user()->campaign()->where('approved','2')->count()}}</span>
        </div>
    </div>

    <div class="overflow-x-auto mx-auto w-11/12 md:w-3/5 py-6">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="border border-gray-600 px-2 py-2 text-sm">#</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Title</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Start Date</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">End Date</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Amount (₦)</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Payment Service</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Status</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Payment Status</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Approval Status</th>
                    <th class="border border-gray-600 px-2 py-2 text-sm">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @forelse (Auth::guard('ads')->user()->campaign as $campaign)
                <tr>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">{{ ++$i }}</td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">{{$campaign->title}}</td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">{{$campaign->start_date}}</td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">{{$campaign->end_date}}</td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">{{$campaign->amount}}</td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">{{$campaign->payment->name}}</td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">
                        @if ($campaign->status == '0')
                        <span class="border border-blue-400 text-white bg-blue-400 rounded-full py-1 px-2 text-xs">Inactive</span>
                        @else
                        <span class="border border-green-400 text-white bg-green-400 rounded-full py-1 px-2 text-xs">Active</span>
                        @endif
                    </td>
                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">
                        @if ($campaign->paid == '0')
                        <span class="border border-blue-400 text-white bg-blue-400 rounded-full py-1 px-2 text-xs">Awaiting Payment</span>
                        @else
                        <span class="border border-green-400 text-white bg-green-400 rounded-full py-1 px-2 text-xs">Payment Recieved</span>
                        @endif
                    </td>

                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">
                        @if ($campaign->approved == 0)
                        <span class="border border-blue-400 text-white bg-blue-400 rounded-full py-1 px-2 text-xs">Waiting Approval</span>
                        @elseif($campaign->approved == 1)
                        <span class="border border-green-400 text-white bg-green-400 rounded-full py-1 px-2 text-xs">Approved</span>
                        @elseif($campaign->approved == 2)
                        <span class="border border-red-400 text-white bg-red-400 rounded-full py-1 px-2 text-xs">Rejected</span>
                        @endif
                    </td>

                    <td class="border border-gray-600 px-2 py-2 text-sm text-center">
                        @if ($campaign->approved == 1 && $campaign->paid == 0)
                        @if ($campaign->payment_type_id == 3 )
                        <button data-amount="{{$campaign->amount}}" data-id="{{$campaign->id}}" data-email="{{Auth::guard('ads')->user()->email}}" data-name="{{Auth::guard('ads')->user()->company_name}}" type="button" class="text-white bg-green-400 py-2 px-2 paystack rounded-md" data-key="{{$data['paystack']->value}}"> Make Payment</button>
                        @elseif($campaign->payment_type_id == 4)
                        <button data-amount="{{$campaign->amount}}" data-id="{{$campaign->id}}" data-email="{{Auth::guard('ads')->user()->email}}" data-name="{{Auth::guard('ads')->user()->company_name}}" type="button" class="text-white bg-green-400 py-2 px-2 flutter rounded-md" data-key="{{$data['flutter']->value}}"> Make Payment</button>
                        @endif
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center border border-black py-4">
                        No Campaigns Created
                    </td>

                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection
@section('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="{{asset('assets/ads/js/paystack.js')}}"></script>
<script src="{{asset('assets/ads/js/flutterwave.js')}}"></script>

@endsection