@extends('landing.includes.master')

@section('content')
<div class="w-full h-full flex justify-center items-center">
    <div class="my-16 px-4 md:px-0 w-full md:w-2/5 lg:w-7/12 grid grid-rows-1 lg:grid-cols-2">
        <div class="flex items-center bg-white shadow-2xl rounded-none md:rounded-l-3xl">
            <div class="mx-auto mb-4 w-4/5">
                <div class="text-center space-y-2 mb-4">
                    <div href="{{route('new-landing')}}" class="w-20 h-20 py-6 px-4 mx-auto"><img src="{{asset('assets/jump/imgs/jumpq-logo.png')}}" alt="logo" class="object-center object-cover w-full"></div>
                    <p class=" tracking-widest color-app font-medium text-lg">Ad Account Login</p>
                </div>
                @include('includes.newError')

                <form class="space-y-4" action="{{route('advert-login-action')}}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="relative w-full">
                        <input type="email" name="email_login" placeholder="Email" value="{{old('email_login')}}" required class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 text-black absolute top-5 left-3 font-bold" viewBox="0 0 512 512">
                            <path d="M437.02 330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521 243.251 404 198.548 404 148 404 66.393 337.607 0 256 0S108 66.393 108 148c0 50.548 25.479 95.251 64.262 121.962-36.21 12.495-69.398 33.136-97.281 61.018C26.629 379.333 0 443.62 0 512h40c0-119.103 96.897-216 216-216s216 96.897 216 216h40c0-68.38-26.629-132.667-74.98-181.02zM256 256c-59.551 0-108-48.448-108-108S196.449 40 256 40s108 48.448 108 108-48.449 108-108 108z" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="password" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" name="password_login" placeholder="Password" value="{{old('password_login')}}" required />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white absolute top-4 left-3" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z" />
                        </svg>
                    </div>

                    <button id="submit" type="submit" class="text-white bg-app py-3 rounded-lg w-full">Login</button>

                    <p class=" text-lg font-medium text-center">Don't have an Ad Account? <a href="{{route('advert-registration')}}" class="color-app underline">Signup</a>

                    </p>
                </form>
            </div>
        </div>

        <div class="hidden overflow-hidden md:block md:rounded-r-3xl relative">
            <div class="absolute w-full h-full top-0 left-0 bg-black bg-opacity-20"></div>
            <img class="object-center object-cover w-full h-full" src="{{asset('assets/jump/imgs/megaphone.png')}}" />
        </div>

    </div>
</div>
@endsection