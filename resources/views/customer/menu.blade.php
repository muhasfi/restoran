@extends('customer.layouts.master')

@section('content')
<div class="container py-4">

    {{-- Filter Bar --}}
    <div class="rk-filter-bar">
        <div class="rk-chip active" data-filter="all">Semua</div>
        <div class="rk-chip" data-filter="Makanan">
            <i class="fas fa-utensils me-1" style="font-size:.7rem"></i> Makanan
        </div>
        <div class="rk-chip" data-filter="Minuman">
            <i class="fas fa-glass-whiskey me-1" style="font-size:.7rem"></i> Minuman
        </div>
    </div>

    {{-- ========== MOBILE VIEW (< md) ========== --}}
    <div class="d-md-none">
        @php
            $grouped = $items->groupBy(fn($item) => $item->category->category_name);
        @endphp

        @foreach($grouped as $catName => $catItems)
            <div class="rk-menu-section" data-cat="{{ $catName }}">
                <div class="rk-cat-label">
                    @if($catName === 'Makanan')
                        <i class="fas fa-utensils me-1" style="color:var(--brand)"></i>
                    @elseif($catName === 'Minuman')
                        <i class="fas fa-glass-whiskey me-1" style="color:var(--brand)"></i>
                    @endif
                    {{ $catName }}
                </div>

                @foreach($catItems as $item)
                    <div class="rk-menu-row rk-animate" data-cat="{{ $catName }}">
                        <div class="row-thumb">
                            <img src="{{ $item->img }}"
                                 alt="{{ $item->name }}"
                                 onerror="this.onerror=null;this.src='https://via.placeholder.com/70x70?text=No+Img'">
                        </div>
                        <div class="row-info">
                            <div class="row-name">{{ $item->name }}</div>
                            <div class="row-desc">{{ $item->description }}</div>
                            <div class="row-price">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                        <button class="rk-add-btn-round" onclick="addToCart({{ $item->id }})" aria-label="Tambah ke keranjang">+</button>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- ========== DESKTOP VIEW (>= md) ========== --}}
    <div class="d-none d-md-block">
        @foreach($grouped as $catName => $catItems)
            <div class="rk-menu-section" data-cat="{{ $catName }}">
                <div class="rk-cat-label">
                    @if($catName === 'Makanan')
                        <i class="fas fa-utensils me-1" style="color:var(--brand)"></i>
                    @elseif($catName === 'Minuman')
                        <i class="fas fa-glass-whiskey me-1" style="color:var(--brand)"></i>
                    @endif
                    {{ $catName }}
                </div>
                <div class="row g-3 mb-2">
                    @foreach($catItems as $i => $item)
                        <div class="col-sm-6 col-lg-4 col-xl-3 rk-animate" style="animation-delay:{{ $i * 0.05 }}s" data-cat="{{ $catName }}">
                            <div class="rk-menu-card h-100">
                                <div class="card-img-wrap">
                                    <img src="{{ $item->img }}"
                                         alt="{{ $item->name }}"
                                         onerror="this.onerror=null;this.src='https://via.placeholder.com/300x160?text=No+Img'">
                                    <span class="position-absolute top-0 start-0 m-2
                                        @if($catName === 'Makanan') rk-badge-mk
                                        @elseif($catName === 'Minuman') rk-badge-mn
                                        @else rk-badge-mk @endif">
                                        {{ $catName }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="card-title">{{ $item->name }}</div>
                                    <div class="card-desc">{{ $item->description }}</div>
                                    <div class="card-footer-wrap">
                                        <span class="rk-price">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                        <button class="rk-add-btn" onclick="addToCart({{ $item->id }})">
                                            <i class="fas fa-plus" style="font-size:.7rem"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @if($items->isEmpty())
        <div class="rk-empty">
            <div class="rk-empty-icon"><i class="fas fa-utensils"></i></div>
            <div style="font-size:.95rem;font-weight:500;color:var(--text-primary)">Menu belum tersedia</div>
            <div style="font-size:.8rem;margin-top:.25rem">Silakan cek kembali nanti</div>
        </div>
    @endif

</div>

{{-- Toast Notification --}}
<div id="rk-toast" style="position:fixed;bottom:90px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--text-primary);color:var(--bg-primary);padding:10px 20px;border-radius:20px;font-size:.82rem;font-weight:500;z-index:9999;opacity:0;transition:all .3s;pointer-events:none;white-space:nowrap">
    Item ditambahkan ke keranjang!
</div>
@endsection

@section('script')
<script>
    function addToCart(menuId) {
        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: menuId })
        })
        .then(r => r.json())
        .then(data => {
            showToast(data.message || 'Item ditambahkan!');
        })
        .catch(() => showToast('Terjadi kesalahan.'));
    }

    function showToast(msg) {
        const t = document.getElementById('rk-toast');
        t.textContent = msg;
        t.style.opacity = '1';
        t.style.transform = 'translateX(-50%) translateY(0)';
        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transform = 'translateX(-50%) translateY(20px)';
        }, 2200);
    }
</script>
@endsection
