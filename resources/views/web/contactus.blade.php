@extends('web.layouts.app')
@section('content')

<style>
    @media (max-width: 767px) {
        .aboout-1-head-area {
            background-image: url('/dist/images/contact_us_mobile.png');
            background-position: top center;
            background-size: cover;
            height: 100svh;
            /* svh = small viewport height, best for mobile */
        }
    }

    @media (max-width: 767px) {
        .page-title-area.aboout-1-head-area {
            display: flex;
            align-items: flex-end;
            /* pushes content to bottom */
            justify-content: center;
            padding-bottom: 50px;
        }

        .about-head-content {
            padding: 15px 20px;
        }
    }
</style>
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIINfQ3gYq6a1t9Wm3XbXgZ8j8pXk2Xq6Q="
    crossorigin="" />
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    crossorigin="">
<section class="page-title-area aboout-1-head-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="about-head-content">
                    <h2>Contact Us</h2>
                    <p>Feel free to contact us any time, we wanna hear from you!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="get_in_touch" class="contact-box padding-content content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="riven-heading text-center" data-sr="enter bottom wait 0.3s">
                    <h2><span>Get In</span> Touch</h2>
                    <p class="text">Feel free to discuss your project with us, we assure you best of support...</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="contact-info">
                    <ul>

                        <li class="icon_list_item">
                            <div class="icon_list_icon">
                                <h5><i class="fa fa-map-marker" aria-hidden="true"></i> Office </h5>
                            </div>
                            <b>Tracesci Global Pvt Ltd.,<br>
                                8B, "Chaitanya Exotica", 24 venkatnarayana Road,<br>
                                T. Nagar, Chennai, Tamil Nadu, India</b>
                        </li>
                        <li class="icon_list_item">
                            <div class="icon_list_icon">
                                <h5><i class="fa fa-building" aria-hidden="true"></i> Branch Offices</h5>
                            </div>
                            <ul style="margin:0; padding-left:20px;">
                                <li><b>Gurugram</b></li>
                                <li><b>Mumbai</b></li>
                            </ul>
                        </li>
                        <li class="icon_list_item">
                            <div class="icon_list_icon">
                                <h5><i class="fa fa-phone" aria-hidden="true"></i> Phone</h5>
                            </div>
                            <a href="callto:+911244226771">+91-44-28115-7928</a>
                            <a href="callto:+911244226771">+91-44-28115-7894</a>
                        </li>
                        <li class="icon_list_item">
                            <div class="icon_list_icon">
                                <h5><i class="fa fa-envelope" aria-hidden="true"> </i> Email</h5>
                            </div>

                            <a href="mailto:wecare@tracesci.in">wecare@tracesci.in</a>

                        </li>
                        <li>
                            <h5>Find us elsewhere</h5>
                            <ul class="social-networks">
                                <li class="social-fb first"><a href="https://www.facebook.com/tracesciSolutions/"><i class="fa fa-facebook"></i></a></li>
                                <li class="social-linkedin"><a href="https://in.linkedin.com/company/tracesci-solutions-pvt-ltd"><i class="fa fa-linkedin"></i></a></li>
                                <li class="social-youtube"><a href="https://www.youtube.com/@TracesciGlobal"><i class="fa fa-youtube-play"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="wpcf7">
                    <form id="#contact_form" class="wpcf7-form">
                        @csrf
                        <div class="contact-form">
                            <p class="inner-input mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                    Name
                                </label>
                                <span class="your-name">
                                    <input
                                        type="text"
                                        id="name"
                                        class="contact__input"
                                        name="name"
                                        required
                                        oninput="this.value = this.value.replace(/[^a-zA-Z\s.']/g, '')">
                                </span>
                            <div id="error-name" class="text-danger contact__input-error mb-3"></div>

                            </p>

                            <p class="inner-input mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
                                    Email
                                </label>
                                <span class="your-email"><input type="email" id="email" class="contact__input" name="email" required></span>
                            <div id="error-email" class="text-danger contact__input-error mb-3"></div>
                            </p>


                            <p class="inner-input mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-mobile">
                                    Mobile
                                </label>
                                <span class="your-mobile">
                                    <input
                                        type="number"
                                        id="mobile"
                                        name="mobile"
                                        class="contact__input"
                                        required
                                        oninput="if(this.value.length > 10) this.value = this.value.slice(0,10)">
                                </span>
                            <div id="error-mobile" class="text-danger contact__input-error mb-3"></div>
                            </p>

                            <p class="inner-input mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-message">
                                    Message
                                </label>
                                <span class="textarea"><textarea id="message" class="area contact__input" name="message" required></textarea></span>
                            <div id="error-message" class="text-danger contact__input-error mb-3"></div>

                            </p>
                            <div class="mb-3">
                                <div class="g-recaptcha"
                                    data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                </div>

                                <div id="error-captcha" class="text-danger"></div>
                            </div>
                            <p class="contact-submit"><button id="btn-contact" type="button" class="btn btn-default button" data-loading-text="Loading...">Submit</button></p>
                        </div>
                    </form>
                    <div class="alert alert-warning hidden" id="contactwait">
                        <strong>Please Wait!</strong>
                    </div>
                    <div class="alert alert-success hidden" id="contactSuccess">
                        <strong>Success!</strong> Your message has been sent to us.
                    </div>

                    <div class="alert alert-error p-0 hidden" id="contactError">
                        <strong>Error!</strong> There was an error sending your message.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer-90"></div>
</div>



<!-- Map -->
<div class="map-info map-contact">
    <div class="container-fluid no-padding">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">

                <div id="tracesci-map"
                    style="width:100%; height:450px; border:0;">
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    crossorigin="">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const map = L.map('tracesci-map', {
            scrollWheelZoom: false
        });

        L.tileLayer(
            'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 20
            }
        ).addTo(map);

        const locations = [{
                name: 'Tracesci Global Pvt Ltd - Gurugram',
                lat: 28.430362,
                lng: 77.010435,
                address: 'Gurugram, Haryana, India'
            },
            {
                name: 'Tracesci Global Pvt Ltd - Chennai',
                lat: 13.0827,
                lng: 80.2707,
                address: '8B, "Chaitanya Exotica", 24 Venkatnarayana Road, T. Nagar, Chennai, Tamil Nadu, India'
            },
            {
                name: 'Tracesci Global Pvt Ltd - Mumbai',
                lat: 19.0760,
                lng: 72.8777,
                address: 'Mumbai, Maharashtra, India'
            }
        ];

        const markers = [];

        locations.forEach(function(location) {

            const marker = L.marker([
                location.lat,
                location.lng
            ]).addTo(map);

            marker.bindPopup(`
                <div style="min-width:220px;">
                    <strong>
                        ${location.name}
                    </strong>
                    <br>
                    <span>
                        ${location.address}
                    </span>
                </div>
            `);

            markers.push(marker);
        });

        // Automatically position map to show all locations
        const group = L.featureGroup(markers);

        map.fitBounds(group.getBounds(), {
            padding: [40, 40]
        });

    });
</script>


<!-- Your existing contact form JavaScript -->
<script type="text/javascript">
    cash(function() {

        async function contact() {

            cash('.contact__input').removeClass('border-theme-6')
            cash('.contact__input-error').html('')
            cash('#contactError').addClass('hidden')
            cash('#error-captcha').html('')

            let name = cash('#name').val()
            let email = cash('#email').val()
            let mobile = cash('#mobile').val()
            let message = cash('#message').val()

            let captcha = grecaptcha.getResponse();

            if (!captcha) {
                cash('#error-captcha')
                    .html('Please verify that you are not a robot.')

                return false
            }

            cash('#contactwait').removeClass('hidden')

            axios.post("{{url('send_inquiry')}}", {
                name: name,
                email: email,
                mobile: mobile,
                message: message,
                'g-recaptcha-response': captcha
            }).then(res => {

                grecaptcha.reset()

                cash('#contactSuccess').removeClass('hidden')
                cash('#contactError').addClass('hidden')
                cash('#contactwait').addClass('hidden')

                setTimeout(() => {
                    window.location.reload()
                }, 3000)

            }).catch(err => {

                grecaptcha.reset()

                cash('#contactError').removeClass('hidden')
                cash('#contactSuccess').addClass('hidden')
                cash('#contactwait').addClass('hidden')

                cash('#btn-contact').html('Submit')

                if (err.response?.data?.errors) {

                    for (const [key, val] of Object.entries(
                            err.response.data.errors
                        )) {

                        cash(`#${key}`).addClass('border-theme-6')

                        cash(`#error-${key}`).html(val)
                    }
                }
            })
        }

        cash('#contact_form').on('keyup', function(e) {

            if (e.keyCode === 13) {
                contact()
            }

        })

        cash('#btn-contact').on('click', function() {
            contact()
        })

    })

    $('#mobile').on('input', function() {

        this.value = this.value
            .replace(/\D/g, '')
            .slice(0, 10);

    });
</script>

<script
    src="https://www.google.com/recaptcha/api.js"
    async
    defer>
</script>

@endsection