@extends('landing.includes.master')

@section('content')
<div class="w-full bg-app-transparent">
    <div class="mx-auto w-11/12 md:w-4/5 grid grid-cols-1 md:grid-cols-2 mt-32 mb-12">
        <div class="w-full flex justify-center items-center px-8 md:px-16 relative">
            <div class="space-y-6 mt-4">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-black tracking-tight">Upgrade your plan and Get the
                    Best <span class="color-app">Experience</span></h1>
                <p class="font-medium text-justify text-lg md:text-xl tracking-wide">
                    JumpQ gives you the best experience. Pricier then a news subscription but cheaper than a lawsuit.
                </p>
                <div class="flex space-x-6 items-center">
                    <button class="px-6 py-2 border border-app font-semibold text-sm md:text-lg rounded-md text-white bg-app">Find
                        the Plan for you</button>

                </div>
            </div>
            <div style="width:800px;height:800px;margin-right:-400px;margin-top:-500px;opacity:0.15;" class="block md:hidden rounded-full bg-app absolute top-0 right-0 z-0"></div>
        </div>
        <div class="w-full p-12 hidden md:block">
            <img src="{{asset('assets/jump/imgs/Subscriptions-amico.png')}}" class="object-center object-cover z-50" />

        </div>
    </div>

    <div class="block my-10 space-y-6 py-4 mx-auto mb-20 w-11/12 md:w-4/5">
        <div class="flex items-center justify-center w-full mb-10 md:mb-20">
            <div class="text-center w-full space-y-2 md:w-2/5">
                <h1 class="font-bold text-black text-2xl">Plan<span class=" border-0 border-b-4 border-app pb-1"> Pric</span>ing</h1>
                <p class="text-base tracking-wide font-medium">With three different plans, JUMPQ is sure to have one that checks all of the boxes just for you</p>
            </div>
        </div>

        <div class="mx-auto w-11/12 md:w-3/5">

            <div class="grid md:gap-y-0 grid-rows-1 md:grid-cols-3 items-start justify-between w-full">
                @foreach ($plans as $plan)

                <div class="bg-white px-6 py-4 transition duration-500 ease-in-out transform hover:scale-110 rounded-md border border-app mx-auto w-11/12">
                    <div class="mb-6">
                        <h2 class="font-bold text-2xl capitalize">{{$plan->name}}</h2>
                        <h2 class="font-semibold text-lg tracking-wider color-app">₦{{$plan->price}}</h2>
                        <h2 class="font-medium text-xs">Daily</h2>
                    </div>

                    <div class="mb-36">
                        <p class="flex items-center space-x-1"><svg class="fill-current w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg> <span> <span class="color-app">{{$plan->daily_counts}} </span> Daily Showings </span> </p>
                        @foreach ($plan->assets_allowed as $asset)
                        <p class="flex items-center space-x-1"><svg class="fill-current w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg> <span><span class="color-app"> {{Str::ucfirst($asset->type)}} </span> Files Allowed</span> </p>
                        @endforeach
                    </div>

                    <a href="{{route('advert-login')}}" class="w-full border border-app rounded-md text-white bg-app font-semibold py-2 block text-center">Subscribe</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="block my-10 space-y-6 py-4 mx-auto w-11/12 md:w-4/5">
        <div class="flex items-center justify-center w-full mb-10 md:mb-12">
            <div class="text-center w-full space-y-2 md:w-2/5">
                <h1 class="font-bold text-black text-2xl">Comp<span class=" border-0 border-b-4 border-app pb-1">are</span> Plans</h1>
                <p class="text-base tracking-wide font-medium">Check Out all the Features that differ per plan to find one that fits what you're looking for. All our plans are easy to switch, anytime.</p>
            </div>
        </div>

        <div class="w-full">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left color-app font-bold text-2xl px-4 py-2">Features</th>
                        @foreach ($plans as $plan)
                        <th class="text-center px-4 py-2 font-semibold text-base tracking-wide text-gray-600 capitalize">{{$plan->name}} Plan</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class=" bg-app-transparent2">
                        <td class="text-left px-4 py-4">Daily Showings</td>
                        @foreach ($plans as $plan)
                        <td class="text-center px-4 py-4">{{$plan->daily_counts}}</td>
                        @endforeach
                    </tr>
                    <tr class="">
                        <td class="text-left px-4 py-4"><span class="font-semibold color-app">Photo</span> Files Allowed</td>
                        <td class="text-center px-4 py-4">
                            <svg class="fill-current w-5 h-5 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg>
                        </td>
                        <td class="text-center px-4 py-4">
                            <svg class="fill-current w-5 h-5 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg>
                        </td>
                        <td class="text-center px-4 py-4">
                            <svg class="fill-current w-5 h-5 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg>
                        </td>
                    </tr>
                    <tr class=" bg-app-transparent2">
                        <td class="text-left px-4 py-4"><span class="font-semibold color-app">Video</span> Files Allowed</td>
                        <td class="text-center px-4 py-4"></td>
                        <td class="text-center px-4 py-4">
                            <svg class="fill-current w-5 h-5 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg>
                        </td>
                        <td class="text-center px-4 py-4">
                            <svg class="fill-current w-5 h-5 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
@endsection