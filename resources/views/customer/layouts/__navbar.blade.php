{{-- ========================================================
     NAVBAR — Warung Nusantara
     ======================================================== --}}
@php $cartCount = count(session('cart', [])); @endphp

<nav class="wn-navbar">
    <div class="wn-navbar-inner">

        {{-- Brand --}}
        <a href="{{ route('menu') }}" class="wn-brand">
            <div class="wn-brand-icon">🍜</div>
            <div class="wn-brand-text">
                <div class="wn-brand-name">Warung Nusantara</div>
                <div class="wn-brand-sub">Digital Menu</div>
            </div>
        </a>

        {{-- Table chip (visible when session has table number) --}}
        @if(session('table_number'))
            <div class="wn-table-chip">
                <i class="fas fa-qrcode"></i>
                Meja {{ session('table_number') }}
            </div>
        @endif

        {{-- Right Controls --}}
        <div class="wn-nav-controls">

            {{-- Cart (desktop) --}}
            {{-- <a href="{{ url('/cart') }}" class="wn-cart-btn d-none d-lg-inline-flex" style="text-decoration:none">
                <i class="fas fa-shopping-bag" style="font-size:.85rem"></i>
                <span style="font-size:.82rem">Keranjang</span>
                @if($cartCount > 0)
                    <span class="wn-cart-badge">{{ $cartCount }}</span>
                @endif
            </a> --}}

            {{-- Theme toggle --}}
            <button class="wn-theme-toggle" onclick="wnToggleTheme()" aria-label="Toggle dark mode">
                <div class="wn-toggle-track">
                    <div class="wn-toggle-thumb"></div>
                </div>
                <span id="wn-theme-icon" style="font-size:.8rem; color:rgba(255,255,255,0.6)">
                    <i class="fas fa-moon"></i>
                </span>
            </button>

            {{-- Mobile hamburger --}}
            <button class="wn-menu-toggle" id="wn-mobile-toggle" onclick="wnToggleMobileNav()" aria-label="Menu">
                <i class="fas fa-bars" id="wn-toggle-icon"></i>
            </button>
        </div>
    </div>

    {{-- Mobile dropdown nav --}}
    <div class="wn-mobile-nav" id="wn-mobile-nav">
        <a href="{{ route('menu') }}" class="wn-mobile-nav-link {{ request()->routeIs('menu') ? 'active' : '' }}"
           style="{{ request()->routeIs('menu') ? 'color:var(--amber-light)' : '' }}">
            <i class="fas fa-utensils" style="width:18px"></i> Menu
        </a>
        <a href="{{ url('/cart') }}" class="wn-mobile-nav-link {{ request()->routeIs('cart') ? 'active' : '' }}"
           style="{{ request()->routeIs('cart') ? 'color:var(--amber-light)' : '' }}">
            <i class="fas fa-shopping-bag" style="width:18px"></i> Keranjang
            @if($cartCount > 0)
                <span class="wn-cart-badge" style="position:static;padding:1px 7px;border-radius:10px;width:auto;height:auto">{{ $cartCount }}</span>
            @endif
        </a>
        <a href="{{ route('checkout') }}" class="wn-mobile-nav-link {{ request()->routeIs('checkout') ? 'active' : '' }}"
           style="{{ request()->routeIs('checkout') ? 'color:var(--amber-light)' : '' }}">
            <i class="fas fa-credit-card" style="width:18px"></i> Checkout
        </a>
    </div>
</nav>