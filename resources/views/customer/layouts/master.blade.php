@include('customer.layouts.__header')

<body>

    {{-- Spinner --}}
    <div id="spinner" class="show w-100 vh-100 position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center" style="z-index:9999;background:var(--spinner-bg)">
        <div style="text-align:center">
            <div style="width:40px;height:40px;border-radius:50%;border:3px solid var(--border-color);border-top-color:var(--brand);animation:spin .7s linear infinite;margin:0 auto 8px"></div>
            <div style="font-size:.75rem;color:var(--text-secondary);font-family:'Plus Jakarta Sans',sans-serif">Memuat...</div>
        </div>
    </div>

    {{-- Navbar --}}
    @include('customer.layouts.__navbar')

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('customer.layouts.__footer')

    {{-- Bottom Nav (mobile) --}}
    <nav class="rk-bottom-nav">
        <div class="nav-items">
            <a href="{{ route('menu') }}" class="nav-item {{ request()->routeIs('menu') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Menu</span>
            </a>
            <a href="{{ url('/cart') }}" class="nav-item {{ request()->routeIs('cart') ? 'active' : '' }}" style="position:relative">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                @php $cartCount = count(session('cart', [])); @endphp
                @if($cartCount > 0)
                    <span style="position:absolute;top:-2px;right:calc(50% - 18px);background:var(--brand);color:#fff;font-size:.6rem;font-weight:600;width:15px;height:15px;border-radius:50%;display:flex;align-items:center;justify-content:center">{{ $cartCount }}</span>
                @endif
                <span>Keranjang</span>
            </a>
            <a href="{{ route('checkout') }}" class="nav-item {{ request()->routeIs('checkout') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="6" width="20" height="12" rx="2"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span>Bayar</span>
            </a>
        </div>
    </nav>

    {{-- Back to top --}}
    <a href="#" class="rk-back-top" id="backTop">
        <i class="fas fa-arrow-up" style="font-size:.8rem"></i>
    </a>

    {{-- JS Libraries --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/customer/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/customer/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/customer/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/customer/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/main.js') }}"></script>

    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    <script>
        // ===== SPINNER =====
        window.addEventListener('load', function () {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.style.opacity = '0';
                spinner.style.transition = 'opacity .3s';
                setTimeout(() => spinner.remove(), 300);
            }
        });

        // ===== DARK MODE =====
        (function () {
            const saved = localStorage.getItem('rk-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
            updateThemeIcon(saved);
        })();

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('rk-theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (!icon) return;
            icon.innerHTML = theme === 'dark'
                ? '<i class="fas fa-sun"></i>'
                : '<i class="fas fa-moon"></i>';
        }

        // ===== BACK TO TOP =====
        window.addEventListener('scroll', function () {
            const btn = document.getElementById('backTop');
            if (btn) btn.classList.toggle('show', window.scrollY > 300);
        });

        document.getElementById('backTop')?.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ===== YEAR =====
        document.getElementById('currentYear').textContent = new Date().getFullYear();

        // ===== FILTER CHIPS =====
        document.querySelectorAll('.rk-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                const bar = this.closest('.rk-filter-bar');
                bar.querySelectorAll('.rk-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;

                // Filter section (mobile & desktop)
                document.querySelectorAll('.rk-menu-section').forEach(sec => {
                    sec.style.display = (!filter || filter === 'all' || sec.dataset.cat === filter) ? '' : 'none';
                });

                // Mobile rows
                document.querySelectorAll('.rk-menu-row').forEach(item => {
                    item.style.display = (!filter || filter === 'all' || item.dataset.cat === filter) ? '' : 'none';
                });

                // Desktop cards — pakai parent .col yang punya data-cat
                document.querySelectorAll('.col-sm-6[data-cat]').forEach(col => {
                    col.style.display = (!filter || filter === 'all' || col.dataset.cat === filter) ? '' : 'none';
                });
            });
        });

        // ===== PAYMENT OPTION =====
        document.querySelectorAll('.rk-pay-opt').forEach(opt => {
            opt.addEventListener('click', function () {
                document.querySelectorAll('.rk-pay-opt').forEach(o => o.classList.remove('selected'));
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
