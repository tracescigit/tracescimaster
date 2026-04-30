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
                <img width="20%" alt="Tracesci" src="{{asset('web/images/logo.png')}}" class=""></a>
            </a>
            <div class="my-auto">
                <img alt="TRACESCI" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/illustration.svg') }}">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">A few more clicks to <br> sign in to your account.</div>
                <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Track your all invoices at one place</div>
            </div>
        </div>
        <!-- END: Login Info -->
        <!-- BEGIN: Login Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Sign In</h2>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                <div class="intro-x mt-8">
                    <form id="login-form">
                        <input id="email_or_phone" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Email or phone" value="">
                        <div id="error-email_or_phone" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                        <input id="password" type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Password" value="">
                        <div id="error-password" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                    </form>
                </div>
                <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                        <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                        <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                    </div>
                    <a href="{{ url('forgot-password') }}">Forgot Password?</a>
                </div>
                <div class="auth-tabs mt-4" style="margin-top:50px;">
                    <button id="btn-login" class="tab active">LOGIN</button>
                    <a href="{{ url('/register') }}" class="tab">REGISTER</a>
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
    var submitted = false

    cash(function() {
        async function login() {
            submitted = true
            // Reset state
            cash('#login-form').find('.login__input').removeClass('border-theme-6')
            cash('#login-form').find('.login__input-error').html('')

            // Post form
            let email_or_phone = cash('#email_or_phone').val()
            let password = cash('#password').val()
            let rememberMe = cash('#remember-me').val()

            // Loading state
            cash('#btn-login').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
            await helper.delay(500)

            axios.post("{{ url('/login')}}", {
                email_or_phone: email_or_phone,
                password: password,
                remember_me: rememberMe
            }).then(res => {
                submitted = false
                showNotification('success', 'Success !', res.data.message)
                setTimeout(() => {
                    window.location.href = res.data.url
                }, 2000)
            }).catch(err => {
                submitted = false
                showNotification('error', 'Error !', err.response.data.message)
                cash('#btn-login').html('Login')

                if (err.response.data.errors) {
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                }
            })
        }

        cash('#login-form').on('keyup', function(e) {
            if (e.keyCode === 13 && submitted == false) {
                login()
            }
        })

        cash('#btn-login').on('click', function() {
            if (submitted == false) {
                login()
            }
        })
    })
</script>
@endsection