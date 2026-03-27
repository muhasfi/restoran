<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Warung Nusantara' }}</title>
    <meta name="description" content="Warung Nusantara — Digital Menu">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

    <style>
    /* ============================================================
       CSS VARIABLES — LIGHT & DARK
    ============================================================ */
    :root,
    [data-theme="light"] {
        /* Brand */
        --amber:          #D4862B;
        --amber-light:    #F0A84A;
        --amber-pale:     #FDE8C4;
        --amber-ultra:    #FEF5E7;
        --brown-dark:     #2C1A0E;
        --brown-mid:      #5C3D1E;
        --brown-light:    #8B6340;

        /* Backgrounds */
        --bg-body:        #F5EFE6;
        --bg-card:        #FFFFFF;
        --bg-secondary:   #FFFAF4;
        --bg-tertiary:    #F0E8DA;
        --bg-sidebar:     #2C1A0E;

        /* Text */
        --text-primary:   #2C1A0E;
        --text-secondary: #8B7355;
        --text-muted:     #B0956E;
        --text-inverse:   #FFFFFF;

        /* Borders */
        --border:         #EDE0CC;
        --border-hover:   #D4862B;

        /* Navbar */
        --navbar-bg:      #2C1A0E;
        --navbar-text:    rgba(255,255,255,0.85);
        --navbar-muted:   rgba(255,255,255,0.5);

        /* Footer */
        --footer-bg:      #1A0E06;

        /* Shadows */
        --shadow-sm:      0 2px 8px rgba(44,26,14,0.08);
        --shadow-md:      0 4px 20px rgba(44,26,14,0.12);
        --shadow-lg:      0 8px 40px rgba(44,26,14,0.16);

        /* Status */
        --red:            #C0392B;
        --green:          #2D7A4F;
        --green-light:    #EBF7F0;

        /* Spinner */
        --spinner-bg:     #FFFAF4;
    }

    [data-theme="dark"] {
        /* Brand */
        --amber:          #F0A84A;
        --amber-light:    #F5BE75;
        --amber-pale:     #3A2010;
        --amber-ultra:    #2A1808;
        --brown-dark:     #F5E6D0;
        --brown-mid:      #C4A882;
        --brown-light:    #9A7A58;

        /* Backgrounds */
        --bg-body:        #160E06;
        --bg-card:        #1E1208;
        --bg-secondary:   #251608;
        --bg-tertiary:    #0E0804;
        --bg-sidebar:     #1A0E04;

        /* Text */
        --text-primary:   #F0E6D0;
        --text-secondary: #B09070;
        --text-muted:     #7A6040;
        --text-inverse:   #1A0E06;

        /* Borders */
        --border:         #3A2010;
        --border-hover:   #F0A84A;

        /* Navbar */
        --navbar-bg:      #0E0804;
        --navbar-text:    rgba(240,230,208,0.9);
        --navbar-muted:   rgba(240,230,208,0.45);

        /* Footer */
        --footer-bg:      #080502;

        /* Shadows */
        --shadow-sm:      0 2px 8px rgba(0,0,0,0.3);
        --shadow-md:      0 4px 20px rgba(0,0,0,0.4);
        --shadow-lg:      0 8px 40px rgba(0,0,0,0.5);

        /* Status */
        --red:            #E05C50;
        --green:          #4CAF80;
        --green-light:    #0E2A1A;

        /* Spinner */
        --spinner-bg:     #160E06;
    }

    /* ============================================================
       GLOBAL RESET & BASE
    ============================================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--bg-body);
        color: var(--text-primary);
        transition: background-color .3s, color .3s;
        min-height: 100vh;
    }

    a { color: var(--amber); text-decoration: none; }
    a:hover { color: var(--amber-light); }

    img { display: block; max-width: 100%; }

    button { font-family: 'DM Sans', sans-serif; }

    /* ============================================================
       SPINNER
    ============================================================ */
    #wn-spinner {
        position: fixed;
        inset: 0;
        background: var(--spinner-bg);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity .35s;
    }
    .wn-spinner-ring {
        width: 44px; height: 44px;
        border-radius: 50%;
        border: 3px solid var(--border);
        border-top-color: var(--amber);
        animation: wnSpin .75s linear infinite;
        margin-bottom: 12px;
    }
    .wn-spinner-text {
        font-size: .75rem;
        color: var(--text-muted);
        letter-spacing: 1px;
    }
    @keyframes wnSpin { to { transform: rotate(360deg); } }

    /* ============================================================
       NAVBAR (Top bar — desktop + mobile)
    ============================================================ */
    .wn-navbar {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 1000;
        background: var(--navbar-bg);
        border-bottom: 1px solid rgba(255,255,255,0.06);
        box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        transition: background .3s;
    }
    .wn-navbar-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    /* Brand */
    .wn-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
    .wn-brand-icon {
        width: 38px; height: 38px;
        background: var(--amber);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .wn-brand-text { line-height: 1; }
    .wn-brand-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }
    .wn-brand-sub {
        font-size: .68rem;
        color: var(--navbar-muted);
        margin-top: 2px;
    }

    /* Table chip in navbar */
    .wn-table-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(212,134,43,0.2);
        border: 1px solid rgba(212,134,43,0.35);
        color: var(--amber-light);
        font-size: .78rem;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 20px;
    }

    /* Right controls */
    .wn-nav-controls { display: flex; align-items: center; gap: 8px; }

    /* Cart button */
    .wn-cart-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(212,134,43,0.15);
        border: 1px solid rgba(212,134,43,0.3);
        color: var(--amber-light);
        padding: 8px 14px;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 500;
        text-decoration: none;
        transition: all .2s;
        cursor: pointer;
    }
    .wn-cart-btn:hover {
        background: rgba(212,134,43,0.25);
        border-color: var(--amber);
        color: var(--amber-light);
    }
    .wn-cart-badge {
        background: var(--amber);
        color: #fff;
        font-size: .65rem;
        font-weight: 700;
        min-width: 18px; height: 18px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
    }

    /* Theme toggle */
    .wn-theme-toggle {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--navbar-muted);
        padding: 7px 12px;
        border-radius: 10px;
        cursor: pointer;
        font-size: .82rem;
        font-weight: 500;
        transition: all .2s;
    }
    .wn-theme-toggle:hover {
        background: rgba(212,134,43,0.15);
        border-color: rgba(212,134,43,0.35);
        color: var(--amber-light);
    }
    .wn-toggle-track {
        width: 32px; height: 18px;
        border-radius: 9px;
        background: rgba(255,255,255,0.12);
        position: relative;
        transition: background .3s;
    }
    .wn-toggle-thumb {
        position: absolute;
        top: 2px; left: 2px;
        width: 14px; height: 14px;
        border-radius: 50%;
        background: var(--amber);
        transition: transform .3s;
    }
    [data-theme="dark"] .wn-toggle-thumb { transform: translateX(14px); background: #FACC15; }
    [data-theme="dark"] .wn-toggle-track { background: rgba(250,204,21,0.2); }

    /* Mobile menu toggle */
    .wn-menu-toggle {
        display: none;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.75);
        width: 38px; height: 38px;
        border-radius: 10px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1rem;
        transition: all .2s;
    }
    .wn-menu-toggle:hover { background: rgba(212,134,43,0.15); color: var(--amber-light); }

    /* Mobile dropdown nav */
    .wn-mobile-nav {
        display: none;
        background: var(--navbar-bg);
        border-top: 1px solid rgba(255,255,255,0.06);
        padding: 12px 20px 16px;
    }
    .wn-mobile-nav.open { display: block; }
    .wn-mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        color: var(--navbar-muted);
        font-size: .875rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        text-decoration: none;
        transition: color .2s;
    }
    .wn-mobile-nav-link:hover { color: var(--amber-light); }
    .wn-mobile-nav-link:last-child { border-bottom: none; }

    /* ============================================================
       LAYOUT WRAPPER — Sidebar + Content
    ============================================================ */
    .wn-layout {
        display: flex;
        min-height: calc(100vh - 64px);
        margin-top: 64px;
    }

    /* SIDEBAR (desktop only) */
    .wn-sidebar {
        width: 280px;
        flex-shrink: 0;
        background: var(--bg-sidebar);
        position: sticky;
        top: 64px;
        height: calc(100vh - 64px);
        overflow-y: auto;
        padding: 28px 20px;
        display: flex;
        flex-direction: column;
        gap: 0;
        scrollbar-width: thin;
        scrollbar-color: rgba(212,134,43,0.3) transparent;
        transition: background .3s;
    }
    [data-theme="dark"] .wn-sidebar { background: var(--bg-sidebar); }

    .wn-sidebar::-webkit-scrollbar { width: 4px; }
    .wn-sidebar::-webkit-scrollbar-track { background: transparent; }
    .wn-sidebar::-webkit-scrollbar-thumb { background: rgba(212,134,43,0.3); border-radius: 2px; }

    /* Sidebar restaurant card */
    .wn-sidebar-resto {
        background: rgba(212,134,43,0.12);
        border: 1px solid rgba(212,134,43,0.2);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .wn-sidebar-resto::before {
        content: '';
        position: absolute;
        top: -20px; right: -20px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(212,134,43,0.1);
        pointer-events: none;
    }
    .wn-sidebar-badge {
        display: inline-block;
        background: rgba(212,134,43,0.2);
        border: 1px solid rgba(212,134,43,0.35);
        color: var(--amber-light);
        font-size: .68rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
    }
    .wn-sidebar-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 6px;
    }
    [data-theme="dark"] .wn-sidebar-name { color: var(--text-primary); }
    .wn-sidebar-info {
        color: rgba(255,255,255,0.45);
        font-size: .75rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    [data-theme="dark"] .wn-sidebar-info { color: var(--text-muted); }

    /* Sidebar nav links */
    .wn-sidebar-nav { display: flex; flex-direction: column; gap: 4px; }
    .wn-sidebar-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border-radius: 12px;
        color: rgba(255,255,255,0.5);
        font-size: .875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all .2s;
    }
    [data-theme="dark"] .wn-sidebar-link { color: var(--text-muted); }
    .wn-sidebar-link:hover {
        background: rgba(212,134,43,0.12);
        color: var(--amber-light);
    }
    .wn-sidebar-link.active {
        background: var(--amber);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(212,134,43,0.35);
    }
    .wn-sidebar-link i { width: 16px; text-align: center; font-size: .85rem; }

    /* Sidebar category filter */
    .wn-sidebar-section-title {
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.25);
        padding: 20px 14px 8px;
    }
    [data-theme="dark"] .wn-sidebar-section-title { color: var(--text-muted); }
    .wn-sidebar-cat {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        border-radius: 10px;
        color: rgba(255,255,255,0.45);
        font-size: .82rem;
        cursor: pointer;
        transition: all .2s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }
    [data-theme="dark"] .wn-sidebar-cat { color: var(--text-muted); }
    .wn-sidebar-cat:hover { background: rgba(212,134,43,0.1); color: var(--amber-light); }
    .wn-sidebar-cat.active { background: rgba(212,134,43,0.15); color: var(--amber-light); }
    .wn-sidebar-cat.active i { color: var(--amber); }

    /* Sidebar table info */
    .wn-sidebar-table {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .wn-sidebar-table-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .wn-sidebar-table-icon {
        width: 36px; height: 36px;
        background: rgba(212,134,43,0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--amber);
        font-size: .85rem;
        flex-shrink: 0;
    }
    .wn-sidebar-table-label { font-size: .72rem; color: rgba(255,255,255,0.35); }
    [data-theme="dark"] .wn-sidebar-table-label { color: var(--text-muted); }
    .wn-sidebar-table-num { font-size: .9rem; font-weight: 600; color: var(--amber-light); }

    /* MAIN CONTENT area */
    .wn-main {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    /* ============================================================
       MOBILE HEADER HERO (visible only on mobile)
    ============================================================ */
    .wn-mobile-hero {
        display: none;
        background: var(--navbar-bg);
        padding: 24px 20px 28px;
        position: relative;
        overflow: hidden;
    }
    .wn-mobile-hero::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(212,134,43,0.12);
        pointer-events: none;
    }
    .wn-mobile-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 10px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(212,134,43,0.07);
        pointer-events: none;
    }
    .wn-mobile-hero-badge {
        display: inline-block;
        background: rgba(212,134,43,0.2);
        border: 1px solid rgba(212,134,43,0.35);
        color: var(--amber-light);
        font-size: .68rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
        position: relative; z-index: 1;
    }
    .wn-mobile-hero-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 6px;
        position: relative; z-index: 1;
    }
    .wn-mobile-hero-sub {
        color: rgba(255,255,255,0.5);
        font-size: .78rem;
        position: relative; z-index: 1;
    }
    .wn-mobile-table-chip {
        position: absolute;
        top: 20px; right: 20px;
        background: var(--amber);
        color: #fff;
        font-size: .72rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        z-index: 2;
    }

    /* ============================================================
       BOTTOM NAV (mobile only)
    ============================================================ */
    .wn-bottom-nav {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: var(--navbar-bg);
        border-top: 1px solid rgba(255,255,255,0.06);
        z-index: 999;
        padding: 8px 0 14px;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.25);
    }
    .wn-bottom-nav-items {
        display: flex;
        justify-content: space-around;
    }
    .wn-bottom-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        text-decoration: none;
        color: rgba(255,255,255,0.35);
        font-size: .62rem;
        font-weight: 500;
        padding: 4px 16px;
        border-radius: 10px;
        transition: color .2s;
        position: relative;
    }
    .wn-bottom-nav-item.active { color: var(--amber); }
    .wn-bottom-nav-item i { font-size: 1.1rem; }
    .wn-bottom-nav-badge {
        position: absolute;
        top: 0; right: 8px;
        background: var(--amber);
        color: #fff;
        font-size: .55rem;
        font-weight: 700;
        min-width: 16px; height: 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
    }

    /* ============================================================
       FILTER CHIPS (horizontal scroll, used in main content)
    ============================================================ */
    .wn-filter-bar {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 4px 0 12px;
    }
    .wn-filter-bar::-webkit-scrollbar { display: none; }
    .wn-chip {
        flex-shrink: 0;
        padding: 7px 18px;
        border-radius: 30px;
        font-size: .8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
        border: 1.5px solid var(--border);
        background: var(--bg-card);
        color: var(--text-secondary);
    }
    .wn-chip:hover { border-color: var(--amber); color: var(--amber); }
    .wn-chip.active {
        background: var(--brown-dark);
        color: #fff;
        border-color: var(--brown-dark);
    }
    [data-theme="dark"] .wn-chip.active {
        background: var(--amber);
        border-color: var(--amber);
    }

    /* ============================================================
       SECTION / CATEGORY LABEL
    ============================================================ */
    .wn-cat-label {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        padding: 20px 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .wn-cat-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ============================================================
       MENU CARD (Desktop grid)
    ============================================================ */
    .wn-menu-card {
        background: var(--bg-card);
        border-radius: 18px;
        border: 1px solid var(--border);
        overflow: hidden;
        transition: transform .2s, box-shadow .2s, border-color .2s;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .wn-menu-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--amber);
    }
    .wn-card-img {
        width: 100%; height: 160px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--amber-pale), #F5D5A0);
        display: block;
        transition: transform .3s;
    }
    .wn-menu-card:hover .wn-card-img { transform: scale(1.04); }
    .wn-card-img-wrap {
        height: 160px;
        overflow: hidden;
        background: var(--amber-pale);
        flex-shrink: 0;
        position: relative;
    }
    .wn-card-badge {
        position: absolute;
        top: 10px; left: 10px;
        background: var(--red);
        color: #fff;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        z-index: 1;
    }
    .wn-card-body {
        padding: 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .wn-card-name {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
        line-height: 1.3;
    }
    .wn-card-desc {
        font-size: .75rem;
        color: var(--text-secondary);
        line-height: 1.5;
        flex: 1;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .wn-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .wn-card-price {
        font-size: .95rem;
        font-weight: 700;
        color: var(--amber);
    }
    .wn-add-btn {
        background: var(--brown-dark);
        color: #fff;
        border: none;
        border-radius: 8px;
        width: 32px; height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background .2s, transform .15s;
        line-height: 1;
        flex-shrink: 0;
    }
    [data-theme="dark"] .wn-add-btn { background: var(--amber); color: #1A0E06; }
    .wn-add-btn:hover { background: var(--amber); transform: scale(1.05); }
    [data-theme="dark"] .wn-add-btn:hover { background: var(--amber-light); }
    .wn-add-btn:active { transform: scale(.92); }

    /* Category badge on card */
    .wn-badge-food { background: var(--amber-pale); color: var(--brown-mid); font-size: .68rem; font-weight: 600; padding: 2px 8px; border-radius: 6px; }
    .wn-badge-drink { background: #DBEAFE; color: #1E40AF; font-size: .68rem; font-weight: 600; padding: 2px 8px; border-radius: 6px; }
    [data-theme="dark"] .wn-badge-food { background: rgba(212,134,43,0.2); color: var(--amber-light); }
    [data-theme="dark"] .wn-badge-drink { background: rgba(37,99,235,0.2); color: #93C5FD; }

    /* ============================================================
       MENU ROW (Mobile list)
    ============================================================ */
    .wn-menu-row {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        margin-bottom: 10px;
        transition: border-color .2s, box-shadow .2s;
    }
    .wn-menu-row:hover { border-color: var(--amber); box-shadow: var(--shadow-sm); }
    .wn-row-thumb {
        width: 72px; height: 72px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--amber-pale);
    }
    .wn-row-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .wn-row-info { flex: 1; min-width: 0; }
    .wn-row-name {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 3px;
    }
    .wn-row-desc {
        font-size: .75rem;
        color: var(--text-secondary);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 5px;
    }
    .wn-row-price { font-size: .9rem; font-weight: 700; color: var(--amber); }
    .wn-add-btn-round {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--brown-dark);
        color: #fff;
        border: none;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: background .2s, transform .15s;
        line-height: 1;
    }
    [data-theme="dark"] .wn-add-btn-round { background: var(--amber); color: #1A0E06; }
    .wn-add-btn-round:hover { background: var(--amber); }
    [data-theme="dark"] .wn-add-btn-round:hover { background: var(--amber-light); }
    .wn-add-btn-round:active { transform: scale(.9); }

    /* ============================================================
       CART FAB (mobile sticky bar at bottom of menu)
    ============================================================ */
    .wn-cart-fab {
        position: sticky;
        bottom: 76px;
        margin: 16px 0 0;
        background: var(--brown-dark);
        color: #fff;
        border-radius: 16px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(44,26,14,0.35);
        transition: transform .2s, box-shadow .2s;
        z-index: 10;
    }
    .wn-cart-fab:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(44,26,14,0.4); color: #fff; }
    .wn-cart-fab-left { display: flex; align-items: center; gap: 10px; }
    .wn-cart-count {
        width: 26px; height: 26px;
        background: var(--amber);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        font-weight: 700;
    }
    .wn-cart-fab-text { font-size: .875rem; font-weight: 500; color: var(--amber-light); }
    .wn-cart-fab-price { font-size: .9rem; font-weight: 700; color: var(--amber-light); }

    /* ============================================================
       GENERIC CARD
    ============================================================ */
    .wn-card {
        background: var(--bg-card);
        border-radius: 18px;
        border: 1px solid var(--border);
        padding: 20px;
        transition: background .3s, border-color .3s;
    }

    /* ============================================================
       SUMMARY BOX
    ============================================================ */
    .wn-summary {
        background: var(--bg-secondary);
        border-radius: 14px;
        border: 1px solid var(--border);
        padding: 16px 18px;
        margin-bottom: 16px;
    }
    .wn-summary-row {
        display: flex;
        justify-content: space-between;
        font-size: .85rem;
        color: var(--text-secondary);
        padding: 5px 0;
    }
    .wn-summary-divider { border: none; border-top: 1px solid var(--border); margin: 8px 0; }
    .wn-summary-total {
        display: flex;
        justify-content: space-between;
        font-size: .95rem;
        font-weight: 700;
        color: var(--text-primary);
        padding-top: 4px;
    }
    .wn-summary-total-price { color: var(--amber) !important; }

    /* ============================================================
       CTA BUTTON
    ============================================================ */
    .wn-cta {
        display: block;
        width: 100%;
        background: var(--brown-dark);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 15px;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: background .2s, transform .15s, box-shadow .2s;
        font-family: 'DM Sans', sans-serif;
    }
    [data-theme="dark"] .wn-cta { background: var(--amber); color: #1A0E06; }
    .wn-cta:hover { background: var(--amber); color: #fff; box-shadow: 0 6px 20px rgba(212,134,43,0.35); }
    [data-theme="dark"] .wn-cta:hover { background: var(--amber-light); color: #1A0E06; }
    .wn-cta:active { transform: scale(.98); }

    /* ============================================================
       CART ITEM
    ============================================================ */
    .wn-cart-item {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        margin-bottom: 10px;
        transition: border-color .2s;
    }
    .wn-cart-item:hover { border-color: var(--border-hover); }
    .wn-cart-thumb {
        width: 60px; height: 60px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--amber-pale);
    }
    .wn-cart-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .wn-ci-info { flex: 1; min-width: 0; }
    .wn-ci-name { font-size: .875rem; font-weight: 600; color: var(--text-primary); margin-bottom: 2px; }
    .wn-ci-price { font-size: .75rem; color: var(--text-secondary); }
    .wn-qty-ctrl { display: flex; align-items: center; gap: 8px; }
    .wn-qty-btn {
        width: 30px; height: 30px;
        border-radius: 50%;
        border: 1.5px solid var(--border);
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
    .wn-qty-btn:hover { border-color: var(--amber); color: var(--amber); background: var(--amber-pale); }
    .wn-qty-val { font-size: .9rem; font-weight: 600; color: var(--text-primary); min-width: 22px; text-align: center; }
    .wn-ci-total { font-size: .875rem; font-weight: 700; color: var(--amber); min-width: 80px; text-align: right; }
    .wn-remove-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        border-radius: 8px;
        color: var(--red);
        transition: background .2s;
        font-size: .85rem;
    }
    .wn-remove-btn:hover { background: rgba(192,57,43,0.1); }
    @media (max-width: 480px) {
        .wn-cart-item {
            gap: 10px;
            padding: 10px;
        }

        .wn-cart-thumb {
            width: 48px;
            height: 48px;
        }

        .wn-qty-ctrl {
            gap: 4px;
        }

        .wn-qty-btn {
            width: 26px;
            height: 26px;
            font-size: .85rem;
        }

        .wn-ci-total {
            min-width: 70px;
            font-size: .8rem;
        }

        .wn-ci-name {
            font-size: .8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wn-ci-price {
            font-size: .7rem;
        }
    }
    

    /* ============================================================
       FORM FIELDS
    ============================================================ */
    .wn-form-label {
        font-size: .8rem;
        font-weight: 500;
        color: var(--text-secondary);
        display: block;
        margin-bottom: 6px;
    }
    .wn-form-control {
        width: 100%;
        background: var(--bg-secondary);
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 11px 14px;
        font-size: .875rem;
        color: var(--text-primary);
        font-family: 'DM Sans', sans-serif;
        transition: border-color .2s, background .3s;
        outline: none;
    }
    .wn-form-control:focus { border-color: var(--amber); background: var(--bg-card); }
    .wn-form-control::placeholder { color: var(--text-muted); }
    .wn-form-control:disabled { opacity: .8; cursor: not-allowed; color: var(--amber); font-weight: 600; }

    /* ============================================================
       PAYMENT OPTIONS
    ============================================================ */
    .wn-pay-opt {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        cursor: pointer;
        transition: all .2s;
        background: var(--bg-card);
        margin-bottom: 10px;
    }
    .wn-pay-opt:hover { border-color: var(--amber); }
    .wn-pay-opt.selected { border-color: var(--amber); background: var(--amber-ultra); }
    .wn-pay-radio {
        width: 20px; height: 20px;
        border-radius: 50%;
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: border-color .2s;
    }
    .wn-pay-opt.selected .wn-pay-radio { border-color: var(--amber); }
    .wn-pay-radio-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: var(--amber);
        display: none;
    }
    .wn-pay-opt.selected .wn-pay-radio-dot { display: block; }
    .wn-pay-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.3rem;
    }
    .wn-pay-icon.midtrans { background: #EFF6FF; }
    .wn-pay-icon.tunai { background: var(--green-light); }
    [data-theme="dark"] .wn-pay-icon.midtrans { background: rgba(37,99,235,0.15); }
    [data-theme="dark"] .wn-pay-icon.tunai { background: rgba(45,122,79,0.15); }
    .wn-pay-name { font-size: .875rem; font-weight: 600; color: var(--text-primary); }
    .wn-pay-desc { font-size: .75rem; color: var(--text-secondary); margin-top: 1px; }

    /* ============================================================
       RECEIPT / SUCCESS
    ============================================================ */
    .wn-receipt {
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border);
        max-width: 480px;
        margin: 0 auto;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }
    .wn-receipt-header {
        background: var(--brown-dark);
        padding: 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .wn-receipt-header::before {
        content: ''; position: absolute;
        top: -30px; right: -30px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(212,134,43,0.15);
    }
    .wn-receipt-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }
    .wn-receipt-order-id { font-size: .75rem; color: rgba(255,255,255,0.5); }

    .wn-success-circle {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: var(--green-light);
        border: 3px solid var(--green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--green);
        margin: 0 auto 12px;
    }
    .wn-receipt-body { padding: 20px 24px; }
    .wn-receipt-info { display: flex; justify-content: space-between; font-size: .82rem; padding: 7px 0; border-bottom: 1px solid var(--border); }
    .wn-receipt-info-label { color: var(--text-secondary); }
    .wn-receipt-info-val { font-weight: 500; color: var(--text-primary); }
    .wn-receipt-divider { border: none; border-top: 1px dashed var(--border); margin: 12px 0; }
    .wn-receipt-item { display: flex; justify-content: space-between; font-size: .82rem; padding: 6px 0; }
    .wn-receipt-item-name { font-weight: 500; color: var(--text-primary); }
    .wn-receipt-item-qty { font-size: .72rem; color: var(--text-secondary); margin-top: 2px; }
    .wn-receipt-total-row {
        display: flex;
        justify-content: space-between;
        font-size: .95rem;
        font-weight: 700;
        color: var(--text-primary);
        padding-top: 10px;
    }
    .wn-receipt-total-price { color: var(--amber); }
    .wn-receipt-pay-method {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 12px 14px;
        margin-top: 12px;
    }
    .wn-receipt-pay-text { font-size: .82rem; font-weight: 600; color: var(--text-primary); }
    .wn-receipt-pay-sub { font-size: .72rem; color: var(--text-secondary); }
    .wn-receipt-footer { background: var(--bg-secondary); padding: 16px 24px; text-align: center; border-top: 1px solid var(--border); }
    .wn-receipt-thank { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 4px; }
    .wn-receipt-note { font-size: .78rem; color: var(--text-secondary); }

    /* Status badges */
    .wn-status-pending { background: #FEF3C7; color: #92400E; font-size: .75rem; font-weight: 600; padding: 4px 14px; border-radius: 20px; display: inline-block; }
    .wn-status-success-badge { background: var(--green-light); color: var(--green); font-size: .75rem; font-weight: 600; padding: 4px 14px; border-radius: 20px; display: inline-block; }
    [data-theme="dark"] .wn-status-pending { background: rgba(146,64,14,0.2); color: #FCD34D; }

    /* Order code */
    .wn-order-code { font-size: 1.6rem; font-weight: 700; color: var(--amber); letter-spacing: 3px; }

    /* ============================================================
       SECTION TITLE (page-level)
    ============================================================ */
    .wn-page-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 4px;
    }
    .wn-page-subtitle { font-size: .85rem; color: var(--text-secondary); margin-bottom: 20px; }

    /* ============================================================
       ALERT
    ============================================================ */
    .wn-alert-success {
        background: var(--green-light);
        color: var(--green);
        border: 1px solid rgba(45,122,79,0.25);
        border-radius: 14px;
        padding: 12px 16px;
        font-size: .875rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    /* ============================================================
       EMPTY STATE
    ============================================================ */
    .wn-empty {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--text-secondary);
    }
    .wn-empty-icon { font-size: 3rem; opacity: .35; margin-bottom: 1rem; }

    /* ============================================================
       BACK TO TOP
    ============================================================ */
    .wn-back-top {
        position: fixed;
        bottom: 90px; right: 20px;
        width: 44px; height: 44px;
        border-radius: 50%;
        background: var(--brown-dark);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 998;
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s, transform .2s;
        box-shadow: var(--shadow-md);
        font-size: .8rem;
    }
    .wn-back-top.show { opacity: 1; pointer-events: all; }
    .wn-back-top:hover { transform: translateY(-2px); color: #fff; background: var(--amber); }

    /* ============================================================
       TOAST
    ============================================================ */
    #wn-toast {
        position: fixed;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--amber);
        color: #fff;
        padding: 11px 22px;
        border-radius: 20px;
        font-size: .82rem;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transition: all .3s;
        pointer-events: none;
        white-space: nowrap;
        box-shadow: var(--shadow-md);
    }
    #wn-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* ============================================================
       ANIMATIONS
    ============================================================ */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .wn-animate { animation: fadeInUp .35s ease both; }
    .wn-d1 { animation-delay: .05s; }
    .wn-d2 { animation-delay: .10s; }
    .wn-d3 { animation-delay: .15s; }
    .wn-d4 { animation-delay: .20s; }

    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 1023px) {
        .wn-sidebar { display: none; }
        .wn-mobile-hero { display: block; }
        .wn-bottom-nav { display: block; }
        /* body { padding-bottom: 60px; } */
        .wn-back-top { bottom: 80px; }
        #wn-toast { bottom: 90px; }
        .wn-cart-fab { bottom: 76px; }
    }

    @media (min-width: 1024px) {
        .wn-mobile-hero { display: none !important; }
        .wn-sidebar { display: flex; }
        .wn-menu-toggle { display: none !important; }
    }

    @media (max-width: 768px) {
        .wn-menu-toggle { display: flex; }
    }

    @media (max-width: 480px) {
        .wn-card-img { height: 130px; }
        .wn-card-img-wrap { height: 130px; }
    }

    .wn-alert-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;

        opacity: 0;
        pointer-events: none;
        transition: 0.25s;
        }

        .wn-alert-overlay.active {
        opacity: 1;
        pointer-events: auto;
        }

    .wn-alert-box {
        width: 90%;
        max-width: 320px;
        background: var(--bg-card);
        border-radius: 20px;
        padding: 24px 20px;
        text-align: center;
        box-shadow: var(--shadow-lg); 
        animation: wnPop .25s ease;
    }

    @keyframes wnPop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .wn-alert-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .wn-alert-title {
        font-weight: 700;
        font-size: 16px;
        color: var(--text-primary); 
        margin-bottom: 6px;
    }

    .wn-alert-text {
        font-size: 13px;
        color: #8B7355;
        margin-bottom: 18px;
    }

    .wn-alert-actions {
        display: flex;
        gap: 10px;
    }

    .wn-btn-cancel {
        flex: 1;
        padding: 10px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--bg-secondary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .wn-btn-danger {
        flex: 1;
        padding: 10px;
        border-radius: 12px;
        border: none;
        background: var(--red);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
    }
    </style>
</head>