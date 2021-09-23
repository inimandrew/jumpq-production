@extends('landing.includes.master')

@section('content')
<div class="w-full bg-white flex items-center justify-center">
    <div class="mx-auto w-11/12 md:w-2/5 py-4 my-20">
        <h3 class=" font-bold text-lg tracking-wide capitalize my-2">Create Campaign</h3>
        <div id="message">

        </div>
        <form enctype="multipart/form-data" autocomplete="off" method="POST" autocomplete="off" action="{{route('create-ads-campaign-action')}}">
            <div class="w-full grid gap-3 grid-rows-1 md:grid-cols-2">
                <div class="">
                    <div class="">
                        <label for="Name" class="block">Campaign Name </label>
                        <input type="text" name="title" value="{{old('title')}}" required class="border-2 border-gray-400 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                    </div>
                    {{ csrf_field() }}
                </div>
                <div class="">
                    <div class="">
                        <label for="Plan" class="block">Plan </label>
                        <select type="text" name="plan_id" required class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent capitalize">
                            <option value="">Select a Plan</option>
                            @foreach ($plans as $plan)
                            <option data-price="{{$plan->price}}" value="{{$plan->id}}">{{$plan->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class=" md:col-span-2">
                    <div class="">
                        <label for="description" class="block">Description </label>
                        <textarea rows="4" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="description" placeholder="Type a Description" required>{{old('description')}}</textarea>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="Start Date" class="block">Start Date</label>
                        <input type="date" min="{{date('Y-m-d',time())}}" name="start_date" value="{{old('start_date')}}" required class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="End Date" class="block">End Date</label>
                        <input type="date" min="{{date('Y-m-d',time())}}" name="end_date" value="{{old('end_date')}}" required class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                    </div>
                </div>

                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Asset Type </label>
                        <select type="text" name="asset_type_id" required class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent capitalize">

                        </select>
                    </div>
                </div>

                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Payment Service </label>
                        <select name="payment_type_id" required class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent capitalize">
                            <option value="">Select a Payment Service</option>
                            @foreach ($payment_types as $payment)
                            <option value="{{$payment->id}}">{{$payment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-span-2">
                    <label for="Name" class="block">Redirect Url</label>
                    <input type="url" name="url_link" value="{{old('url_link')}}" required class="border-2 border-gray-400 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                </div>
                <input type="hidden" name="amount">
                <div class="col-span-2">
                    <div class="">
                        <label class="block">Asset Selection</label>
                        <div class="border-2 border-gray-500 px-4 py-2 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent">
                            <input type="file" accept="image/*" type="file" name="asset" required>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-full py-2">
                <div class="float-right">
                    <h5>Cart Total</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class=" py-2 px-2 border border-black"> Total Amount (₦)</td>
                                    <td class=" py-2 px-2 border border-black" id="total">0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="my-4 w-full">
                <button id="submit" type="submit" class="border-app px-4 py-2 bg-app text-white rounded-md">Create Campaign</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{url('assets/ads/js/campaign.js')}}"></script>
@endsection