@extends('vendor.layout.' . $layout)

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
                    <div class="text-gray-600">{{Auth::user()->getCompany?Auth::user()->getCompany->name:''}}</div>
                </div>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="javascript:void(0);">
                    <i data-feather="at-sign" class="w-4 h-4 mr-2"></i> {{Auth::user()->email??''}}
                </a>
                <a class="flex items-center mt-5" href="javascript:void(0);">
                    <i data-feather="phone-call" class="w-4 h-4 mr-2"></i> {{Auth::user()->phone??''}}
                </a>
                <a class="flex items-center mt-5" href="javascript:void(0);">
                    <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> {{Auth::user()->address_one??''}}
                </a>
                <a class="flex items-center mt-5" href="javascript:void(0);">
                    <i data-feather="calendar" class="w-4 h-4 mr-2"></i> Member since : {{date('M d, Y',strtotime(Auth::user()->created_at))}}
                </a>
            </div>

            @if (count(Auth::user()->getAllDocs)>0)
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <h6 class="text-sm font-medium mr-auto mb-4">Uploaded documents</h6>
                @foreach (Auth::user()->getAllDocs as $doc)
                <a class="flex items-center mb-5" title="{{$doc->status=='1'?'Approved':'Pending approval'}}" href="{{$doc->doc_url}}" download="">
                    <i data-feather="download" class="w-4 h-4 mr-2"></i> {{$doc->name}} <i data-feather="{{$doc->status=='1'?'check-square':'x-square'}}" class="w-4 h-4 ml-2 {{$doc->status=='1'?'text-green-600':'text-red-600'}}"></i>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">

        <form id="update-form">
            @csrf
            <div class="intro-y box mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Personal Information</h2>
                    <a href="{{url('vendor/change-password')}}" class="ml-auto btn btn-primary">Change Password</a>
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

            <div class="intro-y box mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Company Information</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="company_name" class="form-label">
                                Company name
                            </label>
                            <input id="company_name" type="text" value="{{Auth::user()->getCompany?Auth::user()->getCompany->name:''}}" name="company_name" class="form-control form__input" placeholder="Enter company name">
                            <div id="error-company_name" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="company_address" class="form-label">
                                Company address
                            </label>
                            <input id="company_address" type="text" value="{{Auth::user()->getCompany?Auth::user()->getCompany->address:''}}"  name="company_address" class="form-control form__input" placeholder="Enter company address">
                            <div id="error-company_address" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="company_cin" class="form-label">
                                Company CIN
                            </label>
                            <input id="company_cin" type="text" value="{{Auth::user()->getCompany?Auth::user()->getCompany->cin:''}}" name="company_cin" class="form-control form__input" placeholder="Enter company cin" maxlength="21">
                            <div id="error-company_cin" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="company_gst_no" class="form-label">
                                Company GST
                            </label>
                            <input id="company_gst_no" type="text" value="{{Auth::user()->getCompany?Auth::user()->getCompany->gst:''}}" name="company_gst_no" class="form-control form__input" placeholder="Enter company gst" maxlength="15">
                            <div id="error-company_gst_no" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="intro-y box mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Payment Gateway Information</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">

                        <div class="col-span-12 lg:col-span-12">
                            <label for="payment_gateway" class="form-label">
                                Payment Gateway
                            </label>
                            <select id="payment_gateway" type="text" name="payment_gateway" class="form-select form__input">
                                <option value="razorpay" {{Auth::user()->payment_gateway=='razorpay'?'selected':''}}>Razorpay</option>
                            </select>
                        </div>

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="payment_gateway_id" class="form-label">
                                Payment Gateway Id
                            </label>
                            <input id="payment_gateway_id" type="text" value="{{Auth::user()->payment_gateway_id??''}}" name="payment_gateway_id" class="form-control form__input" placeholder="Enter id">
                            <div id="error-payment_gateway_id" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 lg:col-span-6 mt-4">
                            <label for="payment_gateway_token" class="form-label">
                                Payment Gateway Token
                            </label>
                            <input id="payment_gateway_token" type="text" value="{{Auth::user()->payment_gateway_token??''}}" name="payment_gateway_token" class="form-control form__input" placeholder="Enter token">
                            <div id="error-payment_gateway_token" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>                        

                    </div>

                </div>
            </div>

            <div class="intro-y box mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Documents</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 xl:col-span-6 mb-4">
                            <label for="self_kyc" class="form-label">
                                Self KYC
                            </label>
                            <input id="self_kyc" type="file" name="self_kyc" class="form-control form__input">
                            <div id="error-self_kyc" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 xl:col-span-6 mb-4">
                            <label for="company_roc" class="form-label w-full flex flex-col sm:flex-row">
                                Company ROC
                            </label>
                            <input id="company_roc" type="file" name="company_roc" class="form-control form__input">
                            <div id="error-company_roc" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 xl:col-span-6">
                            <label for="company_gst" class="form-label w-full flex flex-col sm:flex-row">
                                Company GST certificate
                            </label>
                            <input id="company_gst" type="file" name="company_gst" class="form-control form__input">
                            <div id="error-company_gst" class="login__input-error w-5/6 text-theme-6"></div>
                        </div>

                        <div class="col-span-12 mt-5">
                            <div class="flex justify-start">
                                <button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update profile</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
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
            cash('#btn-update').attr('disabled', 'true');   
            

            axios.post('{{ route('vendor-update-profile') }}', formData).then(res => {
                showNotification('success','Success !',res.data.message)
                setTimeout(()=>{
                    window.location.reload();
                },1000)

            }).catch(err => {
                showNotification('error','Error !',err.response.data.message)
                cash('#btn-update').html('Update profile')   
                cash('#btn-update').removeAttr('disabled');
                if (err.response.data.errors) {
                    for (const [key, val] of Object.entries(err.response.data.errors)){
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                }

            })
        }

        cash('#update-form').on('submit', function(e) {
            e.preventDefault();
            add();
        })
    })
</script>
@endsection