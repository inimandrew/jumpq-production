@extends('landing.includes.master')

@section('content')
<div class="w-full h-full flex justify-center items-center">
    <div class="my-16 px-4 md:px-0 w-full md:w-2/5 lg:w-7/12 grid grid-rows-1 lg:grid-cols-2">
        <div class="flex items-center bg-white shadow-2xl rounded-none md:rounded-l-3xl">
            <div class="mx-auto mb-4 w-4/5">
                <div class="text-center space-y-1 mb-4">
                    <div href="{{route('new-landing')}}" class="w-20 h-20 py-6 px-4 mx-auto"><img src="{{asset('assets/jump/imgs/jumpq-logo.png')}}" alt="logo" class="object-center object-cover w-full"></div>
                    <p class=" tracking-widest color-app font-medium text-lg">Ad Account Signup</p>
                </div>
                @include('includes.newError')
                <form class="space-y-4" autocomplete="off" method="POST" action="{{route('advert-registration-action')}}">
                    <div class="relative w-full">
                        <input type="text" name="company_name" placeholder="Company Name" required value="{{old('company_name')}}" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 text-black absolute top-5 left-3 font-bold" viewBox="0 0 512 512">
                            <path d="M437.02 330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521 243.251 404 198.548 404 148 404 66.393 337.607 0 256 0S108 66.393 108 148c0 50.548 25.479 95.251 64.262 121.962-36.21 12.495-69.398 33.136-97.281 61.018C26.629 379.333 0 443.62 0 512h40c0-119.103 96.897-216 216-216s216 96.897 216 216h40c0-68.38-26.629-132.667-74.98-181.02zM256 256c-59.551 0-108-48.448-108-108S196.449 40 256 40s108 48.448 108 108-48.449 108-108 108z" />
                        </svg>
                    </div>
                    {{ csrf_field() }}

                    <div class="relative w-full">
                        <input type="text" name="email" placeholder="Email" required value="{{old('email')}}" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-black absolute top-4 left-3 font-bold" viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 8 7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="text" name="phone" placeholder="Phone Number" required value="{{old('phone')}}" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 text-black absolute top-5 left-3 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="text" name="address" placeholder="Head Office Address" required value="{{old('address')}}" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />

                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-5 h-5 text-white absolute top-5 left-3 font-bold" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5m-4 0h4" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="text" name="cac_number" placeholder="CAC Number" required value="{{old('cac_number')}}" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" />

                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white absolute top-4 left-3" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="url" name="website_url" placeholder="Website Link (Optional)" value="{{old('website_url')}}" class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" placeholder="Password" />

                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white absolute top-4 left-3" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 0 0-5.656 0l-4 4a4 4 0 1 0 5.656 5.656l1.102-1.101m-.758-4.899a4 4 0 0 0 5.656 0l4-4a4 4 0 0 0-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>

                    <div class="relative w-full">
                        <input type="password" name="password" placeholder="Password" required class="pl-10 py-4 rounded-lg border border-gray-400 w-full placeholder-gray-600 focus:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent" placeholder="Confirm Password" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white absolute top-4 left-3" viewBox="0 0 24 24" stroke="black">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z" />
                        </svg>
                    </div>

                    <button id="submit" type="submit" class="text-white bg-app py-3 rounded-lg w-full">Signup</button>
                    <p class=" text-lg font-medium text-center">Already Signed up? <a href="{{route('advert-login')}}" class="color-app underline">Login</a>

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