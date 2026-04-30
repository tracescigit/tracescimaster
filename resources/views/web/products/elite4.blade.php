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
        --navy: #0b1f3a;
        --teal: #00c2a8;
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

    /* ── CONTACT ── */
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
        color: #7a0d7d;
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

    /* Rotating words */
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

    .btn img {
        width: 18px;
        filter: invert(1);
    }

    .btn-primary img {
        filter: invert(1);
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

    .hero-shape {
        position: absolute;
        bottom: 0;
        left: -60px;
        width: 180px;
        z-index: 3;
    }

    .hero-icon {
        position: absolute;
        top: 48px;
        right: 48px;
        width: 64px;
        opacity: 0.8;
    }

    .scroll-indicator {
        position: absolute;
        bottom: 36px;
        left: 56px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 5;
    }

    .scroll-indicator img {
        width: 32px;
        filter: invert(1) opacity(0.5);
        animation: bounce 2s infinite;
    }

    .scroll-indicator span {
        font-size: 11px;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.4);
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(8px);
        }
    }

    /* ── LOGOS ── */
    #logos {
        background: var(--off-white);
        padding: 48px 56px;
        overflow: hidden;
    }

    #logos h2 {
        font-family: 'Lora', serif;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 32px;
        color: var(--navy);
    }

    .logos-track-wrap {
        overflow: hidden;
    }

    .logos-track {
        display: flex;
        gap: 48px;
        align-items: center;
        animation: scroll-logos 20s linear infinite;
        width: max-content;
    }

    .logos-track img {
        height: 28px;
        width: auto;
        filter: grayscale(100%);
        opacity: 0.5;
        transition: opacity 0.3s;
    }

    .logos-track img:hover {
        opacity: 1;
        filter: none;
    }

    @keyframes scroll-logos {
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

    .section-wave {
        display: flex;
        align-items: center;
    }

    .section-wave img {
        width: 24px;
    }

    .section-wave-label {
        font-size: 11px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        font-weight: 600;
        color: 7a0d7d;
    }

    .section-heading {
        font-family: 'Lora', serif;
        font-size: 28px;
        font-weight: bold;
        line-height: 1.05;
        color: 7a0d7d;
        margin-bottom: 20px;
    }

    .section-heading .highlight {
        color: 7a0d7d;
    }

    .section-heading .italic {
        font-style: italic;
    }

    .section-sub {
        font-size: 17px;
        line-height: 1.75;
        color: var(--muted);
        margin-bottom: 48px;
        text-align: center;
    }

    /* ── SERVICES ── */
    #services {
        background: var(--white);
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2px;
        background: var(--border);
        border: 1px solid var(--border);
        margin-bottom: 64px;
    }

    .service-card {
        background: var(--white);
        padding: 40px 36px;
        transition: background 0.2s;
    }

    .service-card:hover {
        background: var(--teal-light);
    }

    .service-title {
        font-family: 'Lora', serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 8px;
    }

    .service-subtitle {
        font-size: 14px;
        color: var(--teal);
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .service-body {
        font-size: 14px;
        line-height: 1.75;
        color: var(--muted);
        margin-bottom: 28px;
    }

    .service-items {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .service-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .service-item-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
    }

    .service-item-text {
        font-size: 13px;
        font-weight: 600;
        color: var(--navy);
    }

    .service-item-sub {
        font-size: 12px;
        color: var(--muted);
        font-weight: 400;
    }

    .service-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--teal);
        text-decoration: none;
        margin-top: 28px;
        transition: gap 0.2s;
    }

    .service-link:hover {
        gap: 14px;
    }

    .service-link img {
        width: 16px;
    }

    /* ── ALLIANCES ── */
    #alliances {
        background: var(--navy);
        color: var(--white);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    #alliances .section-heading {
        color: var(--white);
    }

    #alliances .section-sub {
        color: rgba(255, 255, 255, 0.6);
    }

    .partners-logos {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .partner-logo-box {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .partner-logo-box:hover {
        background: rgba(0, 194, 168, 0.1);
        border-color: var(--teal);
    }

    .partner-logo-box img {
        height: 28px;
        width: auto;
        filter: brightness(0) invert(1);
        opacity: 0.7;
    }

    /* ── SOLUTIONS ── */
    #solutions {
        background: var(--white);
    }

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

    /* ── ANCILLARY ── */
    #ancillary {
        background: var(--white);
        align-items: center;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: start;
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
        border-color: #7a0d7d;
        background: #e9d6ea;
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
        stroke: #7a0d7d;
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

    /* ── INNOVATION ── */
    #innovation {
        background: var(--off-white);
    }

    .innovation-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .innovation-visual {
        background: var(--white);
        border-radius: 12px;
        padding: 48px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 300px;
    }

    .innovation-visual img {
        width: 100%;
        max-width: 280px;
    }

    /* ── JOIN ── */
    #join {
        background: var(--white);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .join-photo {
        position: relative;
    }

    .join-photo img {
        width: 100%;
        border-radius: 8px;
        display: block;
    }

    .join-photo-shape {
        position: absolute;
        bottom: -20px;
        left: -20px;
        width: 80px;
    }

    .join-badge {
        position: absolute;
        bottom: 32px;
        right: -20px;
        background: var(--teal);
        color: var(--white);
        padding: 20px 28px;
        border-radius: 8px;
        font-family: 'Lora', serif;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.2;
        text-transform: uppercase;
    }

    /* ── TECH SPECS ── */
    #specs {
        background: var(--off-white);
    }

    .specs-inner {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 64px;
        align-items: start;
    }

    .specs-table {
        background: var(--white);
        border: 1px solid var(--border);
        justify-self: end;
        width: 100%;
        max-width: 800px;
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

    .spec-key-tech {
        padding: 23px 28px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--muted);
        border-right: 1px solid var(--border);
        background: #fafafa;
    }

    .spec-val-tech {
        padding: 14px 28px;
        font-size: 13px;
        color: var(--navy);
        font-weight: 500;
        line-height: 1.5;
    }

    .spec-key-tech2 {
        padding: 40px 28px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--muted);
        border-right: 1px solid var(--border);
        background: #fafafa;
    }

    .spec-val-tech2 {
        padding: 32px 28px;
        font-size: 13px;
        color: var(--navy);
        font-weight: 500;
        line-height: 1.5;
    }

    .spec-val {
        padding: 14px 28px;
        font-size: 13px;
        color: var(--navy);
        font-weight: 500;
        line-height: 1.5;
    }

    .spec-val .highlight {
        color: #7a0d7d;
        font-weight: 700;
    }

    /* ── HOW WE'RE DIFFERENT ── */
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

    .diff-body {
        font-size: 18px;
        line-height: 1.75;
        color: rgba(255, 255, 255, 0.65);
        max-width: 640px;
        margin-bottom: 40px;
    }

    /* --Tech Specification -- */

    .tech-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        margin-top: 48px;
    }

    .env-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 48px;
    }

    .env-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid;
        border-color: #222222;
        border-radius: 12px;
        padding: 36px 30px;
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    .env-card:hover {
        border-color: #7a0d7d;
        background: #e9d6ea;
    }

    .env-icon {
        width: 48px;
        height: 48px;
        background: var(-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .env-icon svg {
        width: 24px;
        height: 24px;
        stroke: #700877;
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

    /* ── IDEAS ── */
    #ideas {
        background: var(--off-white);
    }

    .ideas-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .idea-card {
        background: var(--white);
        border-radius: 8px;
        padding: 36px 32px;
        border: 1px solid var(--border);
        text-decoration: none;
        color: inherit;
        display: block;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .idea-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }

    .idea-tag {
        font-size: 11px;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--teal);
        font-weight: 600;
        margin-bottom: 12px;
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

    .idea-title {
        font-family: 'Lora', serif;
        font-size: 17px;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.4;
        margin-bottom: 20px;
    }

    .idea-link {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--teal);
    }

    .idea-link img {
        width: 16px;
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

    .contact-form-wrap {
        padding-top: 8px;
    }

    .contact-form-wrap h2 {
        font-family: 'Lora', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 8px;
    }

    .contact-form-wrap p {
        font-size: 15px;
        color: var(--muted);
        margin-bottom: 32px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--border);
        border-radius: 4px;
        font-family: 'Lora', serif;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        transition: border-color 0.2s;
        outline: none;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--teal);
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-submit {
        background: var(--teal);
        color: var(--white);
        border: none;
        padding: 14px 32px;
        border-radius: 4px;
        font-family: 'Lora', serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .form-submit:hover {
        background: #00a890;
    }

    /* ── FOOTER ── */
    footer {
        background: var(--navy);
        color: rgba(255, 255, 255, 0.6);
        padding: 56px;
    }

    .footer-top {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr;
        gap: 48px;
        margin-bottom: 48px;
        padding-bottom: 48px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-logo {
        margin-bottom: 20px;
    }

    .footer-logo img {
        height: 28px;
        filter: brightness(0) invert(1);
    }

    .footer-desc {
        font-size: 13px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.45);
        margin-bottom: 24px;
    }

    .footer-social {
        display: flex;
        gap: 14px;
    }

    .footer-social a img {
        width: 20px;
        filter: brightness(0) invert(1);
        opacity: 0.4;
        transition: opacity 0.2s;
    }

    .footer-social a:hover img {
        opacity: 1;
    }

    .footer-col h4 {
        font-family: 'Lora', serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.35);
        margin-bottom: 18px;
    }

    .footer-col ul {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .footer-col ul a {
        text-decoration: none;
        color: rgba(255, 255, 255, 0.55);
        font-size: 13px;
        transition: color 0.2s;
    }

    .footer-col ul a:hover {
        color: var(--teal);
    }

    .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .footer-bottom p {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
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

        .services-grid {
            grid-template-columns: 1fr;
        }

        #alliances,
        .innovation-inner,
        #join,
        #contact {
            grid-template-columns: 1fr;
            gap: 40px;
            padding: 60px 24px;
        }

        .partners-logos {
            grid-template-columns: repeat(3, 1fr);
        }

        .ideas-grid {
            grid-template-columns: 1fr;
        }

        footer {
            padding: 40px 24px;
        }

        .footer-top {
            grid-template-columns: 1fr 1fr;
        }

        #logos {
            padding: 40px 24px;
        }

        .join-badge {
            display: none;
        }
    }
