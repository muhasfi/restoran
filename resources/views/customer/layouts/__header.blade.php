<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="utf-8">
    <title>Restoranku</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Icon Font -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="{{ asset('assets/customer/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/customer/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{ asset('assets/customer/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/customer/css/style.css') }}" rel="stylesheet">

    <style>
        /* ===== CSS VARIABLES — LIGHT & DARK MODE ===== */
        :root,
        [data-theme="light"] {
            --brand:          #e67e22;
            --brand-dark:     #d35400;
            --brand-light:    #fef3e2;
            --brand-muted:    #fde68a;

            --bg-primary:     #ffffff;
            --bg-secondary:   #f8f9fa;
            --bg-tertiary:    #f1f3f5;
            --bg-card:        #ffffff;

            --text-primary:   #1a1a2e;
            --text-secondary: #6c757d;
            --text-muted:     #adb5bd;

            --border-color:   #e9ecef;
            --border-hover:   #dee2e6;

            --navbar-bg:      #ffffff;
            --footer-bg:      #1a1a2e;
            --shadow-sm:      0 2px 8px rgba(0,0,0,.06);
            --shadow-md:      0 4px 16px rgba(0,0,0,.08);

            --badge-mk-bg:    #fde68a;
            --badge-mk-text:  #92400e;
            --badge-mn-bg:    #bfdbfe;
            --badge-mn-text:  #1e40af;

            --spinner-bg:     #ffffff;
        }

        [data-theme="dark"] {
            --brand:          #f39c3d;
            --brand-dark:     #e67e22;
            --brand-light:    #3a2010;
            --brand-muted:    #4a2e0a;

            --bg-primary:     #1e1e2e;
            --bg-secondary:   #252535;
            --bg-tertiary:    #16161f;
            --bg-card:        #252535;

            --text-primary:   #e8e8f0;
            --text-secondary: #9a9ab0;
            --text-muted:     #5a5a70;

            --border-color:   #2e2e42;
            --border-hover:   #3a3a52;

            --navbar-bg:      #1e1e2e;
            --footer-bg:      #111118;
            --shadow-sm:      0 2px 8px rgba(0,0,0,.25);
            --shadow-md:      0 4px 16px rgba(0,0,0,.35);

            --badge-mk-bg:    #3a2e10;
            --badge-mk-text:  #fbbf24;
            --badge-mn-bg:    #0f2040;
            --badge-mn-text:  #60a5fa;

            --spinner-bg:     #1e1e2e;
        }

        /* ===== GLOBAL BASE ===== */
        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            transition: background-color .3s, color .3s;
        }

        a { color: var(--brand); text-decoration: none; }
        a:hover { color: var(--brand-dark); }

        /* ===== SPINNER ===== */
        #spinner {
            background-color: var(--spinner-bg) !important;
            z-index: 9999;
        }

        /* ===== NAVBAR ===== */
        .rk-navbar {
            background: var(--navbar-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            transition: background .3s, border-color .3s;
        }
        .rk-navbar .navbar-brand-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--brand);
            line-height: 1;
        }
        .rk-navbar .navbar-brand-sub {
            font-size: .7rem;
            color: var(--text-secondary);
            font-weight: 400;
        }
        .rk-navbar .nav-link {
            color: var(--text-secondary) !important;
            font-size: .875rem;
            font-weight: 500;
            padding: .5rem 1rem !important;
            border-radius: 8px;
            transition: all .2s;
        }
        .rk-navbar .nav-link:hover,
        .rk-navbar .nav-link.active {
            color: var(--brand) !important;
            background: var(--brand-light);
        }

        /* Cart icon */
        .rk-cart-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            transition: all .2s;
        }
        .rk-cart-btn:hover { background: var(--brand-light); border-color: var(--brand); color: var(--brand); }
        .rk-cart-badge {
            position: absolute;
            top: -4px; right: -4px;
            background: var(--brand);
            color: #fff;
            font-size: .65rem;
            font-weight: 600;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dark mode toggle */
        .rk-theme-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px 8px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            transition: all .2s;
        }
        .rk-theme-toggle:hover { border-color: var(--brand); }
        .rk-toggle-track {
            width: 36px; height: 20px;
            border-radius: 10px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            position: relative;
            transition: background .3s;
        }
        .rk-toggle-thumb {
            position: absolute;
            top: 2px; left: 2px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: var(--brand);
            transition: transform .3s;
        }
        [data-theme="dark"] .rk-toggle-thumb { transform: translateX(16px); background: #facc15; }
        [data-theme="dark"] .rk-toggle-track { background: #374151; border-color: #4a4a60; }
        .rk-toggle-icon { font-size: .8rem; color: var(--text-secondary); }

        /* Navbar toggler */
        .rk-navbar .navbar-toggler {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 10px;
            background: var(--bg-secondary);
        }
        .rk-navbar .navbar-toggler-icon { color: var(--text-primary); }

        /* ===== PAGE HERO HEADER ===== */
        .rk-page-hero {
            background: var(--brand);
            padding: 5rem 1rem 2rem;
            text-align: center;
            margin-top: 65px;
        }
        .rk-page-hero h1 {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: .3rem;
        }
        .rk-page-hero p {
            color: rgba(255,255,255,.85);
            font-size: .875rem;
            margin-bottom: .75rem;
        }
        .rk-meja-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,.2);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 20px;
            padding: 4px 14px;
            color: #fff;
            font-size: .8rem;
            font-weight: 500;
        }

        /* ===== FILTER CHIPS ===== */
        .rk-filter-bar {
            display: flex;
            gap: 8px;
            padding: .75rem 0;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .rk-filter-bar::-webkit-scrollbar { display: none; }
        .rk-chip {
            flex-shrink: 0;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 500;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all .2s;
        }
        .rk-chip:hover { border-color: var(--brand); color: var(--brand); }
        .rk-chip.active {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }

        /* ===== CATEGORY LABEL ===== */
        .rk-cat-label {
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 1rem 0 .5rem;
        }

        /* ===== MENU CARD (Desktop grid) ===== */
        .rk-menu-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .rk-menu-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--brand);
        }
        .rk-menu-card .card-img-wrap {
            position: relative;
            height: 160px;
            overflow: hidden;
            background: var(--bg-secondary);
        }
        .rk-menu-card .card-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }
        .rk-menu-card:hover .card-img-wrap img { transform: scale(1.05); }
        .rk-menu-card .card-body { padding: 14px; }
        .rk-menu-card .card-title {
            font-size: .9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        .rk-menu-card .card-desc {
            font-size: .78rem;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .rk-menu-card .card-footer-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .rk-price {
            font-size: .95rem;
            font-weight: 600;
            color: var(--brand);
        }

        /* ===== MENU ROW (Mobile list) ===== */
        .rk-menu-row {
            background: var(--bg-card);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            transition: box-shadow .2s, border-color .2s;
            margin-bottom: 10px;
        }
        .rk-menu-row:hover {
            border-color: var(--brand);
            box-shadow: var(--shadow-sm);
        }
        .rk-menu-row .row-thumb {
            width: 70px; height: 70px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--bg-secondary);
        }
        .rk-menu-row .row-thumb img {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .rk-menu-row .row-info { flex: 1; min-width: 0; }
        .rk-menu-row .row-name {
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .rk-menu-row .row-desc {
            font-size: .75rem;
            color: var(--text-secondary);
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .rk-menu-row .row-price {
            font-size: .875rem;
            font-weight: 600;
            color: var(--brand);
            margin-top: 4px;
        }

        /* ===== CATEGORY BADGE ===== */
        .rk-badge-mk {
            background: var(--badge-mk-bg);
            color: var(--badge-mk-text);
            font-size: .7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 10px;
        }
        .rk-badge-mn {
            background: var(--badge-mn-bg);
            color: var(--badge-mn-text);
            font-size: .7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 10px;
        }

        /* ===== ADD TO CART BUTTON ===== */
        .rk-add-btn {
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: .78rem;
            font-weight: 500;
            cursor: pointer;
            transition: background .2s, transform .15s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .rk-add-btn:hover { background: var(--brand-dark); }
        .rk-add-btn:active { transform: scale(.96); }

        .rk-add-btn-round {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            border: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .2s, transform .15s;
            line-height: 1;
        }
        .rk-add-btn-round:hover { background: var(--brand-dark); }
        .rk-add-btn-round:active { transform: scale(.92); }

        /* ===== CARD (generic) ===== */
        .rk-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 1.25rem;
            transition: background .3s, border-color .3s;
        }

        /* ===== SUMMARY BOX ===== */
        .rk-summary {
            background: var(--bg-secondary);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
        }
        .rk-summary-row {
            display: flex;
            justify-content: space-between;
            font-size: .85rem;
            color: var(--text-secondary);
            padding: 5px 0;
        }
        .rk-summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
            margin-top: 6px;
        }

        /* ===== CTA BUTTON ===== */
        .rk-cta {
            width: 100%;
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s;
            display: block;
            text-align: center;
        }
        .rk-cta:hover { background: var(--brand-dark); color: #fff; }
        .rk-cta:active { transform: scale(.98); }

        /* ===== CART ITEM ===== */
        .rk-cart-item {
            background: var(--bg-card);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            margin-bottom: 10px;
            transition: border-color .2s;
        }
        .rk-cart-item:hover { border-color: var(--border-hover); }
        .rk-cart-thumb {
            width: 56px; height: 56px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--bg-secondary);
        }
        .rk-cart-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .rk-ci-info { flex: 1; min-width: 0; }
        .rk-ci-name {
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .rk-ci-price {
            font-size: .75rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }
        .rk-qty-ctrl {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .rk-qty-btn {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            line-height: 1;
        }
        .rk-qty-btn:hover { border-color: var(--brand); color: var(--brand); background: var(--brand-light); }
        .rk-qty-val {
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-primary);
            min-width: 20px;
            text-align: center;
        }
        .rk-ci-total {
            font-size: .875rem;
            font-weight: 600;
            color: var(--brand);
            min-width: 75px;
            text-align: right;
        }
        .rk-remove-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            color: #e24b4a;
            transition: background .2s;
        }
        .rk-remove-btn:hover { background: #fee2e2; }

        /* ===== FORM ===== */
        .rk-form-label {
            font-size: .8rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 6px;
            display: block;
        }
        .rk-form-control {
            width: 100%;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .875rem;
            color: var(--text-primary);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color .2s, background .3s;
            outline: none;
        }
        .rk-form-control:focus { border-color: var(--brand); background: var(--bg-primary); }
        .rk-form-control::placeholder { color: var(--text-muted); }
        .rk-form-control:disabled {
            opacity: .8;
            cursor: not-allowed;
            color: var(--brand);
            font-weight: 600;
        }

        /* ===== PAYMENT OPTION ===== */
        .rk-pay-opt {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            background: var(--bg-card);
            margin-bottom: 8px;
        }
        .rk-pay-opt:hover { border-color: var(--brand); }
        .rk-pay-opt.selected {
            border-color: var(--brand);
            background: var(--brand-light);
        }
        .rk-pay-radio {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: border-color .2s;
        }
        .rk-pay-opt.selected .rk-pay-radio { border-color: var(--brand); }
        .rk-pay-radio-inner {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--brand);
            display: none;
        }
        .rk-pay-opt.selected .rk-pay-radio-inner { display: block; }
        .rk-pay-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .rk-pay-icon.qris { background: #eff6ff; }
        .rk-pay-icon.tunai { background: #f0fdf4; }
        .rk-pay-lbl {
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .rk-pay-sub {
            font-size: .75rem;
            color: var(--text-secondary);
            margin-top: 1px;
        }

        /* ===== BOTTOM NAV (mobile) ===== */
        .rk-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: var(--navbar-bg);
            border-top: 1px solid var(--border-color);
            z-index: 999;
            padding: 8px 0 12px;
            box-shadow: 0 -4px 12px rgba(0,0,0,.06);
        }
        .rk-bottom-nav .nav-items {
            display: flex;
            justify-content: space-around;
        }
        .rk-bottom-nav .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-secondary);
            transition: color .2s;
        }
        .rk-bottom-nav .nav-item.active { color: var(--brand); }
        .rk-bottom-nav .nav-item span {
            font-size: .65rem;
            font-weight: 500;
        }

        /* ===== SECTION TITLE ===== */
        .rk-section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: .75rem;
        }

        /* ===== ALERT ===== */
        .rk-alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 1rem;
            font-size: .875rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ===== RECEIPT ===== */
        .rk-receipt {
            background: var(--bg-card);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            padding: 1.75rem 1.5rem;
            max-width: 440px;
            margin: 0 auto;
            text-align: center;
        }
        .rk-success-icon {
            width: 60px; height: 60px;
            border-radius: 50%;
            background: #d1fae5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .rk-order-code {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--brand);
            letter-spacing: 3px;
            margin: .5rem 0;
        }
        .rk-receipt-row {
            display: flex;
            justify-content: space-between;
            font-size: .8rem;
            color: var(--text-secondary);
            padding: 6px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .rk-receipt-total {
            display: flex;
            justify-content: space-between;
            font-size: .95rem;
            font-weight: 600;
            color: var(--text-primary);
            padding-top: 10px;
        }

        /* ===== STATUS BADGE ===== */
        .rk-status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 500;
            margin-bottom: .75rem;
        }
        .rk-status-pending { background: #fef3c7; color: #92400e; }
        .rk-status-success { background: #d1fae5; color: #065f46; }

        /* ===== EMPTY STATE ===== */
        .rk-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }
        .rk-empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: .5;
        }

        /* ===== BACK TO TOP ===== */
        .rk-back-top {
            position: fixed;
            bottom: 80px; right: 20px;
            width: 42px; height: 42px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
            box-shadow: var(--shadow-md);
        }
        .rk-back-top.show { opacity: 1; pointer-events: all; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .rk-bottom-nav { display: block; }
            body { padding-bottom: 70px; }
            .rk-page-hero { margin-top: 60px; padding-top: 4rem; }
            .rk-back-top { bottom: 80px; }
        }

        @media (min-width: 769px) {
            .rk-page-hero { margin-top: 65px; }
        }

        /* ===== ANIMATION ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .rk-animate { animation: fadeInUp .35s ease both; }
        .rk-animate-d1 { animation-delay: .05s; }
        .rk-animate-d2 { animation-delay: .1s; }
        .rk-animate-d3 { animation-delay: .15s; }
    </style>
</head>
