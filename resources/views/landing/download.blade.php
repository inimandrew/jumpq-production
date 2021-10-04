@extends('landing.includes.master')

@section('content')
<div class="w-full">
    <div class="mx-auto w-10/12 md:w-3/5 grid grid-cols-1 md:grid-cols-2 mt-12">
        <div class="w-full relative hidden md:block">
            <img src="{{asset('assets/jump/imgs/hands-on-phone.png')}}" class="object-center object-cover z-10" />
        </div>
        <div class="w-full flex justify-center items-center px-8 md:px-10 relative">
            <div class="space-y-6 mt-4">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-black">Simplify your shopping <span
                        class="color-app">experience</span></h1>
                <p class="font-medium text-justify text-lg md:text-xl tracking-wide">
                    Download the app to get started
                </p>

                <div class="mx-auto md:mx-0 w-2/3 md:w-1/2">
                    <a href="{{route('download-action')}}"
                        class="px-2 w-auto py-3 flex items-center space-x-2 border border-app font-semibold text-sm color-app md:text-lg rounded-xl bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class=" fill-current w-6 h-6 animate animate-bounce"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4-4 4m0 0-4-4m4 4V4" />
                        </svg> <span>Download
                            App</span></a>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection