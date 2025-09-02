@extends('admin.layout.' . $layout)

@section('subhead')
<title>Profile - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Update Profile</h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                <div class="mr-auto">
                    <div class="font-medium text-base">{{Auth::user()->name}}</div>
                </div>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="javascript:void(0);">
                    <i data-feather="at-sign" class="w-4 h-4 mr-2"></i> {{Auth::user()->email??''}}
                </a>
                <a class="flex items-center mt-5" href="javascript:void(0);">
                    <i data-feather="phone-call" class="w-4 h-4 mr-2"></i> {{Auth::user()->phone??''}}
                </a>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">

        <form id="update-form">
            @csrf
            <div class="intro-y box mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Personal Information</h2>
                    <a href="{{url('admin/change-password')}}" class="ml-auto btn btn-primary">Change Password</a>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 xl:col-span-6">

                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="text" class="form-control form__input" readonly="" placeholder="Enter email" value="{{Auth::user()->email}}">
                            <div id="error-email" class="login__input-error w-5/6 text-theme-6"></div>

                        </div>

                        <div class="col-span-12 xl:col-span-6 mt-4 lg:mt-0">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input id="mobile" type="text" name="mobile" class="form-control form__input" placeholder="Enter mobile" value="{{Auth::user()->phone}}" minlength="10" maxlength="10">
                            <div id="error-mobile" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 xl:col-span-6 mt-4">
                            <label for="name" class="form-label">
                                Full name
                            </label>
                            <input id="name" type="text" value="{{Auth::user()->name}}" name="name" class="form-control form__input" placeholder="Enter full name" minlength="2">
                            <div id="error-name" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>
                        <div class="col-span-12 xl:col-span-6 mt-4">
                            <label for="password" class="form-label">
                                Password
                            </label>
                            <input id="password" type="password" value="" name="password" class="form-control form__input" placeholder="Enter New Password" minlength="2">
                            <div id="error-password" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="gender" class="form-label">
                                Gender
                            </label>
                            <select id="gender" type="text" name="gender" class="form-select form__input">
                                <option value="m" {{Auth::user()->gender=='m'?'selected':''}}>Male</option>
                                <option value="f" {{Auth::user()->gender=='f'?'selected':''}}>Female</option>
                                <option value="u" {{Auth::user()->gender=='u'?'selected':''}}>Unspecified</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>

            @if (hasRoutePermission('admin-update-profile',Auth::id()))
            <div class="intro-y box mt-5">
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 mt-5">
                            <div class="flex justify-start">
                                <button type="button" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update profile</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            @endif
        </form>
    </div>
    <x-notification></x-notification>
</div>
@endsection

@section('script')
<script>
    cash(function () {
        async function add() {

            cash('#update-form').find('.form__input').removeClass('border-theme-6')
            cash('#update-form').find('.login__input-error').html('')

            var formData = new FormData(document.querySelector('#update-form'))

            cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
            // await helper.delay(500)

            axios.post('{{ route('admin-update-profile') }}', formData).then(res => {
                // cash('#btn-update').attr('disabled', 'true');
                showNotification('success','Success !',res.data.message)
                setTimeout(()=>{
                    window.location.reload();
                },1000)

            }).catch(err => {
                showNotification('error','Error !',err.response.data.message)
                cash('#btn-update').html('Update profile')                   

                if (err.response.data.errors) {
                    for (const [key, val] of Object.entries(err.response.data.errors)){
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                }

            })
        }

        cash('#update-form').on('keyup', function(e) {
            if (e.keyCode === 13) {
                add()
            }
        })

        cash('#btn-update').on('click', function() {
            add()
        })
    })
</script>
@endsection