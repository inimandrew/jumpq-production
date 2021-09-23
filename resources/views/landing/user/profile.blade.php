@extends('landing.includes.master')

@section('content')
<div class="w-full bg-white flex items-center justify-center">
    <div class="mx-auto w-11/12 md:w-2/5 py-4 my-20">
        <h3 class=" font-bold text-lg tracking-wide capitalize my-2">Account Details</h3>
        <div id="message">

        </div>
        <form autocomplete="off" method="POST" id="update-profile">
            <div class="w-full grid gap-3 grid-rows-1 md:grid-cols-2">
                <div class="">
                    <div class="">
                        <label for="firstName" class="block">First Name </label>
                        <input type="text" class="border-2 border-gray-400 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="firstname" value="{{Auth::user()->firstname}}">
                    </div>
                    {{ csrf_field() }}
                </div>
                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Last Name </label>
                        <input type="text" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="lastname" value="{{Auth::user()->lastname}}">
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="firstName" class="block">Email Address </label>
                        <input type="text" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" disabled value="{{Auth::user()->email}}">
                    </div>
                </div>
                <div class="hidden">
                    <div class="">
                        <label for="lastName" class="block">Username</label>
                        <input type="text" disabled class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="username" value="{{Auth::user()->username}}">
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Phone *</label>
                        <input type="text" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="phone" value="{{Auth::user()->phone}}">
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="lastName" class="block">Birthday</label>
                        <input type="date" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="birthday" value="{{Auth::user()->birthday}}">
                    </div>
                </div>

                <div>
                    <div class="">
                        <label for="newPass" class="block">New Password (Leave blank to leave unchanged)</label>
                        <input type="password" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="password">
                    </div>
                </div>

                <div>
                    <div class="">
                        <label for="confirmPass" class="block">Confirm New Password</label>
                        <input type="password" class="border-2 border-gray-500 px-4 py-3 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="password_confirmation">
                    </div>
                </div>

                <div>
                    <div class="">
                        <label class="block">Profile Image</label>
                        <div class="border-2 border-gray-500 px-4 py-2 w-full rounded-sm focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent">
                            <input type="file" accept="image/png, image/jpg, image/jpeg" id="photo" name="photo" data-allowed-file-extensions="jpg png" data-max-file-size="2M" class=" dropify -line">
                        </div>
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
@section('scripts')
<script src="{{url('assets/users/js/profile.js')}}"></script>

@endsection