@include('customer.layouts.__header')

<body>

{{-- ============ SPINNER ============ --}}
<div id="wn-spinner">
    <div class="wn-spinner-ring"></div>
    <div class="wn-spinner-text">Memuat...</div>
</div>

{{-- ============ NAVBAR ============ --}}
@include('customer.layouts.__navbar')

{{-- ============ LAYOUT WRAPPER ============ --}}
<div class="wn-layout">

    {{-- SIDEBAR (desktop only) --}}
    @php $cartCount = count(session('cart', [])); @endphp
    <aside class="wn-sidebar">

        {{-- Resto card --}}
        <div class="wn-sidebar-resto">
            <div class="wn-sidebar-badge">✦ Digital Menu</div>
            <div class="wn-sidebar-name">Warung Nusantara</div>
            <div class="wn-sidebar-info">
                <i class="fas fa-circle" style="font-size:6px;color:var(--amber)"></i>
                Buka · 10:00 – 22:00 WIB
            </div>
            @if(session('table_number'))
                <div style="margin-top:12px;display:inline-flex;align-items:center;gap:6px;background:var(--amber);color:#fff;font-size:.75rem;font-weight:600;padding:5px 12px;border-radius:20px">
                    <i class="fas fa-utensils" style="font-size:.7rem"></i>
                    Meja {{ session('table_number') }}
                </div>
            @endif
        </div>

        {{-- Nav links --}}
        <div class="wn-sidebar-nav">
            <a href="{{ route('menu') }}" class="wn-sidebar-link {{ request()->routeIs('menu') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Menu
            </a>
            <a href="{{ url('/cart') }}" class="wn-sidebar-link {{ request()->routeIs('cart') ? 'active' : '' }}" style="position:relative">
                <i class="fas fa-shopping-bag"></i> Keranjang
                @if($cartCount > 0)
                    <span style="margin-left:auto;background:var(--amber);color:#fff;font-size:.65rem;font-weight:700;min-width:20px;height:20px;border-radius:10px;display:flex;align-items:center;justify-content:center;padding:0 5px">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('checkout') }}" class="wn-sidebar-link {{ request()->routeIs('checkout') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Checkout
            </a>
        </div>

        {{-- Category filter (only visible on menu page) --}}
        @if(request()->routeIs('menu'))
        <div>
            <div class="wn-sidebar-section-title">Kategori</div>
            <button class="wn-sidebar-cat active" data-filter="all">
                <i class="fas fa-border-all"></i> Semua Menu
            </button>
            <button class="wn-sidebar-cat" data-filter="Makanan">
                <i class="fas fa-utensils"></i> Makanan
            </button>
            <button class="wn-sidebar-cat" data-filter="Minuman">
                <i class="fas fa-glass-whiskey"></i> Minuman
            </button>
        </div>
        @endif

        {{-- Table info --}}
        <div class="wn-sidebar-table">
            <div class="wn-sidebar-table-card">
                <div class="wn-sidebar-table-icon">
                    <i class="fas fa-qrcode"></i>
                </div>
                <div>
                    <div class="wn-sidebar-table-label">Nomor Meja</div>
                    <div class="wn-sidebar-table-num">
                        {{ session('table_number') ? 'Meja '.session('table_number') : 'Scan QR Meja' }}
                    </div>
                </div>
            </div>
        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="wn-main">

        {{-- Mobile hero header --}}
        <div class="wn-mobile-hero">
            <div class="wn-mobile-hero-badge">✦ Digital Menu</div>
            <div class="wn-mobile-hero-name">Warung Nusantara</div>
            <div class="wn-mobile-hero-sub">
                <i class="fas fa-circle" style="font-size:6px;color:var(--amber);margin-right:4px"></i>
                Buka · 10:00 – 22:00 WIB
            </div>
            @if(session('table_number'))
                <div class="wn-mobile-table-chip">Meja {{ session('table_number') }}</div>
            @endif
        </div>

        {{-- Page content --}}
        <div style="flex:1; padding: 24px; max-width: 1200px; width: 100%;">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('customer.layouts.__footer')

    </main>

</div>

{{-- ============ BOTTOM NAV (mobile) ============ --}}
{{-- <nav class="wn-bottom-nav">
    <div class="wn-bottom-nav-items">
        <a href="{{ route('menu') }}" class="wn-bottom-nav-item {{ request()->routeIs('menu') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            <span>Menu</span>
        </a>
        <a href="{{ url('/cart') }}" class="wn-bottom-nav-item {{ request()->routeIs('cart') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i>
            @if($cartCount > 0)
                <span class="wn-bottom-nav-badge">{{ $cartCount }}</span>
            @endif
            <span>Keranjang</span>
        </a>
        <a href="{{ route('checkout') }}" class="wn-bottom-nav-item {{ request()->routeIs('checkout') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i>
            <span>Bayar</span>
        </a>
    </div>
</nav> --}}

{{-- ============ BACK TO TOP ============ --}}
<a href="#" class="wn-back-top" id="wn-back-top">
    <i class="fas fa-arrow-up"></i>
</a>

{{-- ============ TOAST ============ --}}
<div id="wn-toast"></div>

{{-- ============ JS LIBRARIES ============ --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* ====== SPINNER ====== */
window.addEventListener('load', function () {
    const spinner = document.getElementById('wn-spinner');
    if (spinner) {
        spinner.style.opacity = '0';
        setTimeout(() => spinner.remove(), 350);
    }
});

/* ====== DARK MODE ====== */
(function () {
    const saved = localStorage.getItem('wn-theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    updateThemeIcon(saved);
})();

function wnToggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('wn-theme', next);
    updateThemeIcon(next);
}

function updateThemeIcon(theme) {
    const icon = document.getElementById('wn-theme-icon');
    if (!icon) return;
    icon.innerHTML = theme === 'dark'
        ? '<i class="fas fa-sun"></i>'
        : '<i class="fas fa-moon"></i>';
}

/* ====== MOBILE NAV TOGGLE ====== */
function wnToggleMobileNav() {
    const nav = document.getElementById('wn-mobile-nav');
    const icon = document.getElementById('wn-toggle-icon');
    if (!nav) return;
    nav.classList.toggle('open');
    if (icon) {
        icon.className = nav.classList.contains('open') ? 'fas fa-times' : 'fas fa-bars';
    }
}

/* ====== BACK TO TOP ====== */
window.addEventListener('scroll', function () {
    const btn = document.getElementById('wn-back-top');
    if (btn) btn.classList.toggle('show', window.scrollY > 300);
});
document.getElementById('wn-back-top')?.addEventListener('click', function (e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* ====== YEAR ====== */
const yrEl = document.getElementById('wn-year');
if (yrEl) yrEl.textContent = new Date().getFullYear();

/* ====== TOAST ====== */
function showToast(msg) {
    const t = document.getElementById('wn-toast');
    if (!t) return;
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2500);
}

/* ====== FILTER CHIPS (sidebar cats + top chips) ====== */
function applyFilter(filter) {
    // Sections
    document.querySelectorAll('.wn-menu-section').forEach(sec => {
        sec.style.display = (!filter || filter === 'all' || sec.dataset.cat === filter) ? '' : 'none';
    });
    // Mobile rows
    document.querySelectorAll('.wn-menu-row').forEach(item => {
        item.style.display = (!filter || filter === 'all' || item.dataset.cat === filter) ? '' : 'none';
    });
    // Desktop card cols
    document.querySelectorAll('[data-cat]').forEach(col => {
        if (col.classList.contains('wn-col-item')) {
            col.style.display = (!filter || filter === 'all' || col.dataset.cat === filter) ? '' : 'none';
        }
    });
}

// Top chips
document.querySelectorAll('.wn-chip').forEach(chip => {
    chip.addEventListener('click', function () {
        document.querySelectorAll('.wn-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        // Sync sidebar cats
        const filter = this.dataset.filter;
        document.querySelectorAll('.wn-sidebar-cat').forEach(c => {
            c.classList.toggle('active', c.dataset.filter === filter);
        });
        applyFilter(filter);
    });
});

// Sidebar cats
document.querySelectorAll('.wn-sidebar-cat').forEach(cat => {
    cat.addEventListener('click', function () {
        document.querySelectorAll('.wn-sidebar-cat').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        // Sync top chips
        const filter = this.dataset.filter;
        document.querySelectorAll('.wn-chip').forEach(c => {
            c.classList.toggle('active', c.dataset.filter === filter);
        });
        applyFilter(filter);
    });
});

/* ====== PAYMENT OPTION ====== */
document.querySelectorAll('.wn-pay-opt').forEach(opt => {
    opt.addEventListener('click', function () {
        document.querySelectorAll('.wn-pay-opt').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
        const val = this.dataset.value;
        const radio = document.querySelector(`input[name="payment_method"][value="${val}"]`);
        if (radio) radio.checked = true;
    });
});
</script>

@yield('script')
</body>
</html>