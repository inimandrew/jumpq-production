@extends('landing.includes.master')

@section('content')
<div class="w-full h-full flex justify-center items-center bg-app-transparent-shade">
    <div class="bg-white mt-36 mb-16 w-full md:w-2/5 rounded-lg shadow-lg lg:w-7/12 grid grid-rows-1 gap-y-4 lg:gap-x-6 lg:grid-cols-2 px-8 py-6 border-8"
        style="border-color:#f052231a">

        <div class="space-y-4 px-6">
            <div>
                <h2 class="text-2xl color-app font-medium">Get in Touch</h2>
                <p class="font-semibold text-black">Feel free to drop us a line below</p>
            </div>
            <div>
                <label class="w-full block font-medium text-base">Full Name</label>
                <input
                    class="w-full border border-gray-400 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent"
                    type="text" />
            </div>

            <div>
                <label class="w-full block font-medium text-base">E-mail Address</label>
                <input
                    class="w-full border border-gray-400 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent"
                    type="text" />
            </div>

            <div>
                <label class="w-full block font-medium text-base">Phone Number</label>
                <input
                    class="w-full border border-gray-400 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent"
                    type="text" />
            </div>

            <div>
                <label class="w-full block font-medium text-base">Subject</label>
                <input
                    class="w-full border border-gray-400 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent"
                    type="text" />
            </div>

            <div>
                <label class="w-full block font-medium text-base">Message</label>
                <textarea
                    class="w-full border border-gray-400 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent "
                    rows="4"></textarea>
            </div>
            <div>
                <button class="w-full bg-app rounded-md text-white font-semibold py-2 hover:bg-opacity-50">SEND</button>
            </div>
        </div>

        <div class="px-6 ">
            <h1 class="text-2xl color-app font-semibold">Contact Us</h1>
            <div class="space-y-3 mt-2">
                <div class=" flex items-center space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black fill-current" fill="none"
                        viewBox="0 0 24 24" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div>
                        <span class="font-medium tracking-tight">Call Directly @ </span> <span
                            class="color-app font-semibold">01 290 6975</span>
                    </div>
                </div>

                <div class=" flex items-center space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black fill-current"
                        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <path
                            d="M512 97.248c-19.04 8.352-39.328 13.888-60.48 16.576 21.76-12.992 38.368-33.408 46.176-58.016-20.288 12.096-42.688 20.64-66.56 25.408C411.872 60.704 384.416 48 354.464 48c-58.112 0-104.896 47.168-104.896 104.992 0 8.32.704 16.32 2.432 23.936-87.264-4.256-164.48-46.08-216.352-109.792-9.056 15.712-14.368 33.696-14.368 53.056 0 36.352 18.72 68.576 46.624 87.232-16.864-.32-33.408-5.216-47.424-12.928v1.152c0 51.008 36.384 93.376 84.096 103.136-8.544 2.336-17.856 3.456-27.52 3.456-6.72 0-13.504-.384-19.872-1.792 13.6 41.568 52.192 72.128 98.08 73.12-35.712 27.936-81.056 44.768-130.144 44.768-8.608 0-16.864-.384-25.12-1.44C46.496 446.88 101.6 464 161.024 464c193.152 0 298.752-160 298.752-298.688 0-4.64-.16-9.12-.384-13.568 20.832-14.784 38.336-33.248 52.608-54.496z" />
                    </svg>
                    <div>
                        <span class="font-medium tracking-tight">Follow Us @ </span> <span
                            class="color-app font-semibold">Jump_Q</span>
                    </div>
                </div>

                <div class=" flex items-center space-x-4">
                    <svg viewBox="0 0 512.001 512.001" class="w-5 h-5 text-black fill-current"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M373.406 0H138.594C62.172 0 0 62.172 0 138.594V373.41C0 449.828 62.172 512 138.594 512H373.41C449.828 512 512 449.828 512 373.41V138.594C512 62.172 449.828 0 373.406 0zm108.578 373.41c0 59.867-48.707 108.574-108.578 108.574H138.594c-59.871 0-108.578-48.707-108.578-108.574V138.594c0-59.871 48.707-108.578 108.578-108.578H373.41c59.867 0 108.574 48.707 108.574 108.578zm0 0" />
                        <path
                            d="M256 116.004c-77.195 0-139.996 62.8-139.996 139.996S178.804 395.996 256 395.996 395.996 333.196 395.996 256 333.196 116.004 256 116.004zm0 249.976c-60.64 0-109.98-49.335-109.98-109.98 0-60.64 49.34-109.98 109.98-109.98 60.645 0 109.98 49.34 109.98 109.98 0 60.645-49.335 109.98-109.98 109.98zM399.344 66.285c-22.813 0-41.367 18.559-41.367 41.367 0 22.813 18.554 41.371 41.367 41.371s41.37-18.558 41.37-41.37-18.558-41.368-41.37-41.368zm0 52.719c-6.258 0-11.352-5.094-11.352-11.352 0-6.261 5.094-11.351 11.352-11.351 6.261 0 11.355 5.09 11.355 11.351 0 6.258-5.094 11.352-11.355 11.352zm0 0" />
                    </svg>
                    <div>
                        <span class="font-medium tracking-tight">Follow Us @ </span> <span
                            class="color-app font-semibold">Jump_Q</span>
                    </div>
                </div>

                <div class=" flex items-center space-x-4">
                    <svg viewBox="0 0 510 510" class="w-5 h-5 text-black fill-current"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M435 179.69V0H75v179.69l-75 52.5V510h510V232.19zM166.641 352.464 30 463.485v-196.42zm26.89 16.807L255 407.689l61.47-38.418L452.752 480H57.249zm149.828-16.807L480 267.065v196.421zm124.472-113.172L435 259.81v-43.5zM405 30v248.561l-150 93.75-150-93.75V30zM75 259.81l-32.831-20.519L75 216.31z" />
                        <path
                            d="M135 60h30v30h-30zM195 60h180v30H195zM135 120h30v30h-30zM195 120h180v30H195zM135 180h30v30h-30zM195 180h180v30H195zM195 240h120v30H195z" />
                    </svg>
                    <div>
                        <span class="font-medium tracking-tight">Send us a Mail @ </span> <span
                            class="color-app font-semibold">support@jumpq.com</span>
                    </div>
                </div>


            </div>
            <div class="w-full p-12">
                <img class="object-center object-cover" src="{{asset('assets/jump/imgs/Contact-us-amico.png')}}" />

            </div>
        </div>

    </div>
</div>


@endsection