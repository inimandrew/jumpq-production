@extends('landing.includes.master')

@section('content')
<div class="w-full">
    <div class="newBg relative flex items-center justify-center">
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-70"></div>
        <div class="grid grid-rows-1 md:grid-cols-3 w-full md:w-4/5 px-8 md:px-16 relative">
            <div class="space-y-6 mt-4 float-left col-span-2">
                <h1 class="text-5xl font-extrabold text-black"><span class="color-app">Privacy Policy</span></h1>
                <p class="font-semibold text-white text-justify text-xl md:text-4xl">
                    Your Privacy is important to us.
                </p>
            </div>
        </div>
    </div>

    <div class="w-full block bg-app-transparent py-4 text-gray-700">

        <div class="grid grid-rows-1 md:grid-cols-3 mx-auto w-11/12 md:w-4/5">

            <div class="flex justify-between items-center w-full col-span-2">
                <div class="space-y-8 text-lg md:text-xl font-medium pl-4 py-6 tracking-wide">
                    <p>
                        Your privacy is important to us. It is Global Shoppers Solution Limited's policy to respect your privacy regarding any information we may collect from you through our app, JUMP Q.
                    </p>
                    <p>
                        We only ask for personal information when we truly need it to provide a service to you. We collect it by fair and lawful means, with your knowledge and consent. We also let you know why we’re collecting it and how it will be used.
                    </p>
                    <p>
                        We only retain collected information for as long as necessary to provide you with your requested service. What data we store, we’ll protect within commercially acceptable means to prevent loss and theft, as well as unauthorized access, disclosure, copying, use or modification.
                    </p>
                </div>
            </div>

            <div class="hidden md:block w-full px-4">
                <img class="object-center object-cover px-4 py-4 h-96 w-96 mx-auto rounded-full border-8 border-app" src="{{asset('assets/jump/imgs/karsten-winegeart-4bC1Ef88OYI-unsplash.png')}}" />
            </div>

        </div>

        <div class="mx-auto w-11/12 md:w-4/5 space-y-8 text-lg md:text-xl font-medium pl-4 py-6 tracking-wide">

            <p>We don’t share any personally identifying information publicly or with thirdparties, except when required to by law.</p>

            <p>Our app may link to external sites that are not operated by us. Please be aware that we have no control over the content and practices of these sites, and cannot accept responsibility or liability for their respective privacy policies.</p>

            <p>You are free to refuse our request for your personal information, with the understanding that we may be unable to provide you with some of your desired services.</p>
            <p>
            <p>Your continued use of our app will be regarded as acceptance of our practices around privacy and personal information. If you have any questions about how we handle user data and personal information, feel free to contact us.</p>

            <div class="space-y-4">
                <h6>Information we collect:
                </h6>
                Jump Q Collects the following categories of information from your use of the application
                <ul class="list-disc px-6">
                    <li>Name(First and Last Name)</li>
                    <li>Email and Phone number</li>
                    <li>Generates and Stores Transaction details(Except Payment-Debit/Credit Card
                        or
                        Bank Account Details which are handled by Flutterwave)</li>
                    <li>Patterns of app usage(shopping pattern) and screen views</li>
                    <li>Location</li>
                    <li>Persistent Identifiers (Device ID, Android ID)</li>
                    <li>Device Details</li>
                </ul>
                <p>
                    What do we do with the information we collect? The short answer is: provide you with
                    an amazing set of products and services that we relentlessly improve on.</p>

                <ul class="list-disc px-6">
                    <li>Develop, operate, deliver, maintain, and protect our services</li>
                    <li>Send you informative communications by email. For example, emails maybe
                        used to respond to support enquiries made by you or to share information about
                        products, services and promotional offers that we think may interest you.</li>
                    <li>Monitor and Analyze Trends and Usage.</li>
                    <li>Personalize the Services by, among other things, customizing the content
                        we
                        show you, including ads.</li>
                    <li>Help you track and manage your historical purchase transactions
                        (expenses).</li>
                    <li>Secure your account with us.</li>
                </ul>

                <p>This Policy is effective as of 14 September, 2020.</p>
            </div>
        </div>


    </div>

</div>

</div>
@endsection