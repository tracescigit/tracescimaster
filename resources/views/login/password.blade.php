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
            <img alt="TRACESCI" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/illustration.svg') }}">
            <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Worrying about password? <br> We are here to set it up for you.</div>
            <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Track your all invoices at one place</div>
        </div>
    </div>
    <!-- END: Login Info -->
    <!-- BEGIN: Login Form -->
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Forgot Password</h2>
            <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
            <div class="intro-x mt-8">
                <form id="reset-form">
                    <input id="email" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Your email" value="">
                    <div id="error-email" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                </form>
            </div>
            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                <button id="btn-reset" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Submit</button>
                <a href="{{ url('/login') }}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Login</a>
            </div>
        </div>
    </div>
    <!-- END: Login Form -->
</div>
<x-notification></x-notification>
</div>    
@endsection

@section('script')
<script>
    cash(function () {
        async function reset() {
                // Reset state
                cash('#reset-form').find('.login__input').removeClass('border-theme-6')
                cash('#reset-form').find('.login__input-error').html('')

                // Post form
                let email = cash('#email').val()

                // Loading state
                cash('#btn-reset').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(500)

                axios.post(`forgot-password`, {
                    email: email
                }).then(res => {
                    showNotification('success','Success !',res.data.message)
                    setTimeout(()=>{
                        window.location.href = '{{ url('/login') }}'
                    },2000)
                }).catch(err => {
                    showNotification('error','Error !',err.response.data.message)
                    cash('#btn-reset').html('Submit')
                    
                    if (err.response.data.errors) {
                        for (const [key, val] of Object.entries(err.response.data.errors)) {
                            cash(`#${key}`).addClass('border-theme-6')
                            cash(`#error-${key}`).html(val)
                        }
                    }
                })
            }

            cash('#reset-form').on('keyup', function(e) {
                if (e.keyCode === 13) {
                    reset()
                }
            })
            
            cash('#btn-reset').on('click', function() {
                reset()
            })
        })
    </script>
    @endsection