</style>

<div class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
        <ul>

            <!-- SLIDE 1 -->
            <li data-index="rs-1" data-transition="parallaxtoright" data-delay="6500">

                <!-- MAIN IMAGE -->
                <img src="{{asset('dist/images/slide1.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="auto"
                    data-bgrepeat="no-repeat">

                <!-- LAYER 1 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center"
                    data-y="top"
                    data-voffset="120"
                    data-start="1200"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        Go from black to brilliant
                    </span>
                </div>

                <!-- LAYER 2 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        ELITE4 <br>Multicolor Inkjet System
                    </div>
                </div>

                <!-- LAYER 3 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        VDP • Track & Trace • Authentication <br>
                        Optimized for high-throughput color printing
                    </div>
                </div>

                <!-- LAYER 4 (Buttons) -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="430"
                    data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="rev-slider-btn text-center">
                        <a a href="{{ url(Auth::check()?myDashboard():'/login') }}">Login</a>
                        <a a href="{{ url(Auth::check()?myDashboard():'/register') }}">Register</a>
                    </div>
                </div>

            </li>

            <!-- SLIDE 2 -->
            <li data-index="rs-2" data-transition="parallaxtoright" data-delay="6500">

                <!-- MAIN IMAGE -->
                <img src="{{asset('dist/images/slide2.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">

                <!-- LAYER 1 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200"
                    data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        Decide smarter. Deliver better
                    </span>
                </div>

                <!-- LAYER 2 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        track, trace & authentication
                    </div>
                </div>

                <!-- LAYER 3 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        We help configure and deploy Elite4,<br> tailored to your production needs
                    </div>
                </div>

                <!-- LAYER 4 (Buttons) -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="430"
                    data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="rev-slider-btn text-center">
                        <a href="#">Read More</a>
                        <a href="#">Get Started</a>
                    </div>
                </div>

            </li>

            <!-- SLIDE 3 -->
            <li data-index="rs-3" data-transition="parallaxtoright" data-delay="6500">

                <!-- MAIN IMAGE -->
                <img src="{{asset('dist/images/slide3.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">

                <!-- LAYER 1 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        VDP • Authentication • Supply Chain Intelligence
                    </span>
                </div>

                <!-- LAYER 2 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        High-Speed Multicolor Inkjet
                    </div>
                </div>

                <!-- LAYER 3 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        Up to 60 m/min • 300–2400 DPI • CMYK UV/Aqueous <br>
                        Seamless Tracesci VDP integration for codes & serialisation
                    </div>
                </div>

                <!-- LAYER 4 (Buttons) -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="430"
                    data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="rev-slider-btn text-center">
                        <a href="#">Read More</a>
                        <a href="#">Get Started</a>
                    </div>
                </div>

            </li>

        </ul>
    </div>
