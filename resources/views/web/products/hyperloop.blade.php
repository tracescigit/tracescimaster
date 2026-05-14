@extends('web.layouts.app')
@section('content')

<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --black: #0a0a0a;
        --white: #ffffff;
        --off-white: #f7f6f3;
        --navy: #000000;
        --teal: #7a0d7d;
        --teal-light: #e6faf8;
        --gray: #f0efeb;
        --text: #1a1a1a;
        --muted: #6b7280;
        --border: #e5e5e5;
        --nav-h: 76px;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Lora', serif;
        font-size: 16px;
        color: var(--text);
        background: var(--white);
        overflow-x: hidden;
    }

    /* ── NAV ── */
    nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: var(--nav-h);
        background: var(--white);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 56px;
        z-index: 200;
    }

    .nav-logo img {
        height: 32px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 8px;
        list-style: none;
    }

    .nav-links a {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: var(--text);
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.04em;
        text-transform: lowercase;
        padding: 8px 14px;
        border-radius: 4px;
        transition: background 0.2s, color 0.2s;
    }

    .nav-links .wave {
        width: 16px;
        opacity: 0.4;
    }

    .nav-links a:hover {
        background: var(--gray);
    }

    .nav-cta {
        background: var(--teal) !important;
        color: var(--white) !important;
        padding: 10px 22px !important;
        border-radius: 4px;
        font-weight: 600 !important;
    }

    .nav-cta:hover {
        background: #00a890 !important;
    }

    /* ── HERO ── */
    #hero {
        min-height: 100vh;
        padding-top: var(--nav-h);
        background: var(--navy);
        color: var(--white);
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-left {
        padding: 80px 56px 80px 56px;
        z-index: 2;
    }

    .hero-tagline {
        font-family: 'Lora', serif;
        font-size: clamp(52px, 7vw, 70px);
        font-weight: 800;
        line-height: 1.2;
        text-transform: uppercase;
        margin-bottom: 40px;
    }

    .tagline-child {
        font-size: clamp(52px, 7vw, 20px);
    }

    .hero-word-rotate {
        color: var(--teal);
        display: inline-block;
        font-size: clamp(52px, 7vw, 20px);
        position: relative;
        min-width: 280px;
    }

    .hero-subtitle {
        font-family: 'Lora', serif;
        font-size: clamp(20px, 2.5vw, 32px);
        font-weight: 500;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.3;
        margin-bottom: 6px;
    }

    .hero-body {
        font-size: 15px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.65);
        max-width: 480px;
        margin-bottom: 48px;
    }

    .hero-ctas {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        letter-spacing: 0.02em;
    }

    .btn-primary {
        background: var(--teal);
        color: var(--white);
    }

    .btn-primary:hover {
        background: #00a890;
    }

    .btn-ghost {
        background: transparent;
        color: var(--white);
        border: 1.5px solid rgba(255, 255, 255, 0.3);
    }

    .btn-ghost:hover {
        border-color: var(--teal);
        color: var(--teal);
    }

    .hero-right {
        position: relative;
        height: 100%;
        min-height: 500px;
    }

    .hero-right img.hero-photo {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
    }

    .scroll-indicator {
        position: absolute;
        bottom: 36px;
        left: 56px;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 5;
    }

    .scroll-arrow {
        width: 28px;
        height: 28px;
        border: 1.5px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: bounce 2s infinite;
    }

    .scroll-arrow svg {
        width: 12px;
        height: 12px;
        stroke: white;
        fill: none;
        stroke-width: 2.5;
        opacity: 0.5;
    }

    .scroll-indicator span {
        font-size: 10px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.3);
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(6px);
        }
    }

    /* ── MARQUEE STRIP ── */
    #marquee-strip {
        background: var(--teal);
        padding: 14px 0;
        overflow: hidden;
        white-space: nowrap;
    }

    .marquee-track {
        display: inline-block;
        animation: marquee 22s linear infinite;
        font-family: 'Lora', serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--white);
    }

    .marquee-track span {
        margin: 0 36px;
        opacity: 0.7;
    }

    .marquee-track .sep {
        opacity: 0.4;
        margin: 0 16px;
    }

    @keyframes marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    /* ── SECTION SHARED ── */
    section {
        padding: 0 56px 100px 56px;
    }

    .section-heading {
        font-family: 'Lora', serif;
        font-size: 28px;
        font-weight: bold;
        line-height: 1.05;
        color: var(--navy);
        margin-bottom: 20px;
    }

    .section-heading .highlight {
        color: var(--teal);
    }

    .section-sub {
        font-size: 17px;
        line-height: 1.75;
        color: var(--muted);
        margin-bottom: 48px;
        text-align: center;
    }

    /* ── SOLUTIONS GRID ── */
    .solutions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2px;
        background: var(--border);
        border: 1px solid var(--border);
        margin-top: 12px;
    }

    .solution-card {
        background: var(--white);
        padding: 40px 36px 44px;
        transition: background 0.2s;
        position: relative;
        overflow: hidden;
    }

    .solution-card:hover {
        background: var(--teal-light);
    }

    .solution-card:hover .sol-num {
        color: var(--teal);
    }

    .sol-num {
        font-family: 'Lora', serif;
        font-size: 48px;
        font-weight: 800;
        color: #f0efeb;
        line-height: 1;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .sol-icon {
        width: 44px;
        height: 44px;
        background: var(--teal-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .sol-icon svg {
        width: 22px;
        height: 22px;
        stroke: var(--teal);
        fill: none;
        stroke-width: 1.8;
    }

    .sol-title {
        font-family: 'Lora', serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .sol-body {
        font-size: 13px;
        line-height: 1.75;
        color: var(--muted);
    }

    /* ── ANCILLARY / APPLICATIONS ── */
    #ancillary {
        background: var(--white);
    }

    .ancillary-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        gap: 14px;
    }

    .ancillary-item {
        background: var(--off-white);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 18px 20px;
        transition: border-color 0.2s, background 0.2s;
    }

    .ancillary-item:hover {
        border-color: var(--teal);
        background: var(--teal-light);
    }

    .anc-icon {
        width: 36px;
        height: 36px;
        background: var(--white);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border: 1px solid var(--border);
    }

    .anc-icon svg {
        width: 18px;
        height: 18px;
        stroke: var(--teal);
        fill: none;
        stroke-width: 1.8;
    }

    .anc-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.4;
    }

    .anc-note {
        font-size: 10px;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ── TECH SPECS ── */
    #specs {
        background: var(--off-white);
    }

    .tech-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        margin-top: 48px;
    }

    .specs-table {
        background: var(--white);
        border: 1px solid var(--border);
        width: 100%;
    }

    .specs-table-header {
        background: #222222;
        padding: 18px 28px;
        font-family: 'Lora', serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.7);
    }

    .spec-row {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        border-bottom: 1px solid var(--border);
    }

    .spec-row:last-child {
        border-bottom: none;
    }

    .spec-key {
        padding: 14px 28px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--muted);
        border-right: 1px solid var(--border);
        background: #fafafa;
    }

    .spec-val {
        padding: 14px 28px;
        font-size: 13px;
        color: var(--navy);
        font-weight: 500;
        line-height: 1.5;
    }

    .spec-val .highlight {
        color: var(--teal);
        font-weight: 700;
    }

    /* ── WORKING ENVIRONMENT ── */
    #different {
        background: rgb(34, 34, 34);
        color: var(--white);
        align-items: center;
    }

    #different .section-heading {
        color: var(--white);
    }

    .different_section {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .env-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 48px;
    }

    .env-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid #222222;
        border-radius: 12px;
        padding: 36px 30px;
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    .env-card:hover {
        border-color: var(--teal);
        background: var(--teal-light);
    }

    .env-icon {
        width: 48px;
        height: 48px;
        background: var(--teal-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .env-icon svg {
        width: 24px;
        height: 24px;
        stroke: var(--teal);
        fill: none;
        stroke-width: 1.8;
    }

    .env-title {
        font-family: 'Lora', serif;
        font-size: 18px;
        font-weight: 700;
        color: #222222;
        margin-bottom: 8px;
    }

    .env-body {
        font-size: 13px;
        line-height: 1.75;
        color: #222222;
    }

    .env-value {
        font-family: 'Lora', serif;
        font-size: 28px;
        font-weight: 800;
        color: #222222;
        margin-bottom: 4px;
    }

    /* ── CONTACT ── */
    #contact {
        background: var(--white);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: start;
    }

    .contact-photo {
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .contact-photo img {
        width: 100%;
        display: block;
    }

    .contact-info {
        padding-top: 8px;
    }

    .contact-tagline {
        font-family: 'Lora', serif;
        font-size: clamp(28px, 3vw, 44px);
        font-weight: 800;
        color: var(--navy);
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
    }

    .contact-tagline span {
        color: var(--teal);
    }

    .contact-body {
        font-size: 15px;
        line-height: 1.8;
        color: var(--muted);
        margin-bottom: 36px;
    }

    .contact-highlights {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-highlight {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 14px;
        color: var(--navy);
        font-weight: 500;
    }

    .ch-dot {
        width: 8px;
        height: 8px;
        background: var(--navy);
        border-radius: 50%;
        flex-shrink: 0;
    }

    .product_demo {
        background: #ffffff;
        padding: 120px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .product_demo::before {
        content: "";
        position: absolute;
        width: 700px;
        height: 700px;
        border-radius: 50%;
        background: radial-gradient(rgba(255, 255, 255, 0.08), transparent 70%);
        top: -320px;
        left: -180px;
        animation: floatGlow 10s ease-in-out infinite;
    }

    .product_demo::after {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(rgba(255, 255, 255, 0.05), transparent 70%);
        bottom: -220px;
        right: -140px;
        animation: floatGlow 12s ease-in-out infinite;
    }

    .product_demo .container {
        position: relative;
        z-index: 2;
    }

    .demo-badge {
        display: inline-block;
        background: #fff;
        border: 1px solid #000000;
        color: #000000;
        padding: 10px 22px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 30px;
        backdrop-filter: blur(8px);
        animation: fadeUp 0.8s ease;
    }

    .product_demo h2 {
        color: #000000;
        font-weight: 800;
        font-size: 52px;
        line-height: 1.15;
        margin-bottom: 24px;
        position: relative;
        animation: fadeUp 1s ease;
        letter-spacing: -1px;
    }

    .product_demo p {
        color: #000000;
        font-size: 18px;
        line-height: 1.9;
        max-width: 760px;
        margin: 0 auto 45px;
        animation: fadeUp 1.2s ease;
    }

    .demo-actions {
        animation: fadeUp 1.4s ease;
    }

    .product_demo .enterprise-btn {
        background: #fff;
        color: #7a0d7d !important;
        font-weight: 700;
        font-size: 16px;
        padding: 18px 42px;
        display: inline-flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        transition: all 0.35s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
    }

    .product_demo .enterprise-btn::before {
        content: "";
        position: absolute;
        width: 0%;
        height: 100%;
        left: 0;
        top: 0;
        background: #7a0d7d;
        transition: width 0.4s ease;
        z-index: -1;
    }

    .product_demo .enterprise-btn:hover::before {
        width: 100%;
    }

    .product_demo .enterprise-btn:hover {
        color: #fff !important;
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 22px 45px rgba(0, 0, 0, 0.35);
    }

    .product_demo .enterprise-btn i {
        transition: 0.35s ease;
    }

    .product_demo .enterprise-btn:hover i {
        transform: translateX(7px);
    }


    @keyframes floatGlow {
        0% {
            transform: translateY(0px) translateX(0px);
        }

        50% {
            transform: translateY(25px) translateX(18px);
        }

        100% {
            transform: translateY(0px) translateX(0px);
        }
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(35px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media(max-width:768px) {

        .product_demo {
            padding: 90px 20px;
        }

        .product_demo h2 {
            font-size: 36px;
        }

        .product_demo p {
            font-size: 16px;
        }

        .product_demo .enterprise-btn {
            padding: 16px 30px;
            font-size: 15px;
        }
    }


    /* ── REVEAL ── */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .reveal.visible {
        opacity: 1;
        transform: none;
    }

    /* ── MOBILE ── */
    @media (max-width: 960px) {
        nav {
            padding: 0 24px;
        }

        .nav-links {
            display: none;
        }

        section {
            padding: 72px 24px;
        }

        #hero {
            grid-template-columns: 1fr;
        }

        .hero-left {
            padding: 60px 24px;
        }

        .hero-right {
            display: none;
        }

        .solutions-grid {
            grid-template-columns: 1fr;
        }

        #contact {
            grid-template-columns: 1fr;
            gap: 40px;
            padding: 60px 24px;
        }

        .tech-grid,
        .env-grid {
            grid-template-columns: 1fr;
        }

        .ancillary-grid {
            grid-template-columns: 1fr 1fr;
        }

        footer {
            padding: 40px 24px;
        }

        .footer-top {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<!-- ── REVOLUTION SLIDER ── -->
<div class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
        <ul>

            <!-- SLIDE 1 -->
            <li data-index="rs-1" data-transition="parallaxtoright" data-delay="6500">
                <img src="{{asset('dist/images/hyperloop-slide1.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <span class="sl-italic" style="transition:none;line-height:28px;border-width:0;margin:0;padding:0;letter-spacing:0;font-weight:400;font-size:17px;">
                        Slit. Inspect. Print. All in one loop.
                    </span>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="text-center heading-rp-small" style="transition:none;line-height:58px;border-width:0;margin:0;padding:0;letter-spacing:1px;font-weight:800;font-size:50px;">
                        HYPERLOOP<br><span style="color:#7a0d7d">Inline</span> Finishing System
                    </div>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="sl-italic sl-italic-2 text-center" style="transition:none;line-height:48px;border-width:0;margin:0;padding: 20px;;letter-spacing:0;font-weight:400;font-size:17px;">
                        Variable Data Printing • High Speed Inspection • Automated Digital Slitting<br>
                        Up to 200 m/min — Models 330 &amp; 450
                    </div>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="430"
                    data-start="2800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="rev-slider-btn text-center">
                        <a href="{{ url(Auth::check() ? myDashboard() : '/login') }}">Login</a>
                        <a href="{{ url(Auth::check() ? myDashboard() : '/register') }}">Register</a>
                    </div>
                </div>
            </li>

            <!-- SLIDE 2 -->
            <li data-index="rs-2" data-transition="parallaxtoright" data-delay="6500">
                <img src="{{asset('dist/images/hyperloop-slide2.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <span class="sl-italic" style="transition:none;line-height:28px;border-width:0;margin:0;padding:0;letter-spacing:0;font-weight:400;font-size:17px;">
                        Zero defects. Zero escapes.
                    </span>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="text-center heading-rp-small" style="transition:none;line-height:58px;border-width:0;margin:0;padding:0;letter-spacing:1px;font-weight:800;font-size:50px;">
                        100% Online Vision <span style="color:#7a0d7d">Inspection</span>
                    </div>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="sl-italic sl-italic-2 text-center" style="transition:none;line-height:28px;border-width:0;margin:0;padding:0;letter-spacing:0;font-weight:400;font-size:17px;">
                        0.15 mm resolution • 250 m/min top speed<br>
                        1D/2D/QR, OCR/ICV, defect detection &amp; inspection reports
                    </div>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="430"
                    data-start="2800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="rev-slider-btn text-center">
                        <a href="#">Read More</a>
                        <a href="#">Get Started</a>
                    </div>
                </div>
            </li>

            <!-- SLIDE 3 -->
            <li data-index="rs-3" data-transition="parallaxtoright" data-delay="6500">
                <img src="{{asset('dist/images/hyperloop-slide3.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <span class="sl-italic" style="transition:none;line-height:28px;border-width:0;margin:0;padding:0;letter-spacing:0;font-weight:400;font-size:17px;">
                        VDP • Track &amp; Trace • Authentication
                    </span>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="text-center heading-rp-small" style="transition:none;line-height:58px;border-width:0;margin:0;padding:0;letter-spacing:1px;font-weight:800;font-size:50px;">
                        Automated Digital <span style="color:#7a0d7d">Slitting</span>
                    </div>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="sl-italic sl-italic-2 text-center" style="transition:none;line-height:28px;border-width:0;margin:0;padding:0;letter-spacing:0;font-weight:400;font-size:17px;">
                        Up to 150 m/min • 9-blade digital positioning by HMI<br>
                        Dual web guide • Dual rewinder • Label transfer device
                    </div>
                </div>
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="430"
                    data-start="2800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="rev-slider-btn text-center">
                        <a href="#">Read More</a>
                        <a href="#">Get Started</a>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</div>

<!-- ── CORE SOLUTIONS ── -->
<div class="solution-area" style="background-color: #f5f5f5;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Core <span>Solutions</span></h2>
                    </div>
                    <h2>Core<span style="color:#7a0d7d"> Solutions</span></h2>
                    <h3>Four integrated solutions for modern label and packaging production — from variable data printing and inspection to digital slitting and label transfer.</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="solution-content" style="margin-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Variable Data Printing</h2>
                        <p>Powered by tracesci VDP software — print barcodes, QR codes, serial numbers, dates, counters, and custom graphics inline at full production speed. Printheads can be combined arbitrarily with multiple documents printed simultaneously for complete traceability...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>High Speed Vision Inspection</h2>
                        <p>100% online inspection at up to 250 m/min. Detects scratches, stains, de-ink, foreign particles, colour deviations, and logo errors. Reads 1D/2D/QR and security codes with full OCR/ICV verification and automated inspection report generation...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Automated Digital Slitting</h2>
                        <p>9-blade digitally positioned slitting at up to 150 m/min with automatic blade positioning via HMI — no manual changeover required. Integrated QC defect-removal plate ensures only perfect rolls leave the line...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Dual Rewinder &amp; Web Guide</h2>
                        <p>Dual rewinder with integrated dual web guide (one unit after unwinder, one before slitting) ensures perfect tension-controlled rewinding and precise roll geometry — eliminating edge misalignment at any speed...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Label Transfer Device</h2>
                        <p>Inline label transfer device enables seamless reel changeover and label repositioning without stopping production, maximising uptime across continuous manufacturing runs in pharma, packaging, and security applications...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Track &amp; Trace Integration</h2>
                        <p>End-to-end serialisation and authentication from the tracesci platform — uniquely identify every item across the supply chain. Supports full product authentication, anti-counterfeiting, and compliance workflows with centrally controlled print management...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Puzzle"></i></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="all-link solution-btn text-center">
                        <a href="#">More Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── TECHNICAL SPECIFICATIONS ── -->
    <section id="different" style="background-color: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="main-title wow zoomIn">
                        <div class="main-shadow-heading">
                            <h2>Technical Specifications</h2>
                        </div>
                        <h2>Technical <span style="color:#7a0d7d">Specifications</span></h2>
                        <h3>Unwinder · Dual Rewinder · Automated Digital Slitting — 9-blade HMI positioning at up to 200 m/min.</h3>
                    </div>
                    <h3 style="color: #0a0a0a;">Hyperloop 330 / 450 Spec Sheet</h3>
                </div>
            </div>
        </div>

        <div class="tech-grid">

            <!-- Slitting & Web -->
            <div class="reveal">
                <div class="specs-table">
                    <div class="specs-table-header">Slitting &amp; Web Handling</div>
                    <div class="spec-row">
                        <div class="spec-key">Model</div>
                        <div class="spec-val">Hyperloop <span class="highlight">330 / 450</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Model Type</div>
                        <div class="spec-val">Unwinder, Dual Rewinder, Automated Digital Slitting</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Web Feed Width</div>
                        <div class="spec-val">Max <span class="highlight">330 mm / 450 mm</span>, Min 20 mm</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Slitting Speed</div>
                        <div class="spec-val">Up to <span class="highlight">150 m/min</span><br>
                            <span style="font-size:11px;color:var(--muted)">Subject to substrate type — 9 pcs blade</span>
                        </div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Running Speed</div>
                        <div class="spec-val">Up to <span class="highlight">200 m/min</span><br>
                            <span style="font-size:11px;color:var(--muted)">Subject to substrate type</span>
                        </div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Positioning</div>
                        <div class="spec-val">Blade positioning automatic digitally by HMI</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">QC Area</div>
                        <div class="spec-val">Quality Control or defect removal plate</div>
                    </div>
                </div>
            </div>

            <!-- Web Guide & Mechanical -->
            <div class="reveal" style="transition-delay:0.1s">
                <div class="specs-table">
                    <div class="specs-table-header">Web Guide &amp; Mechanical</div>
                    <div class="spec-row">
                        <div class="spec-key">Web Guide</div>
                        <div class="spec-val"><span class="highlight">Dual</span> — 1 unit after unwinder, 1 unit before slitting to ensure perfect rewinding</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Max Roll Weight</div>
                        <div class="spec-val">Approx. <span class="highlight">120 kg</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Dimensions</div>
                        <div class="spec-val">2330 × 1300 × 1500 mm</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Electrical</div>
                        <div class="spec-val"><span class="highlight">220–240 V</span>, 3 KW</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Control</div>
                        <div class="spec-val">Touch Screen Panel</div>
                    </div>
                </div>
            </div>

            <!-- Vision System -->
            <div class="reveal" style="transition-delay:0.2s">
                <div class="specs-table">
                    <div class="specs-table-header">Vision System</div>
                    <div class="spec-row">
                        <div class="spec-key">H. Resolution</div>
                        <div class="spec-val"><span class="highlight">0.15 mm</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">V. Resolution</div>
                        <div class="spec-val"><span class="highlight">0.15 mm</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Detection Width</div>
                        <div class="spec-val"><span class="highlight">10 – 1500 mm</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Top Speed</div>
                        <div class="spec-val"><span class="highlight">250 m/min</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Point Defect</div>
                        <div class="spec-val">Area &gt; 0.2 mm²</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Streak Defect</div>
                        <div class="spec-val">Area &gt; 0.1 mm · 5 mm</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Registration</div>
                        <div class="spec-val">H &gt; 0.15 mm | V &gt; 0.25 mm</div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- ── SUITED BEST FOR ── -->
<section class="feature-area feature-2-area" style="background-color: #f5f5f5;">
    <div class="feature-heading-area wow zoomIn">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="feature-heading-left">
                        <h2 style="color: #7a0d7d; font-weight: bold">Built for speed &amp; precision finishing</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-heading-right">
                        <p>The Hyperloop is engineered to deliver exceptional throughput at up to 200 m/min without sacrificing slitting accuracy or inspection integrity — even in high-demand continuous production environments across label, packaging, pharma, and security substrates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-2-area">
        <div class="feature-2-right wow fadeInRight"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <ul class="feature-2-left wow fadeInDown">
                        <li>
                            <h2><span></span>Suited Best For :</h2>
                        </li>
                        <li>
                            <h3><span><i class="icon icon-FileBox"></i></span>Paper &amp; Coated</h3>
                        </li>

                        <li>
                            <h3><span><i class="icon icon-Layers"></i></span>Plastics &amp; PVC</h3>
                        </li>

                        <li>
                            <h3><span><i class="icon icon-Tag"></i></span>Labels &amp; Flexible Packaging</h3>
                        </li>

                        <li>
                            <h3><span><i class="icon icon-Heart"></i></span>Pharma &amp; Healthcare Packaging</h3>
                        </li>

                        <li>
                            <h3><span><i class="icon icon-Key"></i></span>Secure Substrates</h3>
                        </li>

                        <li>
                            <h3><span><i class="icon icon-Cup"></i></span>Beverage &amp; Food Packaging</h3>
                        </li>

                        <li>
                            <h3><span><i class="icon icon-File"></i></span>Cartons &amp; Folding Boxes</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── INDUSTRY WIDE APPLICATIONS ── -->
<section id="ancillary">
    <div class="reveal" style="text-align:center; padding: 30px">
        <div class="main-title wow zoomIn">
            <div class="main-shadow-heading">
                <h2>Industry Wide <span>Applications</span></h2>
            </div>
            <h2>Industry Wide<span style="color:#7a0d7d"> Applications</span></h2>
            <h3 class="section-heading">Complete coverage across <span class="highlight">every sector</span></h3>
            <p class="section-sub">From pharmaceutical serialisation to beverage packaging authentication — configure the Hyperloop for the traceability and quality demands of any production environment.</p>
        </div>
    </div>

    <div class="ancillary-grid reveal" style="transition-delay:0.1s">
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1" />
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z" />
                    <line x1="6" y1="1" x2="6" y2="4" />
                    <line x1="10" y1="1" x2="10" y2="4" />
                    <line x1="14" y1="1" x2="14" y2="4" />
                </svg>
            </div>
            <div class="anc-title">Food</div>
            <div class="anc-note">Food packaging &amp; labelling</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M8 2h8l2 6H6L8 2z" />
                    <path d="M6 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8" />
                </svg>
            </div>
            <div class="anc-title">Beverage</div>
            <div class="anc-note">Bottle &amp; container labels</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
            </div>
            <div class="anc-title">Packaging</div>
            <div class="anc-note">Flexible &amp; rigid packaging</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
            </div>
            <div class="anc-title">Security</div>
            <div class="anc-note">Authentication &amp; anti-counterfeit</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                </svg>
            </div>
            <div class="anc-title">Health &amp; Safety</div>
            <div class="anc-note">Compliance labelling</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M6 20v-2a6 6 0 0 1 12 0v2" />
                </svg>
            </div>
            <div class="anc-title">Personal Care</div>
            <div class="anc-note">Cosmetics &amp; personal products</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 3h6v11l4 7H5l4-7V3z" />
                </svg>
            </div>
            <div class="anc-title">Chemical</div>
            <div class="anc-note">Industrial chemical labelling</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M10.5 20H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v7" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M8 12h8" />
                    <path d="M8 8h4" />
                </svg>
            </div>
            <div class="anc-title">Pharmaceutical</div>
            <div class="anc-note">Serialisation &amp; track &amp; trace</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="1" y="3" width="15" height="13" rx="2" />
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                    <circle cx="5.5" cy="18.5" r="2.5" />
                    <circle cx="18.5" cy="18.5" r="2.5" />
                </svg>
            </div>
            <div class="anc-title">Automotive</div>
            <div class="anc-note">Parts ID &amp; compliance labels</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="anc-title">Industrial</div>
            <div class="anc-note">Industrial product labelling</div>
        </div>
    </div>
</section>

<!-- ── WORKING ENVIRONMENT ── -->
<section id="different" style="background-color: #f5f5f5; color:#222222;">
    <div class="different_section" style="align-items: center;">
        <div class="section-wave" style="align-items: center;">
            <div class="main-title wow zoomIn">
                <div class="main-shadow-heading">
                    <h2>Working Environment</h2>
                </div>
                <h2>Working <span style="color:#7a0d7d">Environment</span></h2>
                <h3>Optimised for <span class="highlight">consistent performance</span></h3>
            </div>
        </div>
    </div>
    <div class="env-grid">
        <div class="env-card reveal">
            <div class="env-icon">
                <svg viewBox="0 0 24 24">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                    <polyline points="17 6 23 6 23 12" />
                </svg>
            </div>
            <div class="env-value">200 m/min</div>
            <div class="env-title">Max Running Speed</div>
            <p class="env-body">The Hyperloop runs at speeds up to 200 m/min (subject to substrate type), delivering one of the fastest inline slitting and inspection throughputs available for label and packaging converters.</p>
        </div>
        <div class="env-card reveal" style="transition-delay:0.1s">
            <div class="env-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                    <line x1="1" y1="10" x2="23" y2="10" />
                </svg>
            </div>
            <div class="env-value">220–240 V / 3 KW</div>
            <div class="env-title">Power Requirements</div>
            <p class="env-body">Standard single-phase 220–240 V supply at 3 KW, keeping installation straightforward across most factory environments without any special electrical infrastructure.</p>
        </div>
        <div class="env-card reveal" style="transition-delay:0.2s">
            <div class="env-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <div class="env-value">Touch HMI</div>
            <div class="env-title">Intuitive Control</div>
            <p class="env-body">All machine functions — blade positioning, web guide, speed control, and inspection thresholds — managed from a single touch screen panel, reducing training time and eliminating operator error.</p>
        </div>
    </div>
</section>

<!-- ── CONTACT ── -->
<section id="contact" style="padding:50px">
    <div class="contact-photo reveal">
        <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/61bcb317af56b916bbd53472_modes-footer-1.png" alt="Team working on production line" />
    </div>
    <div class="contact-info reveal" style="transition-delay:0.1s">
        <div class="section-eyebrow">Get In Touch</div>
        <div class="contact-tagline">
            Ready to<br>loop into<br><span>production mode?</span>
        </div>
        <p class="contact-body">Tell us about your production requirements and we'll configure the ideal Hyperloop system for your line — including VDP software setup, vision inspection calibration, and slitting configuration.</p>
        <div class="contact-highlights">
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                Running speed up to 200 m/min
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                Web widths 330 mm &amp; 450 mm
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                100% online vision inspection at 250 m/min
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                9-blade automated digital slitting via HMI
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                tracesci VDP — barcodes, QR, serialisation
            </div>
        </div>
    </div>
</section>
<div class="product_demo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- <div class="demo-badge">
                    Hyperloop 330 / 450
                </div> -->

                <h2>
                    High-Speed Inspection, Slitting &amp; Variable Data Printing
                </h2>

                <p>
                    Hyperloop combines variable data printing, 100% online vision inspection,
                    automated digital slitting, dual rewinding, and label transfer technology
                    into one integrated inline production system — delivering speeds up to
                    200 m/min for modern label and packaging environments.
                </p>

                <div class="demo-actions">
                    <a href="{{route('demo-schedule-create')}}" class="enterprise-btn">
                        Watch Hyperloop In Action
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>


@section('script')
<script>
    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, {
        threshold: 0.1
    });
    reveals.forEach(el => io.observe(el));

    // Word rotator
    const words = ['Variable Data Printing', 'High Speed Inspection', 'Digital Slitting', 'Track & Trace'];
    let idx = 0;
    const el = document.getElementById('rotateWord');
    if (el) {
        el.style.transition = 'opacity 0.3s, transform 0.3s';
        setInterval(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(12px)';
            setTimeout(() => {
                idx = (idx + 1) % words.length;
                el.textContent = words[idx];
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 300);
        }, 2400);
    }
</script>

<script type="text/javascript">
    cash(function() {
        async function contact() {
            cash('.contact__input').removeClass('border-theme-6')
            cash('.contact__input-error').html('')
            cash('#contactError').addClass('hidden')

            let name = cash('#name').val()
            let email = cash('#email').val()
            let mobile = cash('#mobile').val()
            let message = cash('#message').val()

            cash('#contactwait').removeClass('hidden')
            axios.post('{{ url("send_inquiry") }}', {
                name: name,
                email: email,
                mobile: mobile,
                message: message
            }).then(res => {
                cash('#contactSuccess').removeClass('hidden')
                cash('#contactError').addClass('hidden')
                cash('#contactwait').addClass('hidden')
                setTimeout(() => {
                    window.location.reload()
                }, 3000)
            }).catch(err => {
                cash('#contactError').removeClass('hidden')
                cash('#contactSuccess').addClass('hidden')
                cash('#contactwait').addClass('hidden')
                cash('#btn-contact').html('Submit')
                if (err.response.data.errors) {
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
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
</script>

<script>
    var revapi;
    jQuery(document).ready(function() {
        revapi = jQuery("#slider1").show().revolution({
            sliderType: "standard",
            sliderLayout: "fullscreen",
            delay: 6500,
            navigation: {
                arrows: {
                    enable: true
                },
                bullets: {
                    enable: true
                }
            }
        });
    });
</script>
@endsection
@endsection