@extends('web.layouts.app')
@section('content')
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
                            Tracesci Pvt Ltd.,<br>
                            B-15, InfoCity Phase 1, Sector 34,<br>
                            Gurugram-122001, Haryana, India

                        </li>
                        <li class="icon_list_item">
                            <div class="icon_list_icon">
                                <h5><i class="fa fa-phone" aria-hidden="true"></i> Phone</h5>
                            </div>

                            <a href="callto:+911244226771">+91-124-422-6771</a>
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
                                <li class="social-fb first"><a href="https://www.facebook.com/jetsciglobal/"><i class="fa fa-facebook"></i></a></li>
                                <li class="social-linkedin"><a href="https://www.linkedin.com/company/jetsciglobal"><i class="fa fa-linkedin"></i></a></li>
                                <li class="social-youtube"><a href="https://www.youtube.com/channel/UCDnSaAwRgBssFuTUX_2iCJw"><i class="fa fa-youtube-play"></i></a></li>
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
                                <span class="your-name"><input type="text" id="name" class="contact__input" name="name" required></span>
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
                                <span class="your-mobile"><input type="text" id="mobile" class="contact__input" name="mobile" required></span>
                            <div id="error-mobile" class="text-danger contact__input-error mb-3"></div>
                            </p>

                            <p class="inner-input mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-message">
                                    Message
                                </label>
                                <span class="textarea"><textarea id="message" class="area contact__input" name="message" required></textarea></span>
                            <div id="error-message" class="text-danger contact__input-error mb-3"></div>

                            </p>

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
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3508.631880488345!2d77.01043561507808!3d28.430362582498017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d181b33427c19%3A0x1d7f2dae6742eec3!2sJETSCI%C2%AE%20Global!5e0!3m2!1sen!2sin!4v1625823933261!5m2!1sen!2sin" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection