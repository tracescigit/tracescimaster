<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Razor6 — High Speed UV Inkjet Systems </title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
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
            font-family: 'Inter', sans-serif;
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
            font-family: 'Syne', sans-serif;
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

        /* Rotating words */
        .hero-tagline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(52px, 7vw, 100px);
            font-weight: 800;
            line-height: 0.95;
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
            font-family: 'Syne', sans-serif;
            font-size: clamp(20px, 2.5vw, 32px);
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.3;
            margin-bottom: 40px;
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
            font-family: 'Syne', sans-serif;
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
            padding: 100px 56px;
        }

        .section-wave {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .section-wave img {
            width: 24px;
        }

        .section-wave-label {
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--teal);
        }

        .section-heading {
            font-family: 'Syne', sans-serif;
            font-size: clamp(32px, 4vw, 56px);
            font-weight: 800;
            line-height: 1.05;
            color: var(--navy);
            margin-bottom: 20px;
        }

        .section-heading .highlight {
            color: var(--teal);
        }

        .section-heading .italic {
            font-style: italic;
        }

        .section-sub {
            font-size: 17px;
            line-height: 1.75;
            color: var(--muted);
            max-width: 600px;
            margin-bottom: 48px;
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
            font-family: 'Syne', sans-serif;
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
            font-family: 'Syne', sans-serif;
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
            font-family: 'Syne', sans-serif;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: start;
        }

        .ancillary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
            font-family: 'Syne', sans-serif;
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
            background: var(--navy);
            padding: 18px 28px;
            font-family: 'Syne', sans-serif;
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
            padding: 14px 20px;
            font-size: 13px;
            color: var(--navy);
            font-weight: 500;
            line-height: 1.5;
        }

        .spec-val .highlight {
            color: var(--teal);
            font-weight: 700;
        }

        /* ── HOW WE'RE DIFFERENT ── */
        #different {
            background: var(--navy);
            color: var(--white);
        }

        #different .section-heading {
            color: var(--white);
        }

        .diff-body {
            font-size: 18px;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.65);
            max-width: 640px;
            margin-bottom: 40px;
        }

        .env-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 48px;
        }

        .env-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 36px 30px;
            transition: background 0.2s;
        }

        .env-card:hover {
            border-color: var(--teal);
            background: var(--light);
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
            stroke: var(--teal);
            fill: none;
            stroke-width: 1.8;
        }

        .env-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 8px;
        }

        .env-body {
            font-size: 13px;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.5);
        }

        .env-value {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--orange);
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
            font-family: 'Syne', sans-serif;
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
            font-family: 'Syne', sans-serif;
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
            font-family: 'Syne', sans-serif;
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
            font-family: 'Inter', sans-serif;
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
            font-family: 'Inter', sans-serif;
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
            font-family: 'Syne', sans-serif;
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
</head>

