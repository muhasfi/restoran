<nav class="rk-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-2">

            {{-- Brand --}}
            <a href="{{ route('menu') }}" class="text-decoration-none">
                <div class="navbar-brand-name">Restoranku</div>
                <div class="navbar-brand-sub">Pilihan Lezat di Ujung Jari</div>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="d-none d-lg-flex align-items-center gap-2">
                <a href="{{ route('menu') }}" class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}">
                    <i class="fas fa-utensils me-1"></i> Menu
                </a>
            </div>

            {{-- Right Controls --}}
            <div class="d-flex align-items-center gap-2">

                {{-- Cart --}}
                <a href="{{ url('/cart') }}" class="rk-cart-btn text-decoration-none">
                    <i class="fas fa-shopping-bag" style="font-size:.9rem"></i>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="rk-cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                {{-- Dark Mode Toggle --}}
                <button class="rk-theme-toggle" onclick="toggleTheme()" aria-label="Toggle dark mode">
                    <div class="rk-toggle-track">
                        <div class="rk-toggle-thumb"></div>
                    </div>
                    <span class="rk-toggle-icon" id="theme-icon">
                        <i class="fas fa-moon"></i>
                    </span>
                </button>

                {{-- Mobile hamburger --}}
                <button class="navbar-toggler d-lg-none border-0 bg-transparent p-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-label="Toggle navigation">
                    <i class="fas fa-bars" style="color:var(--text-primary)"></i>
                </button>
            </div>
        </div>

        {{-- Mobile collapse nav --}}
        <div class="collapse d-lg-none" id="mobileNav">
            <div class="py-2 border-top" style="border-color:var(--border-color)!important">
                <a href="{{ route('menu') }}"
                   class="d-flex align-items-center gap-2 py-2 px-1 text-decoration-none"
                   style="color:var(--text-secondary);font-size:.875rem">
                    <i class="fas fa-utensils" style="width:16px"></i> Menu
                </a>
                <a href="{{ url('/cart') }}"
                   class="d-flex align-items-center gap-2 py-2 px-1 text-decoration-none"
                   style="color:var(--text-secondary);font-size:.875rem">
                    <i class="fas fa-shopping-bag" style="width:16px"></i> Keranjang
                    @if($cartCount > 0)
                        <span class="rk-cart-badge" style="position:static;width:auto;height:auto;padding:1px 7px;border-radius:10px">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Page Hero Header --}}
<div class="rk-page-hero">
    <h1>Menu Kami</h1>
    <p>Scan QR meja Anda, lalu pilih menu favorit</p>
    @if(session('table_number'))
        <div class="rk-meja-badge">
            <i class="fas fa-qrcode" style="font-size:.75rem"></i>
            Meja {{ session('table_number') }}
        </div>
    @endif
</div>
