@extends('landing.includes.master')

@section('content')
<div class="w-full bg-white flex items-center justify-center">
    <div class="mx-auto w-11/12 md:w-2/5 py-4 my-20">
        <h3 class=" font-bold text-lg tracking-wide capitalize my-2">Account Details</h3>
        <div id="message">

        </div>
        <form method="POST" autocomplete="off" action="{{route('update-ads-profile')}}">
            <div class="w-full grid gap-3 grid-rows-1 md:grid-cols-2">
                <div class="">
                    <div class="">
                        <label for="firstName" class="block">Company Name </label>
                        <input type="text" class="border-2 border-gray-400 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="company_name" value="{{Auth::guard('ads')->user()->company_name}}" required>
                    </div>
                    {{ csrf_field() }}
                </div>
                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Phone </label>
                        <input type="text" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="phone" value="{{Auth::guard('ads')->user()->phone}}" required>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="firstName" class="block">Email Address </label>
                        <input type="email" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" disabled name="email" value="{{Auth::guard('ads')->user()->email}}" />
                    </div>
                </div>
                <div>
                    <div class="">
                        <label for="lastName" class="block">Address</label>
                        <input type="text" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="address" value="{{Auth::guard('ads')->user()->address}}" required />
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="lastName" class="block">CAC Number</label>
                        <input type="text" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="cac_number" value="{{Auth::guard('ads')->user()->cac_number}}" required />
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Website URL</label>
                        <input type="url" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="website_url" value="{{Auth::guard('ads')->user()->website_url}}" />
                    </div>
                </div>

                <div>
                    <div class="">
                        <label for="newPass" class="block">New Password (Leave blank to leave unchanged)</label>
                        <input type="password" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="password" />
                    </div>
                </div>

                <div>
                    <div class="">
                        <label for="confirmPass" class="block">Confirm New Password</label>
                        <input type="password" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="password_confirmation" />
                    </div>
                </div>

            </div>
            <div class="my-4">
                <button id="update" type="submit" class="border-app px-4 py-2 bg-app text-white rounded-md">Update Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection