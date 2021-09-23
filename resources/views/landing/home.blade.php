@extends('landing.includes.master')

@section('content')
<div class="w-full">
    <div class="mx-auto w-11/12 md:w-4/5 grid grid-cols-1 md:grid-cols-2 mt-32 mb-12">
        <div class="w-full flex justify-center items-center px-8 md:px-16 relative">
            <div class="space-y-6 mt-4">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-black">Each Purchase will be made with <span class="color-app">pleasure</span></h1>
                <p class="font-medium text-justify text-lg md:text-xl tracking-wide">
                    We make sure your customers can actually jump the
                    queue created by the conventional cashier manned
                    checkout lanes in your store while making sure your
                    inventory are safe and secured from theft/ loss.
                </p>
                <div class="flex space-x-6 items-center">
                    <button class="px-8 py-3 border border-app font-semibold text-sm md:text-lg rounded-xl text-white bg-app">Get Started</button>
                    <button class="px-8 py-3 border border-app font-semibold text-sm md:text-lg rounded-xl">Learn More</button>
                </div>
            </div>
            <div style="width:800px;height:800px;margin-right:-400px;margin-top:-500px;opacity:0.15;z-index:-1000" class="block md:hidden rounded-full bg-app absolute top-0 right-0"></div>
        </div>
        <div class="w-full relative hidden md:block">
            <img src="{{asset('assets/jump/imgs/Shopping-rafiki.png')}}" class="object-center object-cover z-10" />
            <div style="width:1100px;height:1100px;margin-right:-400px;margin-top:-500px;opacity:0.15;z-index:-1000" class="rounded-full bg-app absolute top-0 right-0"></div>
        </div>
    </div>

    <div class="w-full block bg-app-transparent my-10 space-y-6 py-4">

        <div class="grid grid-rows-1 md:grid-cols-2 mx-auto w-11/12 md:w-4/5">

            <div class="flex justify-between items-center w-full px-4">

                <div>
                    <h1 class="text-gray-600 text-4xl font-bold"><span class="border-0 border-b-4 rounded-sm border-app pb-3">Our</span> Mission</h1>
                    <p class="text-lg md:text-2xl font-medium mt-12 pl-4 py-6 border-0 border-l-4 border-app leading-9 tracking-wide">
                        To allow shoppers process their own payment using
                        their mobile devices so that they don't have to wait at
                        the tills (Queues) for their payments to be processed
                        by the cashier in retail stores
                    </p>
                </div>
            </div>

            <div class=" flex justify-between items-center w-full px-4">
                <img class="object-center object-cover px-4 py-4" src="{{asset('assets/jump/imgs/Self-checkout-rafiki.png')}}" />
            </div>

        </div>

        <div class="grid grid-rows-1 md:grid-cols-2 mx-auto w-11/12 md:w-4/5">
            <div class="flex justify-between items-center w-full px-4">
                <img class="object-center object-cover px-4 py-4" src="{{asset('assets/jump/imgs/Supermarket-workers-rafiki.png')}}" />
            </div>

            <div class="relative flex justify-between items-center w-full px-4">

                <div class=" z-10">
                    <h1 class="text-gray-600 text-4xl font-bold text-right w-full"><span class="border-0 border-b-4 rounded-sm border-app pb-3">Our</span> Vision</h1>
                    <p class="text-lg md:text-2xl font-medium mt-12 pr-4 py-6 border-0 border-r-4 border-app leading-9 tracking-wide">
                        To allow shoppers process their own payment using
                        their mobile devices so that they don't have to wait at
                        the tills (Queues) for their payments to be processed
                        by the cashier in retail stores
                    </p>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="mx-auto w-11/12 md:w-4/5 py-4 bg-app-transparent-shade">
    <h1 class="text-center font-semibold text-4xl text-gray-800 mb-4 tracking-tight">Our <span class=" border-0 border-b-4 pb-3 border-app">Serv</span>ices</h1>

    <div class="grid grid-rows-1 md:grid-cols-2 mx-auto w-11/12 md:w-4/5 gap-x-4">
        <div class="flex items-center justify-center">
            <div class="space-y-6 px-8">
                <h1 class="text-3xl border-0 border-l-4 border-app pl-4 font-bold py-2 mb-4 text-gray-600">Self checkout</h1>
                <p class="text-lg md:text-xl text-gray-700 font-medium leading-8 tracking-wide">We provide our customers, with a reliable and easy-to-use self checkout service.</p>
                <img class="w-full object-center object-cover" src="{{asset('assets/jump/imgs/Self-checkout-amico.png')}}" />
            </div>
        </div>

        <div class="flex items-center justify-center">
            <div class="space-y-6 px-8">
                <h1 class="text-3xl border-0 border-r-4 border-app pr-4 font-bold py-2 mb-4 text-right text-gray-600">Inventory Security</h1>
                <p class="text-lg md:text-xl text-gray-700 font-medium leading-8 tracking-wide text-left">Security is our priority. We Ensure Inventory are properly stored and Kept safe</p>
                <img class="w-full object-center object-cover" src="{{asset('assets/jump/imgs/Filing-system-amico.png')}}" />
            </div>
        </div>
    </div>

</div>

<div id="video" class="mx-auto w-11/12 md:w-4/5 py-4 bg-app-transparent-shade">
    <h1 class="text-center font-semibold text-4xl text-gray-800 mb-4 tracking-tight">For <span class=" border-0 border-b-4 pb-3 border-app">Our</span> Shoppers</h1>

    <div class="grid grid-rows-1 md:grid-cols-2 mx-auto w-11/12 md:w-4/5 gap-x-6 gap-y-6">
        <div class="flex items-center justify-center">
            <div>
                <img class="w-full object-center object-cover" src="{{asset('assets/jump/imgs/Group-75.png')}}" />
            </div>
        </div>

        <div class="flex items-center justify-center">
            <div>
                <img class="w-full object-center object-cover" src="{{asset('assets/jump/imgs/Group-75.png')}}" />
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center my-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="text-center fill-current color-app w-12 h-12" viewBox="0 0 20 20">
            <path d="M20 10a10 10 0 11-20 0 10 10 0 0120 0zM10 2a8 8 0 100 16 8 8 0 000-16zm-.7 10.54L5.75 9l1.41-1.41L10 10.4l2.83-2.82L14.24 9 10 13.24l-.7-.7z" />
        </svg>
    </div>

</div>

<div class="bg-app text-white py-12 px-12">
    <div class="mx-auto my-10 w-11/12 md:w-4/5">
        <div class="space-y-4 mb-8">
            <p class="font-bold text-2xl md:text-4xl">Ready to get Started?</p>
            <p class="font-bold text-2xl md:text-4xl">Created an Account or get in touch</p>
        </div>
        <div class="flex space-x-6 items-center">
            <button class="md:px-8 md:py-4 px-4 py-3 bg-white color-app border border-app rounded-lg text-sm md:text-xl font-medium text-center">Create An Account</button>
            <a class="md:px-8 md:py-4 px-4 py-3 bg-app text-white border border-white rounded-lg text-sm md:text-xl font-medium text-center">Contact Us</a>
        </div>
    </div>
</div>
</div>
@endsection