<body>

    <!-- NAV -->
    <!-- <nav>
    <a class="nav-logo" href="#">
      <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/667306cdcfb3da4eb3545d25_Modes.svg" alt="Modes Inc"/>
    </a>
    <ul class="nav-links">
      <li>
        <a href="#about">
          <img class="wave" src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt=""/>
          about
        </a>
      </li>
      <li>
        <a href="#services">
          <img class="wave" src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt=""/>
          services
        </a>
      </li>
      <li>
        <a href="#alliances">
          <img class="wave" src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt=""/>
          Partners
        </a>
      </li>
      <li>
        <a href="#ideas">
          <img class="wave" src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt=""/>
          IDEAS
        </a>
      </li>
      <li>
        <a href="#contact" class="nav-cta">connect</a>
      </li>
    </ul>
  </nav> -->

    <!-- HERO -->
    <section id="hero">
        <div class="hero-left">
            <div class="hero-tagline">
                <span class="tagline-child">Switch to</span> <br>Razor6<br>
                <span class="hero-word-rotate" id="rotateWord">High Speed PDF Printing</span><br>

            </div>
            <h1 class="hero-subtitle">High Speed<br>UV Inkjet Systems.</h1>
            <p class="hero-body">Industrial-grade UV cured inkjet printing with piezo DOD technology. Quick return on investment, operator-friendly ink control, and unmatched throughput for modern production lines.</p>
            <div class="hero-ctas">
                <a href="{{ route('demo-schedule-create') }}" id=#services class="btn btn-primary">
                    Schedule Demo
                    <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618d7c356cbe86d13fc25d4a_arrow-right.svg" alt="→" />
                </a>
                <a href="#specs" class="btn btn-ghost">Learn More</a>
            </div>
        </div>

        <div class="hero-right">
            <img class="hero-photo" src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/61bcb3c74494053435e55d8e_Modes-home-1.jpg" alt="Women in a creative meeting" />
            <img class="hero-shape" src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd4d675ac20766230e2ac_shape-white-hero.svg" alt="" />
            <img class="hero-icon" src="" alt="" />
        </div>
        <!-- <div class="scroll-indicator">
      <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd4d61949934deec2bc4b_arrow-down.svg" alt="scroll down"/>
    </div> -->
        <div class="scroll-indicator">
            <div class="scroll-arrow">
                <svg viewBox="0 0 24 24">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </div>
            <span>Scroll to explore</span>
        </div>

    </section>


    <div id="marquee-strip">
        <!-- MARQUEE -->
        <div class="marquee-track">
            <span>Industrial Inkjet</span><span class="sep">◆</span>
            <span>Variable Data Printing</span><span class="sep">◆</span>
            <span>Online Verification</span><span class="sep">◆</span>
            <span>UV Curable Inks</span><span class="sep">◆</span>
            <span>High Speed PDF</span><span class="sep">◆</span>
            <span>Piezo DOD Technology</span><span class="sep">◆</span>
            <span>600 DPI Resolution</span><span class="sep">◆</span>
            <span>150 mtr/min</span><span class="sep">◆</span>
            <!-- duplicate -->
            <span>Industrial Inkjet</span><span class="sep">◆</span>
            <span>Variable Data Printing</span><span class="sep">◆</span>
            <span>Online Verification</span><span class="sep">◆</span>
            <span>UV Curable Inks</span><span class="sep">◆</span>
            <span>High Speed PDF</span><span class="sep">◆</span>
            <span>Piezo DOD Technology</span><span class="sep">◆</span>
            <span>600 DPI Resolution</span><span class="sep">◆</span>
            <span>150 mtr/min</span><span class="sep">◆</span>
        </div>
    </div>



    <!-- SERVICES -->
    <section id="services">
        <div class="reveal">
            <div class="section-wave">
                <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt="" />
                <span class="section-wave-label">Core Solutions</span>
            </div>
            <h2 class="section-heading">What Razor6 <span class="highlight">delivers</span></h2>
            <p class="section-sub">Four integrated capabilities built for demanding production environments — from variable data and code verification to ultra-fast PDF output.</p>
        </div>

        <div class="services-grid reveal">
            <div class="solution-card">

                <div class="sol-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <path d="M8 21h8M12 17v4" />
                    </svg>
                </div>
                <div class="sol-title">Industrial Inkjet System</div>
                <p class="sol-body">Purpose-built for 24×7 industrial production environments. Robust Piezo DOD print head technology delivers consistent, high-quality output across demanding continuous-run operations with minimal downtime.</p>
            </div>

            <div class="solution-card">

                <div class="sol-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                </div>
                <div class="sol-title">Variable Data Printing Software</div>
                <p class="sol-body">Powered by Tarcesci RapidPro Software — industry-leading VDP engine for serialisation, barcodes, QR codes, personalisation and complex variable data at full production speed without compromising throughput.</p>
            </div>

            <div class="solution-card">

                <div class="sol-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="sol-title">Online Code Verification</div>
                <p class="sol-body">Integrated real-time verification ensures every printed code — barcode, QR, DataMatrix, or serialised number — is readable and compliant. Bad codes are flagged and rejected automatically inline, keeping your line 100% accurate.</p>
            </div>

            <div class="solution-card">

                <div class="sol-icon">
                    <svg viewBox="0 0 24 24">
                        <polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                </div>
                <div class="sol-title">High Speed PDF Printing</div>
                <p class="sol-body">Native PDF workflow support enables direct-to-press output without ripping delays. Handles complex graphical content, security patterns, and fine text at full line speed — up to 150 metres per minute.</p>
            </div>

            <div class="solution-card">

                <div class="sol-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.07 4.93a10 10 0 0 1 0 14.14" />
                        <path d="M4.93 4.93a10 10 0 0 0 0 14.14" />
                    </svg>
                </div>
                <div class="sol-title">UV Cured Aqueous Inks</div>
                <p class="sol-body">Dual ink compatibility — UV curable and aqueous systems — in 0.5L and 1L tank configurations. Black, Spot colour, and Security ink options provide versatility across packaging, labels, pharma, and security applications.</p>
            </div>

            <div class="solution-card">

                <div class="sol-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <div class="sol-title">Quick ROI &amp; Easy Operation</div>
                <p class="sol-body">Operator-friendly ink control with intuitive interface minimises training time. Designed for swift installation and rapid start-up, ensuring fast return on investment and low total cost of ownership across your production lifecycle.</p>
            </div>
        </div>
    </section>

    <!-- PERFORMANCE -->
    <section id="alliances">
        <div class="reveal">
            <div class="section-wave">
                <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt="" />
                <span class="section-wave-label" style="color:var(--teal)">Performance</span>
            </div>
            <h2 class="section-heading" style="color:white">Built for<br><span class="highlight">speed &amp; precision</span></h2>
            <p class="section-sub">The Razor6 is engineered to deliver exceptional throughput without sacrificing print quality — even in the harshest 24×7 continuous production environments.</p>

        </div>
        <div class="reveal" style="transition-delay:0.1s">
            <p style="font-size:13px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);font-weight:600;margin-bottom:24px;">Suited Best for</p>
            <div class="partners-logos">
                <div class="partner-logo-box">
                    <p style="font-size:20px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);font-weight:600;;">Paper &amp; Coated</p>
                </div>
                <div class="partner-logo-box">
                    <p style="font-size:20px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);font-weight:600;;">Plastics &amp; PVC</p>
                </div>
                <div class="partner-logo-box">
                    <p style="font-size:20px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);font-weight:600;;">Cartons</p>
                </div>
                <div class="partner-logo-box">
                    <p style="font-size:20px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);font-weight:600;;">Blister Packs</p>
                </div>
                <div class="partner-logo-box">
                    <p style="font-size:20px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);font-weight:600;;">Security Substrates</p>
                </div>

            </div>
        </div>
    </section>

    <!-- TECH SPECS -->
    <section id="specs">
        <div class="specs-inner">
            <div class="reveal">
                <div class="section-wave-label" style="color:var(--teal)">Technical Specifications</div>
                <h2 class="section-heading">Razor6<br><span class="highlight">Spec Sheet</span></h2>
                <p class="section-sub">Precision-engineered with Piezo DOD technology and UV curable aqueous inks for consistent high-performance output.</p>
                <div class="specs-table reveal" style="margin-left: 20px;">
                    <div class="specs-table-header">Print Engine</div>
                    <div class="spec-row">
                        <div class="spec-key">Print Heads</div>
                        <div class="spec-val">Piezo DOD Technology</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Print Width</div>
                        <div class="spec-val"><span class="highlight">Multiple of 54.1 mm</span> (2.1")</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Resolution</div>
                        <div class="spec-val">600×600, 600×300 dpi and more</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Drop Volume</div>
                        <div class="spec-val">Binary: <span class="highlight">5pl</span> / Greyscale: 5–15pl</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Speed</div>
                        <div class="spec-val">Up to <span class="highlight">150 mtr/min</span> (resolution dependent)</div>
                    </div>
                </div>
            </div>

            <div class="reveal" style="transition-delay:0.1s">
                <div class="specs-table" style="margin-top: 20px;">
                    <div class="specs-table-header">Ink &amp; Substrates</div>
                    <div class="spec-row">
                        <div class="spec-key">Compatible Inks</div>
                        <div class="spec-val">UV Curable, Aqueous</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Ink Tank</div>
                        <div class="spec-val">0.5L / 1L</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Colour Options</div>
                        <div class="spec-val">Black, Spot, <span class="highlight">Security Inks</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Substrates</div>
                        <div class="spec-val">Paper, Coated, Plastics, PVC, Cartons, Blister etc.</div>
                    </div>
                </div>

                <div class="specs-table" style="margin-top:50px">
                    <div class="specs-table-header">Software &amp; Environment</div>
                    <div class="spec-row">
                        <div class="spec-key">VDP Software</div>
                        <div class="spec-val"><span class="highlight">Tarcesci RapidPro</span></div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Temperature</div>
                        <div class="spec-val">20–28 °C</div>
                    </div>
                    <div class="spec-row">
                        <div class="spec-key">Humidity</div>
                        <div class="spec-val">40–60%, Non-Condensing</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ANCILLARY EQUIPMENT -->
    <section id="ancillary">
        <div class="reveal">
            <div class="section-wave-label" style="color:var(--teal)">Ancillary Equipment</div>
            <h2 class="section-heading">Complete your<br><span class="highlight">production line</span></h2>
            <p class="section-sub">Ancillary equipment available at additional cost — configure the exact system your production environment demands.</p>

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

    <!-- HOW WE'RE DIFFERENT -->
    <section id="different">
        <div class="reveal">
            <div class="section-wave">
                <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7640b7381125ae7d4ec_wave-line.svg" alt="" />
                <span class="section-wave-label">Working Environment</span>
            </div>
            <h2 class="section-heading" style="color:white">Optimised for<br><span class="highlight">consistent performance</span></h2>
        </div>
        <div class="env-grid">
            <div class="env-card reveal">
                <div class="env-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z" />
                    </svg>
                </div>
                <div class="env-value">20–28°C</div>
                <div class="env-title">Temperature Range</div>
                <p class="env-body">Maintain ambient temperature between 20–28°C for optimal ink viscosity and print head performance throughout extended production runs.</p>
            </div>
            <div class="env-card reveal" style="transition-delay:0.1s">
                <div class="env-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                    </svg>
                </div>
                <div class="env-value">40–60%</div>
                <div class="env-title">Relative Humidity</div>
                <p class="env-body">Non-condensing humidity range of 40–60% RH prevents ink drying issues and ensures consistent drop formation from Piezo DOD print heads.</p>
            </div>
            <div class="env-card reveal" style="transition-delay:0.2s">
                <div class="env-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div class="env-value">24×7</div>
                <div class="env-title">Continuous Operation</div>
                <p class="env-body">The Razor6 is engineered for round-the-clock industrial production with robust print head durability, minimal maintenance cycles, and quick-access ink systems for non-stop throughput.</p>
            </div>
        </div>
    </section>



    <!-- CONTACT -->
    <section id="contact">
        <div class="contact-photo reveal">
            <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/61bcb317af56b916bbd53472_modes-footer-1.png" alt="Man and woman working together" />
        </div>
        <div class="contact-form-wrap reveal" style="transition-delay:0.1s">
            <div class="section-eyebrow">Get In Touch</div>
            <div class="contact-tagline">Ready to<br>shift into<br><span>production mode?</span></div>
            <p class="contact-body">Tell us about your production requirements and we'll configure the ideal Razor6 system for your line — including any ancillary equipment needed for a complete solution.</p>
            <div class="contact-highlights">
                <div class="contact-highlight">
                    <div class="ch-dot"></div>
                    Industrial inkjet for 24×7 environments
                </div>
                <div class="contact-highlight">
                    <div class="ch-dot"></div>
                    UV cured &amp; aqueous ink compatibility
                </div>
                <div class="contact-highlight">
                    <div class="ch-dot"></div>
                    Tracesci RapidPro VDP software included
                </div>
                <div class="contact-highlight">
                    <div class="ch-dot"></div>
                    Quick return on investment
                </div>
                <div class="contact-highlight">
                    <div class="ch-dot"></div>
                    Full ancillary equipment range available
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <!-- <footer>
        <div class="footer-top">
            <div>
                <div class="footer-logo">
                    <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/667306cdcfb3da4eb3545d25_Modes.svg" alt="Modes" />
                </div>
                <p class="footer-desc">Digital products and services consultancy for modern financial services organizations.</p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/modes_inc" target="_blank">
                        <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd764b9b8cbcdfb10af3b_social-ig.svg" alt="Instagram" />
                    </a>
                    <a href="https://www.linkedin.com/company/modesinc" target="_blank">
                        <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd7649a050e98000ac540_social-li.svg" alt="LinkedIn" />
                    </a>
                    <a href="https://twitter.com/modesInc" target="_blank">
                        <img src="https://cdn.prod.website-files.com/618bcfd8f178447ade4b3ba0/618bd76455bf3aaad72bddd0_social-tw.svg" alt="Twitter" />
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="https://www.modesinc.com/about">About</a></li>
                    <li><a href="https://www.modesinc.com/how-were-different">Why us</a></li>
                    <li><a href="https://www.modesinc.com/career">Work with us</a></li>
                    <li><a href="https://www.modesinc.com/privacy-policy">Privacy</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="https://www.modesinc.com/services">Transformation</a></li>
                    <li><a href="https://www.modesinc.com/services">Org Design</a></li>
                    <li><a href="https://www.modesinc.com/services">Change Management</a></li>
                    <li><a href="https://www.modesinc.com/alliances">Alliances</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    <li><a href="https://www.modesinc.com/ideas">IDEAS</a></li>
                    <li><a href="https://www.modesinc.com/connect">Connect</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Modes — All rights reserved</p>
            <p>Digital products and services consultancy</p>
        </div>
    </footer> -->

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
        const words = ['High Speed PDF Printing', 'UV Cured', 'Aqueous Inks', '24x7 Production Enviroments'];
        let idx = 0;
        const el = document.getElementById('rotateWord');
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
        el.style.transition = 'opacity 0.3s, transform 0.3s';
    </script>
</body>

</html>