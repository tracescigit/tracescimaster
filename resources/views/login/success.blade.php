@extends('../layout/' . $layout)

@section('head')
<title>TRACESCI</title>
@endsection

@section('content')
<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
        <!-- BEGIN: Login Info -->
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="{{ url('/') }}" class="-intro-x flex items-center pt-5">
                <img width="20%"  alt="Tracesci" src="{{asset('web/images/logo.png')}}" class=""></a>
         </a>
         <div class="my-auto">
            <img alt="Midone Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/illustration.svg') }}">
            <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Just one step to <br> create your account.</div>
            <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Create your account with us.</div>
        </div>
    </div>
    <!-- END: Login Info -->
    <!-- BEGIN: Login Form -->
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x px-2 font-bold text-2xl xl:text-3xl text-center xl:text-left">Registration Successful</h2>
            <div class="intro-x mt-4">

                <div class="grid grid-cols-12">

                    <div class="input-form col-span-12 px-2 mt-2">
                        <h2 class="font-medium col-span-12 px-0 mt-4 mb-1 text-green-500 mr-auto">
                            Your profile will now be verified by the TRACESCI onboarding team. You can expect a response about the status of your registration within 2-3 working days. Upon approval, you will receive an email and SMS with a temporary password to login.
                        </h2>
                        <h2 class="font-medium col-span-12 px-0 mt-4 mb-1 text-green-500 mr-auto">

                            In the case of rejection, an email and SMS will be sent with instruction on what information needs to be added to complete your profile.
                        </h2>
                    </div>

                </div>
            </div>

            <div class="intro-x mt-3 xl:mt-4 text-center xl:text-left px-2">
                <a href="{{ url('/') }}" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Back to Home</a>
            </div>

        </div>
    </div>
    <!-- END: Login Form -->
</div>
</div>    
@endsection

@section('script')
@endsection