@extends('web.layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO Meta --}}
    <title>Book a Demo | TRACESCI</title>
    <meta name="description" content="Schedule a personalised 30-minute TRACESCI product demo. Pick a date and time that works for you — no credit card required.">
    <meta name="keywords" content="TRACESCI, book demo, product demo, schedule demo, free demo">
    <meta name="robots" content="index, follow">
    <meta name="author" content="TRACESCI">
    <link rel="canonical" href="{{ url('/book-demo') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Book a Demo | TRACESCI">
    <meta property="og:description" content="See TRACESCI in action with a live personalised walkthrough. Book your free 30-minute demo today.">
    <meta property="og:url" content="{{ url('/book-demo') }}">
    <meta property="og:site_name" content="TRACESCI">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Book a Demo | TRACESCI">
    <meta name="twitter:description" content="See TRACESCI in action. Book your free 30-minute personalised demo today.">

    {{-- CSRF for axios --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f8f9fb;
            color: #1a1a2e;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e4eaf0;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-size: 18px;
            font-weight: 700;
            color: #0d1b2a;
            text-decoration: none;
            letter-spacing: -0.02em;
        }

        .navbar-brand span {
            color: #7a0d7d;
        }

        .navbar-back {
            font-size: 13px;
            color: #5a6a7a;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            transition: color 0.15s;
        }

        .navbar-back:hover {
            color: #7a0d7d;
        }

        /* ── Page ── */
        .demo-page {
            max-width: 1020px;
            margin: 0 auto;
            padding: 3rem 1.25rem 4rem;
        }

        /* ── Hero ── */
        .hero {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .hero-eyebrow {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #7a0d7d;
            background: #d9a3db;;
            padding: 4px 14px;
            margin-bottom: 14px;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0d1b2a;
            margin-bottom: 12px;
            line-height: 1.25;
        }

        .hero p {
            font-size: 15px;
            color: #5a6a7a;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .trust-strip {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 1.25rem;
            flex-wrap: wrap;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #5a6a7a;
        }

        .trust-icon {
            width: 16px;
            height: 16px;
            color: #7a0d7d;
            flex-shrink: 0;
        }

        /* ── Steps ── */
        .steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 2rem;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .step-num {
            width: 26px;
            height: 26px;
            
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            background: #e8edf2;
            color: #8899aa;
            border: 1.5px solid transparent;
            transition: all 0.2s;
        }

        .step-label {
            font-size: 12px;
            color: #8899aa;
            font-weight: 500;
            transition: color 0.2s;
        }

        .step.active .step-num {
            background: #7a0d7d;
            color: white;
            border-color: #7a0d7d;
        }

        .step.active .step-label {
            color: #0d1b2a;
        }

        .step.done .step-num {
            background: #d9a3db;
            color: #7a0d7d;
            border-color: #b85bbb;
        }

        .step.done .step-label {
            color: #7a0d7d;
        }

        .step-sep {
            color: #c8d4de;
            font-size: 18px;
            line-height: 1;
            margin: 0 2px;
        }

        /* ── Layout ── */
        .booking-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        @media (max-width: 700px) {
            .booking-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 1.5rem;
            }
        }

        /* ── Cards ── */
        .card {
            background: #ffffff;
            border: 1px solid #e4eaf0;
          
            padding: 1.5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .card-sm {
            background: #ffffff;
            border: 1px solid #e4eaf0;
            
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            margin-top: 1rem;
        }

        .section-label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: #8899aa;
            margin-bottom: 1rem;
        }

        /* ── Calendar ── */
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .cal-month-name {
            font-size: 15px;
            font-weight: 600;
            color: #0d1b2a;
        }

        .cal-nav-btn {
            background: none;
            border: 1px solid #e4eaf0;
           
            width: 30px;
            height: 30px;
            cursor: pointer;
            color: #5a6a7a;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, border-color 0.15s;
            line-height: 1;
        }

        .cal-nav-btn:hover {
            background: #f0f4f8;
            border-color: #c8d4de;
        }

        .cal-nav-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .cal-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            margin-bottom: 4px;
        }

        .cal-weekday {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: #a0aeba;
            padding: 4px 0;
        }

        .cal-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .cal-cell {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
           
            cursor: pointer;
            color: #0d1b2a;
            position: relative;
            transition: background 0.1s, color 0.1s;
            user-select: none;
            border: 1.5px solid transparent;
        }

        .cal-cell:hover:not(.empty):not(.past):not(.weekend):not(.fully-booked) {
            background: #e3b8e5;
            border-color: #b85bbb;
            color: #7a0d7d;
        }

        .cal-cell.empty {
            cursor: default;
        }

        .cal-cell.past,
        .cal-cell.weekend {
            color: #c8d4de;
            cursor: not-allowed;
        }

        .cal-cell.today {
            border-color: #7a0d7d;
            color: #7a0d7d;
            font-weight: 600;
        }

        .cal-cell.selected {
            background: #7a0d7d;
            color: #ffffff !important;
            border-color: #7a0d7d;
            font-weight: 600;
        }

        .cal-cell.selected:hover {
            background: #7a0d7d;
        }

        .cal-cell.fully-booked {
            color: #c8d4de;
            cursor: not-allowed;
        }

        .cal-cell.fully-booked::after,
        .cal-cell.few-slots::after {
            content: '';
            position: absolute;
            bottom: 3px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
        }

        .cal-cell.fully-booked::after {
            background: #E24B4A;
        }

        .cal-cell.few-slots::after {
            background: #EF9F27;
        }

        .cal-legend {
            display: flex;
            gap: 14px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #8899aa;
        }

        .legend-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── Slots ── */
        .slots-placeholder {
            text-align: center;
            padding: 1.5rem 0;
            color: #a0aeba;
            font-size: 13px;
        }

        .slots-date-heading {
            font-size: 13px;
            font-weight: 600;
            color: #0d1b2a;
            margin-bottom: 10px;
        }

        .slots-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
        }

        .slot-btn {
            padding: 9px 4px;
            text-align: center;
            font-size: 12px;
            font-weight: 500;
         
            border: 1px solid #e4eaf0;
            background: #ffffff;
            color: #0d1b2a;
            cursor: pointer;
            transition: all 0.1s;
            font-family: inherit;
        }

        .slot-btn:hover:not(.booked):not([disabled]) {
            background: #e3b8e5;
            border-color: #b85bbb;
            color: #7a0d7d;
        }

        .slot-btn.selected-slot {
            background: #7a0d7d;
            color: white;
            border-color: #7a0d7d;
        }

        .slot-btn.booked {
            opacity: 0.4;
            cursor: not-allowed;
            text-decoration: line-through;
            background: #f8f9fb;
            color: #a0aeba;
        }

        /* ── Form ── */
        .booking-summary-box {
            background: #e3b8e5;
            border: 1px solid #b85bbb;
     
            padding: 10px 14px;
            font-size: 12.5px;
            color: #7a0d7d;
            margin-bottom: 1rem;
            line-height: 1.9;
            display: none;
        }

        .booking-summary-box strong {
            font-weight: 600;
        }

        .form-divider {
            height: 1px;
            background: #e4eaf0;
            margin: 1rem 0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        @media (max-width: 480px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 12px;
        }

        .form-group.no-mb {
            margin-bottom: 0;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #5a6a7a;
        }

        .form-label .req {
            color: #E24B4A;
            margin-left: 2px;
        }

        .form-input,
        .form-textarea {
            font-size: 13.5px;
            border: 1px solid #d8e2ec;
        
            padding: 9px 12px;
            background: #ffffff;
            color: #0d1b2a;
            font-family: inherit;
            outline: none;
            width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #b0bec5;
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: #7a0d7d;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.12);
        }

        .form-input.error {
            border-color: #E24B4A;
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 3px rgba(226, 75, 74, 0.12);
        }

        .field-error {
            font-size: 11px;
            color: #E24B4A;
            margin-top: 2px;
            display: none;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
            line-height: 1.6;
        }

        .alert {
            padding: 11px 14px;
         
            font-size: 13px;
            margin-bottom: 12px;
            display: none;
        }

        .alert-danger {
            background: #FCEBEB;
            border: 1px solid #F7C1C1;
            color: #A32D2D;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #7a0d7d;
            color: white;
            border: none;
    
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 4px;
            font-family: inherit;
            transition: background 0.15s, transform 0.1s;
            letter-spacing: 0.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover:not(:disabled) {
            background: #7a0d7d;
        }

        .submit-btn:active:not(:disabled) {
            transform: scale(0.99);
        }

        .submit-btn:disabled {
            background: #e4eaf0;
            color: #a0aeba;
            cursor: not-allowed;
        }

        .btn-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            flex-shrink: 0;
        }

        .submit-btn.loading .btn-spinner {
            display: block;
        }

        .submit-btn.loading .btn-text {
            opacity: 0.75;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Success ── */
        .success-screen {
            display: none;
            text-align: center;
            padding: 4rem 1rem;
        }

        .success-circle {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #d9a3db;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .success-screen h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0d1b2a;
            margin-bottom: 10px;
        }

        .success-screen p {
            font-size: 14px;
            color: #5a6a7a;
            max-width: 420px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .success-details {
            display: inline-block;
            margin-top: 1.5rem;
            background: #e3b8e5;
            border: 1px solid #b85bbb;
  
            padding: 14px 28px;
            font-size: 13px;
            color: #7a0d7d;
            line-height: 2;
            text-align: left;
        }

        /* ── Footer ── */
        .page-footer {
            text-align: center;
            padding: 2rem 1rem;
            border-top: 1px solid #e4eaf0;
            margin-top: 2rem;
            font-size: 12px;
            color: #a0aeba;
        }

        .page-footer a {
            color: #5a6a7a;
            text-decoration: none;
        }

        .page-footer a:hover {
            color: #7a0d7d;
        }
    </style>
</head>

<body>
    <section class="page-title-area blog-standard-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="about-head-content">
                        <h2>Demonstration</h2>
                        <p>Get insight of our product</p>
                    </div>
                    <div class="breadcrumbs text-center">
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#">Demo</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="demo-page" itemscope itemtype="https://schema.org/Event">
        <meta itemprop="name" content="TRACESCI Product Demo">
        <meta itemprop="description" content="30-minute live personalised product demo of TRACESCI">
        <meta itemprop="eventStatus" content="https://schema.org/EventScheduled">
        <meta itemprop="eventAttendanceMode" content="https://schema.org/OnlineEventAttendanceMode">

        {{-- Hero --}}
        <header class="hero">
            <h1>Book a product demo</h1>
            <p>See TRACESCI in action with a personalised live walkthrough. Ask questions, explore features, and find out if it's the right fit for your team.</p>

        </header>

        {{-- Steps --}}
        <nav class="steps" aria-label="Booking progress">
            <div class="step active" id="step-1">
                <div class="step-num" aria-hidden="true">1</div>
                <span class="step-label">Date &amp; time</span>
            </div>
            <span class="step-sep" aria-hidden="true">›</span>
            <div class="step" id="step-2">
                <div class="step-num" aria-hidden="true">2</div>
                <span class="step-label">Your details</span>
            </div>
            <span class="step-sep" aria-hidden="true">›</span>
            <div class="step" id="step-3">
                <div class="step-num" aria-hidden="true">3</div>
                <span class="step-label">Confirmed</span>
            </div>
        </nav>

        {{-- Booking grid --}}
        <div class="booking-grid" id="booking-grid">

            {{-- Left: Calendar + Slots --}}
            <div>
                <div class="card">
                    <p class="section-label">Select a date</p>
                    <div class="cal-header">
                        <button class="cal-nav-btn" id="cal-prev" aria-label="Previous month">&#8249;</button>
                        <span class="cal-month-name" id="cal-month-label" aria-live="polite"></span>
                        <button class="cal-nav-btn" id="cal-next" aria-label="Next month">&#8250;</button>
                    </div>
                    <div class="cal-weekdays" role="row" aria-label="Days of the week">
                        <div class="cal-weekday" aria-label="Sunday">Su</div>
                        <div class="cal-weekday" aria-label="Monday">Mo</div>
                        <div class="cal-weekday" aria-label="Tuesday">Tu</div>
                        <div class="cal-weekday" aria-label="Wednesday">We</div>
                        <div class="cal-weekday" aria-label="Thursday">Th</div>
                        <div class="cal-weekday" aria-label="Friday">Fr</div>
                        <div class="cal-weekday" aria-label="Saturday">Sa</div>
                    </div>
                    <div class="cal-dates" id="cal-dates" role="grid" aria-label="Select a date for your demo"></div>
                    <div class="cal-legend" aria-label="Calendar legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#7a0d7d;" aria-hidden="true"></div>Selected
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#EF9F27;" aria-hidden="true"></div>Few slots left
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#E24B4A;" aria-hidden="true"></div>Fully booked
                        </div>
                    </div>
                </div>

                <div class="card-sm">
                    <div id="slots-container">
                        <div class="slots-placeholder">Select a date above to see available time slots</div>
                    </div>
                </div>
            </div>

            {{-- Right: Form --}}
            <div class="card">
                <p class="section-label">Your information</p>
                <div class="booking-summary-box" id="booking-summary" aria-live="polite"></div>
                <div class="alert alert-danger" id="form-alert" role="alert"></div>

                <form id="demo-form" novalidate>
                    @csrf
                    <input type="hidden" name="demo_date" id="demo_date">
                    <input type="hidden" name="demo_time" id="demo_time">

                    <div class="form-row">
                        <div class="form-group no-mb">
                            <label class="form-label" for="full_name">Full name <span class="req">*</span></label>
                            <input class="form-input" type="text" id="full_name" name="full_name"
                                placeholder="Please Provide your Name" autocomplete="name"
                                value="{{ old('full_name') }}"
                                aria-required="true" aria-describedby="err-full_name">
                            <span class="field-error" id="err-full_name" role="alert"></span>
                        </div>
                        <div class="form-group no-mb">
                            <label class="form-label" for="phone">Phone number</label>
                            <input class="form-input" type="tel" id="phone" name="phone"
                                placeholder="+91 9876XXXXXX" autocomplete="tel"
                                value="{{ old('phone') }}"
                                aria-describedby="err-phone">
                            <span class="field-error" id="err-phone" role="alert"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email address <span class="req">*</span></label>
                        <input class="form-input" type="email" id="email" name="email"
                            placeholder="exapmle@company.com" autocomplete="email"
                            value="{{ old('email') }}"
                            aria-required="true" aria-describedby="err-email">
                        <span class="field-error" id="err-email" role="alert"></span>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-row">
                        <div class="form-group no-mb">
                            <label class="form-label" for="company_name">Company name <span class="req">*</span></label>
                            <input class="form-input" type="text" id="company_name" name="company_name"
                                placeholder="Please provide company details" autocomplete="organization"
                                value="{{ old('company_name') }}"
                                aria-required="true" aria-describedby="err-company_name">
                            <span class="field-error" id="err-company_name" role="alert"></span>
                        </div>
                        <div class="form-group no-mb">
                            <label class="form-label" for="company_email">Company email</label>
                            <input class="form-input" type="email" id="company_email" name="company_email"
                                placeholder="organisation@example.com"
                                value="{{ old('company_email') }}"
                                aria-describedby="err-company_email">
                            <span class="field-error" id="err-company_email" role="alert"></span>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label" for="message">Anything you'd like us to know?</label>
                        <textarea class="form-textarea" id="message" name="message"
                            placeholder="Topics to cover, team size, current challenges…"
                            aria-describedby="err-message">{{ old('message') }}</textarea>
                        <span class="field-error" id="err-message" role="alert"></span>
                    </div>

                    <button type="submit" class="submit-btn" id="submit-btn" disabled aria-disabled="true">
                        <div class="btn-spinner" aria-hidden="true"></div>
                        <span class="btn-text">Choose a date and time to continue</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Success screen --}}
        <div class="success-screen" id="success-screen" aria-live="polite" role="status">
            <div class="success-circle" aria-hidden="true">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#7a0d7d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            </div>
            <h2>Demo booked!</h2>
            <p>We've sent a confirmation to your email. Looking forward to speaking with you about TRACESCI.</p>
            <div class="success-details" id="success-details"></div>
            <p style="margin-top:1.75rem;">
                <a href="{{ url('/') }}" style="color:#7a0d7d;font-size:13px;font-weight:600;text-decoration:none;">← Back to homepage</a>
            </p>
        </div>
    </main>

    <script>
        (function() {

            /* CSRF setup */
            axios.defaults.headers.common['X-CSRF-TOKEN'] =
                document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            /* Booked slots from controller — format: { 'YYYY-MM-DD': ['09:00','10:00'], ... } */
            const BOOKED_SLOTS = @json($bookedSlots ?? []);

            const ALL_SLOTS = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'];
            const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
                'August', 'September', 'October', 'November', 'December'
            ];
            const WEEKENDS = [0, 6];

            let viewYear, viewMonth;
            let selectedDate = null;
            let selectedSlot = null;

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            viewYear = today.getFullYear();
            viewMonth = today.getMonth();

            /* helpers */
            const pad = n => String(n).padStart(2, '0');
            const dateKey = (y, m, d) => `${y}-${pad(m + 1)}-${pad(d)}`;
            const fmtDate = k => {
                const [y, m, d] = k.split('-');
                return new Date(+y, +m - 1, +d).toLocaleDateString('en-IN', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            };
            const fmtSlot = s => {
                const [h, m] = s.split(':');
                const hr = +h;
                return `${hr > 12 ? hr - 12 : (hr || 12)}:${m} ${hr >= 12 ? 'PM' : 'AM'}`;
            };

            function slotStatus(dk) {
                const b = BOOKED_SLOTS[dk] || [];
                if (b.length >= ALL_SLOTS.length) return 'full';
                if (b.length >= ALL_SLOTS.length - 2) return 'few';
                return 'open';
            }

            /* Calendar */
            function renderCalendar() {
                document.getElementById('cal-month-label').textContent =
                    `${MONTH_NAMES[viewMonth]} ${viewYear}`;
                document.getElementById('cal-prev').disabled =
                    viewYear === today.getFullYear() && viewMonth <= today.getMonth();

                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
                let html = '';

                for (let i = 0; i < firstDay; i++)
                    html += `<div class="cal-cell empty" aria-hidden="true"></div>`;

                for (let d = 1; d <= daysInMonth; d++) {
                    const dk = dateKey(viewYear, viewMonth, d);
                    const date = new Date(viewYear, viewMonth, d);
                    const isPast = date < today;
                    const isWknd = WEEKENDS.includes(date.getDay());
                    const status = slotStatus(dk);
                    const isSel = dk === selectedDate;
                    const isToday = dk === dateKey(today.getFullYear(), today.getMonth(), today.getDate());

                    let cls = 'cal-cell';
                    let clickable = false;

                    if (isPast || isWknd) cls += ' past';
                    else if (status === 'full') cls += ' fully-booked';
                    else {
                        if (status === 'few') cls += ' few-slots';
                        clickable = true;
                    }

                    if (isToday && !isSel) cls += ' today';
                    if (isSel) cls += ' selected';

                    html += `<div
                    class="${cls}"
                    role="${clickable ? 'button' : 'gridcell'}"
                    tabindex="${clickable ? 0 : -1}"
                    aria-label="${fmtDate(dk)}${isPast ? ', past date' : isWknd ? ', weekend — unavailable' : status === 'full' ? ', fully booked' : ''}"
                    aria-pressed="${isSel}"
                    ${clickable ? `data-date="${dk}"` : ''}
                >${d}</div>`;
                }
                document.getElementById('cal-dates').innerHTML = html;
            }

            /* Slots */
            function renderSlots() {
                const container = document.getElementById('slots-container');
                if (!selectedDate) {
                    container.innerHTML = `<div class="slots-placeholder">Select a date above to see available time slots</div>`;
                    return;
                }
                const booked = BOOKED_SLOTS[selectedDate] || [];
                container.innerHTML = `
                <p class="section-label" style="margin-bottom:8px;">Available times</p>
                <p class="slots-date-heading">${fmtDate(selectedDate)}</p>
                <div class="slots-grid">
                    ${ALL_SLOTS.map(s => {
                        const isBooked = booked.includes(s);
                        const isSel    = s === selectedSlot;
                        let cls = 'slot-btn';
                        if (isBooked)   cls += ' booked';
                        else if (isSel) cls += ' selected-slot';
                        return `<button type="button" class="${cls}"
                            ${isBooked ? 'disabled aria-disabled="true"' : `data-slot="${s}"`}
                            aria-pressed="${isSel}"
                            aria-label="${fmtSlot(s)}${isBooked ? ' — already booked' : ''}"
                        >${fmtSlot(s)}${isBooked ? ' ✕' : ''}</button>`;
                    }).join('')}
                </div>`;
            }

            /* Summary */
            function updateSummary() {
                const el = document.getElementById('booking-summary');
                if (selectedDate && selectedSlot) {
                    el.style.display = 'block';
                    el.innerHTML = `<strong>Date:</strong> ${fmtDate(selectedDate)}<br><strong>Time:</strong> ${fmtSlot(selectedSlot)} IST &nbsp;&middot;&nbsp; 30-min demo`;
                } else {
                    el.style.display = 'none';
                }
            }

            /* Submit button */
            function updateSubmitBtn() {
                const btn = document.getElementById('submit-btn');
                const text = btn.querySelector('.btn-text');
                if (selectedDate && selectedSlot) {
                    btn.disabled = false;
                    btn.removeAttribute('aria-disabled');
                    text.textContent = 'Book my demo →';
                } else {
                    btn.disabled = true;
                    btn.setAttribute('aria-disabled', 'true');
                    text.textContent = 'Choose a date and time to continue';
                }
            }

            /* Steps */
            function updateSteps(step) {
                document.getElementById('step-1').className =
                    step >= 2 ? 'step done' : 'step active';
                document.getElementById('step-2').className =
                    step >= 3 ? 'step done' : step === 2 ? 'step active' : 'step';
                document.getElementById('step-3').className =
                    step === 3 ? 'step active' : 'step';
            }

            /* Date click */
            document.getElementById('cal-dates').addEventListener('click', e => {
                const cell = e.target.closest('[data-date]');
                if (!cell) return;
                selectedDate = cell.dataset.date;
                selectedSlot = null;
                document.getElementById('demo_date').value = selectedDate;
                document.getElementById('demo_time').value = '';
                renderCalendar();
                renderSlots();
                updateSummary();
                updateSubmitBtn();
                updateSteps(1);
            });
            document.getElementById('cal-dates').addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') {
                    const cell = e.target.closest('[data-date]');
                    if (cell) {
                        e.preventDefault();
                        cell.click();
                    }
                }
            });

            /* Slot click */
            document.getElementById('slots-container').addEventListener('click', e => {
                const btn = e.target.closest('[data-slot]');
                if (!btn) return;
                selectedSlot = btn.dataset.slot;
                document.getElementById('demo_time').value = selectedSlot;
                renderSlots();
                updateSummary();
                updateSubmitBtn();
                updateSteps(2);
            });

            /* Month nav */
            document.getElementById('cal-prev').addEventListener('click', () => {
                if (--viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderCalendar();
            });
            document.getElementById('cal-next').addEventListener('click', () => {
                if (++viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderCalendar();
            });

            /* Validation */
            function showFieldError(id, msg) {
                const el = document.getElementById(id);
                if (!el) return;
                el.textContent = msg;
                el.style.display = 'block';
                const input = document.getElementById(id.replace('err-', ''));
                if (input) input.classList.add('error');
            }

            function clearFieldError(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.style.display = 'none';
                    el.textContent = '';
                }
                const input = document.getElementById(id.replace('err-', ''));
                if (input) input.classList.remove('error');
            }
            ['full_name', 'email', 'phone', 'company_name', 'company_email'].forEach(f => {
                const el = document.getElementById(f);
                if (el) el.addEventListener('input', () => clearFieldError(`err-${f}`));
            });

            function validateForm() {
                let valid = true;
                ['full_name', 'email', 'company_name'].forEach(f => clearFieldError(`err-${f}`));
                const name = document.getElementById('full_name').value.trim();
                const email = document.getElementById('email').value.trim();
                const company = document.getElementById('company_name').value.trim();
                if (!name) {
                    showFieldError('err-full_name', 'Please enter your full name.');
                    valid = false;
                }
                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showFieldError('err-email', 'Please enter a valid email address.');
                    valid = false;
                }
                if (!company) {
                    showFieldError('err-company_name', 'Please enter your company name.');
                    valid = false;
                }
                return valid;
            }

            /* Submit */
            document.getElementById('demo-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const alertEl = document.getElementById('form-alert');
                alertEl.style.display = 'none';

                if (!validateForm()) {
                    const firstErr = this.querySelector('.form-input.error');
                    if (firstErr) firstErr.focus();
                    return;
                }
                if (!selectedDate || !selectedSlot) return;

                const btn = document.getElementById('submit-btn');
                btn.classList.add('loading');
                btn.disabled = true;

                axios.post("{{ route('demo-schedule-store') }}", new FormData(this))
                    .then(() => {
                        updateSteps(3);
                        document.getElementById('booking-grid').style.display = 'none';
                        const screen = document.getElementById('success-screen');
                        screen.style.display = 'block';
                        document.getElementById('success-details').innerHTML =
                            `<strong>Date:</strong> ${fmtDate(selectedDate)}<br><strong>Time:</strong> ${fmtSlot(selectedSlot)} IST`;
                        screen.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    })
                    .catch(err => {
                        btn.classList.remove('loading');
                        btn.disabled = false;
                        const errors = err?.response?.data?.errors || {};
                        Object.entries(errors).forEach(([field, msgs]) => {
                            showFieldError(`err-${field}`, Array.isArray(msgs) ? msgs[0] : msgs);
                        });
                        const msg = err?.response?.data?.message;
                        if (msg) {
                            alertEl.textContent = msg;
                            alertEl.style.display = 'block';
                            alertEl.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    });
            });

            /* Init */
            renderCalendar();
            renderSlots();
            updateSubmitBtn();
            updateSteps(1);

        })();
    </script>

</body>

</html>