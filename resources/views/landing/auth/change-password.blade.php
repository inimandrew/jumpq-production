@extends('landing.includes.master')

@section('content')
<div class="w-full h-full flex justify-center items-center">
    <div class="my-16 px-4 md:px-0 w-full md:w-2/5 lg:w-7/12 grid grid-rows-1 lg:grid-cols-2">
        <div class="flex items-center bg-white shadow-2xl rounded-none md:rounded-l-3xl">
            <div class="mx-auto mb-4 w-4/5">
                <div class="text-center space-y-2 mb-4">
                    <div href="{{route('new-landing')}}" class="w-20 h-20 py-6 px-4 mx-auto"><img src="{{asset('assets/jump/imgs/jumpq-logo.png')}}" alt="logo" class="object-center object-cover w-full"></div>
                    <p class=" tracking-widest color-app font-medium text-lg">Change Password</p>
                </div>
                <div id="message" class="space-y-2 my-2">

                </div>
                <form class="space-y-4" method="POST" autocomplete="off" id="login-user">
                    <div class="relative w-full">
                        <input type="password" required name="password" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" placeholder="Password" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white absolute top-4 left-3" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="password" required name="password_confirmation" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" placeholder="Confirm Password" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white absolute top-4 left-3" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="hidden" name="user_id" value='{{$user_id}}'>
                    <button id="submit" type="submit" class="text-white bg-app py-3 rounded-lg w-full">Submit</button>

                </form>
            </div>
        </div>

        <div class="hidden md:block overflow-hidden md:rounded-r-3xl relative">

            <img class="object-center object-cover w-full h-full" src="{{asset('assets/jump/imgs/freedom.png')}}" />
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('assets/users/js/change_password.js')}}"></script>
@endsection