</div>

<div class="solution-area" style="background-color: #f5f5f5;">
    <!-- MAIN TITLE AREA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Core <span>Solution</span></h2>
                    </div>
                    <h2>Core<span style="color:#7a0d7d"> Solutions</span></h2>
                    <h3>Four integrated capabilities built for demanding multicolor production environments — from variable data and code verification to high-speed CMYK inkjet output.</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="solution-content" style="margin-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>High Speed Multicolor Inkjet System</h2>
                        <p>Purpose-built for demanding production environments. Industrial piezoelectric printheads (normal service life of 3 years or more) deliver consistent, high-quality multicolor output at speeds up to 60 m/min with minimal downtime...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Variable Data Printing Software</h2>
                        <p>Powered by Tracesci VDP Software — print barcodes, QR codes, dates and times, work group numbers, counters, graphics, tables, and databases in real-time. Printheads can be combined arbitrarily with multiple documents printed simultaneously at full production speed...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Track and Trace</h2>
                        <p>Integrated real-time printing of serialised codes ensures every item is uniquely identified and trackable across the supply chain. Supports full product authentication, anti-counterfeiting, and compliance workflows with centrally controlled print management...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Product Authentication</h2>
                        <p>Leverage the Elite4's multicolor CMYK inkjet capability to print overt and covert security marks, QR codes, and unique identifiers directly onto packaging at full line speed — enabling end-to-end product authentication from factory to consumer...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>CMYK UV &amp; Aqueous Inks</h2>
                        <p>Dual ink compatibility — CMYK UV curable and aqueous systems — with continuous ink supply delivering to up to 4 printheads simultaneously. Automatic ink type identification with low ink level alarm. Black, spot colour, and security ink options for pharma, packaging, labels, and security applications...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Easy Operation &amp; Quick ROI</h2>
                        <p>15-inch industrial-grade capacitive touchscreen (1280×800) running Windows for intuitive operation. PLC, RS485, RS232, WAN and LAN connectivity for seamless system integration. Designed for swift installation and rapid start-up, ensuring fast return on investment...</p>
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

    <section id="different" style="background-color: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="main-title wow zoomIn">
                        <div class="main-shadow-heading">
                            <h2>Technical Specifications</h2>
                        </div>
                        <h2>Technical <span style="color:#7a0d7d">Specifications</span></h2>
                        <h3>Industrial piezoelectric printheads with CMYK UV &amp; aqueous inks for high-speed multicolor output at up to 2400 DPI.</h3>
                    </div>
                    <h3 style="color: #0a0a0a;">Elite4 Spec Sheet</h3>
                </div>
            </div>
        </div>

        <div class="tech-grid">

            <!-- Print Engine -->
            <div class="reveal">
                <div class="specs-table reveal">
                    <div class="specs-table-header">Print Engine</div>

                    <div class="spec-row">
                        <div class="spec-key">Printhead Type</div>
                        <div class="spec-val">
                            Industrial Piezoelectric Printheads<br>
                            <span style="font-size:11px;color:var(--muted)">
                                Normal service life of 3 years or more
                            </span>
                        </div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Printing Speed</div>
                        <div class="spec-val">Up to <span class="highlight">60 m/min</span></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Printing DPI</div>
                        <div class="spec-val"><span class="highlight">300–2400 DPI</span> Adjustable</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Printing Width</div>
                        <div class="spec-val"><span class="highlight">1–33.8 mm</span></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Printing Method</div>
                        <div class="spec-val">Downspray</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Printing Distance</div>
                        <div class="spec-val"><span class="highlight">2–5 mm</span></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">No. of Printheads</div>
                        <div class="spec-val">Up to <span class="highlight">4</span></div>
                    </div>
                </div>
            </div>

            <!-- Ink, Media & Machine -->
            <div class="reveal" style="transition-delay:0.1s">
                <div class="specs-table">
                    <div class="specs-table-header">Ink, Media &amp; Machine</div>

                    <div class="spec-row">
                        <div class="spec-key">Consumable</div>
                        <div class="spec-val">CMYK UV Ink / Aqueous</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Ink Supply</div>
                        <div class="spec-val">
                            Continuous; supplies up to <span class="highlight">4 printheads</span> simultaneously.
                            Auto ink-type ID &amp; low-level alarm.
                        </div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Feed Width</div>
                        <div class="spec-val">45–300 mm</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Feed Thickness</div>
                        <div class="spec-val">Max <span class="highlight">5.0 mm</span></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Dimension</div>
                        <div class="spec-val">2503 × 750 × 805 mm</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Weight</div>
                        <div class="spec-val"><span class="highlight">870 kg</span></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Power</div>
                        <div class="spec-val">6 KW / 220V 50Hz/60Hz</div>
                    </div>
                </div>
            </div>

            <!-- Software, Control & Environment -->
            <div class="reveal" style="transition-delay:0.2s">
                <div class="specs-table">
                    <div class="specs-table-header">Software, Control &amp; Environment</div>

                    <div class="spec-row">
                        <div class="spec-key">Controller</div>
                        <div class="spec-val">
                            <span class="highlight">15" Industrial Capacitive Touchscreen</span><br>
                            1280×800 resolution
                        </div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Operating System</div>
                        <div class="spec-val">Windows</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Control Method</div>
                        <div class="spec-val">
                            Printheads combined arbitrarily, centrally controlled;
                            multiple documents printed simultaneously
                        </div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Connectivity</div>
                        <div class="spec-val">
                            PLC, RS485, RS232, WAN, LAN<br>
                            <span style="font-size:11px;color:var(--muted)">
                                Meets system integration requirements
                            </span>
                        </div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">USB Ports</div>
                        <div class="spec-val"><span class="highlight">4</span></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Language</div>
                        <div class="spec-val">English</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-key">Operating Temp.</div>
                        <div class="spec-val"><span class="highlight">15°C – 40°C</span></div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>

<section class="feature-area feature-2-area" style="background-color: #f5f5f5;">
    <div class="feature-heading-area  wow zoomIn">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="feature-heading-left ">
                        <h2 style="color: #7a0d7d; font-weight: bold">Built for speed &amp; multicolor precision</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-heading-right">
                        <p>The Elite4 is engineered to deliver exceptional multicolor throughput at up to 60 m/min without sacrificing print quality — even in high-demand continuous production environments running CMYK UV or aqueous inks.</p>
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

                    <!-- Nav tabs -->
                    <ul class="feature-2-left wow fadeInDown">
                        <li>
                            <h2><span></span>Suited Best For :</h2>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-FileBox"></i></span>Paper &amp; Coated</h3>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-ClipboardChart"></i></span>Plastics &amp; PVC</h3>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-Settings"></i></span>Cartons</h3>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-Settings"></i></span>Blister Packs</h3>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-Settings"></i></span>Pharma &amp; Healthcare Packaging</h3>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-Settings"></i></span>Security &amp; Authentication Substrates</h3>
                        </li>
                        <li>
                            <h3 href="#"><span><i class="icon icon-Settings"></i></span>Labels &amp; Flexible Packaging</h3>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</section>

<section id="ancillary">
    <div class="reveal" style="text-align:center; padding: 30px">
        <div class="main-title wow zoomIn">
            <div class="main-shadow-heading">
                <h2>Ancillary <span>Equipment</span></h2>
            </div>
            <h2>Ancillary<span style="color:#7a0d7d"> Equipment</span></h2>
            <h3 class="section-heading">Complete your <span class="highlight">production line</span></h3>
            <p class="section-sub">Ancillary equipment available at additional cost — configure the exact system your production environment demands.</p>
        </div>
    </div>

    <div class="ancillary-grid reveal" style="transition-delay:0.1s">
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
            </div>
            <div class="anc-title">Print Head Guarding</div>
            <div class="anc-note">Protection &amp; safety enclosure</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="5" />
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                </svg>
            </div>
            <div class="anc-title">UV Dryer</div>
            <div class="anc-note">Instant UV ink curing</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
            </div>
            <div class="anc-title">Web Cleaner</div>
            <div class="anc-note">Inline substrate cleaning</div>
        </div>
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
            <div class="anc-title">Web Guide</div>
            <div class="anc-note">Precision web alignment</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                </svg>
            </div>
            <div class="anc-title">Anti-Static Bars</div>
            <div class="anc-note">Static elimination system</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="anc-title">Sheet Feeder–Stacker</div>
            <div class="anc-note">Automated feed &amp; collection</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <div class="anc-title">Reel to Reel System</div>
            <div class="anc-note">Continuous roll media handling</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div class="anc-title">Corona Treater</div>
            <div class="anc-note">Surface treatment for adhesion</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </div>
            <div class="anc-title">Inspection System</div>
            <div class="anc-note">100% inline print inspection</div>
        </div>
        <div class="ancillary-item">
            <div class="anc-icon">
                <svg viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                </svg>
            </div>
            <div class="anc-title">Numeric Rejection</div>
            <div class="anc-note">Automated defect rejection</div>
        </div>
    </div>
