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
                <h2 class="intro-x px-2 font-bold text-2xl xl:text-3xl text-center xl:text-left">Sign Up</h2>
                <div class="intro-x mt-2 px-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                <div class="intro-x mt-8">
                    <form id="register-form">
                        @csrf

                        <div class="grid grid-cols-12">

                            <div class="input-form col-span-12 px-2 mt-2">
                                <input id="name" name="name" type="text" class="form-control form__input" placeholder="Your Name" value="">
                                <div id="error-name" class="login__input-error w-100 text-theme-6 mt-1 mb-2"></div>
                            </div>

                            <div class="input-form col-span-12 px-2 mt-2">
                                <input id="email" name="email" type="text" class="form-control form__input" placeholder="Email" value="">
                                <div id="error-email" class="login__input-error w-100 text-theme-6 mt-1 mb-2"></div>
                            </div>

                            <div class="input-form col-span-3 px-2 mt-2">
                                <select id="country_code" name="country_code" class="form-control form__input">
                                    @if (count(countries())>0)
                                    @foreach (countries() as $country)
                                    <option value="{{$country->phonecode}}" {{$country->phonecode=='91'?'selected':''}}>+{{$country->phonecode}}</option>
                                    @endforeach
                                    @else
                                    <option value="91">91</option>
                                    @endif
                                </select>
                                <div id="error-country_code" class="login__input-error w-100 text-theme-6 mt-1 mb-2"></div>
                            </div>

                            <div class="input-form col-span-9 px-2 mt-2">
                                <input id="mobile" name="mobile" type="text" class="form-control form__input" placeholder="Mobile" value="" minlength="6" maxlength="12">
                                <div id="error-mobile" class="login__input-error w-100 text-theme-6 mt-1 mb-2"></div>
                            </div>

                        </div>

                    </form>
                </div>

                <div class="intro-x mt-3 xl:mt-4 text-center xl:text-left px-2">
                    <button id="btn-signup" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Next</button>
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
        async function register() {

            cash('#register-form').find('.form__input').removeClass('border-theme-6')
            cash('#register-form').find('.login__input-error').html('')

            var formData = new FormData(document.querySelector('#register-form'))


            cash('#btn-signup').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
            await helper.delay(500)

            axios.post(`{{url('/register')}}`, formData).then(res => {

                showNotification('success','Success !',res.data.message)
                setTimeout(()=>{
                    window.location.href = '{{ url('/register/company-informations') }}'
                },2000)

            }).catch(err => {
                showNotification('error','Error !',err.response.data.message)
                cash('#btn-signup').html('Next')                   

                if (err.response.data.errors) {
                    for (const [key, val] of Object.entries(err.response.data.errors)){
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                }

            })
        }

        cash('#register-form').on('keyup', function(e) {
            if (e.keyCode === 13) {
                register()
            }
        })

        cash('#btn-signup').on('click', function() {
            register()
        })
    })
</script>
@endsection