</section>

<section id="different" style="background-color: #f5f5f5;color:#222222;">
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
                    <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z" />
                </svg>
            </div>
            <div class="env-value">15–40°C</div>
            <div class="env-title">Operating Temperature</div>
            <p class="env-body">The Elite4 operates across a wide ambient temperature range of 15–40°C, ensuring reliable ink viscosity and printhead performance in diverse factory and production environments.</p>
        </div>
        <div class="env-card reveal" style="transition-delay:0.1s">
            <div class="env-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                </svg>
            </div>
            <div class="env-value">5–45°C</div>
            <div class="env-title">Storage Temperature</div>
            <p class="env-body">Storage environment rated at 5–45°C ensures the Elite4 can be safely stored and transported across varying climate conditions without risk to print head or electronic components.</p>
        </div>
        <div class="env-card reveal" style="transition-delay:0.2s">
            <div class="env-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <div class="env-value">3+ Years</div>
            <div class="env-title">Printhead Service Life</div>
            <p class="env-body">The Elite4's industrial piezoelectric printheads are rated for a normal service life of 3 years or more, delivering long-term reliability and reduced cost of ownership across continuous multicolor production runs.</p>
        </div>
    </div>
</section>

<section id="contact" style="padding:50px">
    <div class="contact-photo reveal">
        <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/61bcb317af56b916bbd53472_modes-footer-1.png" alt="Man and woman working together" />
    </div>
    <div class="contact-form-wrap reveal" style="transition-delay:0.1s">
        <div class="section-eyebrow">Get In Touch</div>
        <div class="contact-tagline">Ready to<br>shift into<br><span>production mode?</span></div>
        <p class="contact-body">Tell us about your production requirements and we'll configure the ideal Elite4 system for your line — including any ancillary equipment needed for a complete multicolor inkjet solution.</p>
        <div class="contact-highlights">
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                High speed multicolor inkjet — up to 60 m/min
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                CMYK UV cured &amp; aqueous ink compatibility
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                Tracesci VDP software — barcodes, QR, serialisation
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                Track &amp; trace and product authentication built-in
            </div>
            <div class="contact-highlight">
                <div class="ch-dot"></div>
                Full ancillary equipment range available
            </div>
        </div>
    </div>
    </div>
</section>

@section('script')

<script>
{{-- Scroll reveal --}}
const reveals = document.querySelectorAll('.reveal');
const io = new IntersectionObserver(entries => {
entries.forEach(e => {
if (e.isIntersecting) {
e.target.classList.add('visible');
io.unobserve(e.target);
}
});
}, { threshold: 0.1 });
reveals.forEach(el => io.observe(el));

{{-- Word rotator --}}
const words = ['High Speed Multicolor Inkjet', 'CMYK UV & Aqueous Inks', 'Variable Data Printing', 'Track & Trace'];
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