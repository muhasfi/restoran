@extends('customer.layouts.master')

@section('content')

{{-- ============================================================
     PAGE HEADER
     ============================================================ --}}
<div style="margin-bottom: 4px;" class="wn-animate">
    <div class="wn-page-title">Menu Kami</div>
    <div class="wn-page-subtitle">Pilih menu favoritmu, lalu tambahkan ke keranjang 🍽</div>
</div>

{{-- ============================================================
     FILTER CHIPS (mobile & desktop top bar)
     ============================================================ --}}
<div class="wn-filter-bar wn-animate wn-d1">
    <div class="wn-chip active" data-filter="all">
        <i class="fas fa-border-all" style="font-size:.7rem;margin-right:4px"></i> Semua
    </div>
    <div class="wn-chip" data-filter="Makanan">
        <i class="fas fa-utensils" style="font-size:.7rem;margin-right:4px"></i> Makanan
    </div>
    <div class="wn-chip" data-filter="Minuman">
        <i class="fas fa-glass-whiskey" style="font-size:.7rem;margin-right:4px"></i> Minuman
    </div>
</div>

@php
    $grouped = $items->groupBy(fn($item) => $item->category->category_name);
@endphp

@if($items->isEmpty())
    {{-- EMPTY STATE --}}
    <div class="wn-empty wn-animate">
        <div class="wn-empty-icon"><i class="fas fa-utensils"></i></div>
        <div style="font-size:.95rem;font-weight:600;color:var(--text-primary);margin-bottom:6px">Menu belum tersedia</div>
        <div style="font-size:.82rem">Silakan cek kembali nanti</div>
    </div>
@else

{{-- ============================================================
     MOBILE VIEW (< 1024px) — horizontal list rows
     ============================================================ --}}
<div class="wn-d-desktop-none">
    @foreach($grouped as $catName => $catItems)
        <div class="wn-menu-section" data-cat="{{ $catName }}">
            <div class="wn-cat-label">
                @if($catName === 'Makanan') 🍜 @elseif($catName === 'Minuman') 🥤 @endif
                {{ $catName }}
            </div>
            @foreach($catItems as $item)
                <div class="wn-menu-row wn-animate" data-cat="{{ $catName }}">
                    <div class="wn-row-thumb">
                        <img src="{{ $item->img }}"
                             alt="{{ $item->name }}"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/72x72/FDE8C4/8B6340?text=🍜'">
                    </div>
                    <div class="wn-row-info">
                        <div class="wn-row-name">{{ $item->name }}</div>
                        <div class="wn-row-desc">{{ $item->description }}</div>
                        <div class="wn-row-price">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                    <button class="wn-add-btn-round" onclick="addToCart({{ $item->id }})" aria-label="Tambah">+</button>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

{{-- ============================================================
     DESKTOP VIEW (>= 1024px) — card grid
     ============================================================ --}}
<div class="wn-d-mobile-none">
    @foreach($grouped as $catName => $catItems)
        <div class="wn-menu-section" data-cat="{{ $catName }}">
            <div class="wn-cat-label">
                @if($catName === 'Makanan') <i class="fas fa-utensils" style="color:var(--amber);font-size:.85rem"></i>
                @elseif($catName === 'Minuman') <i class="fas fa-glass-whiskey" style="color:var(--amber);font-size:.85rem"></i>
                @endif
                {{ $catName }}
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:16px; margin-bottom:8px">
                @foreach($catItems as $i => $item)
                    <div class="wn-col-item wn-animate" data-cat="{{ $catName }}" style="animation-delay:{{ $i * 0.04 }}s">
                        <div class="wn-menu-card">
                            <div class="wn-card-img-wrap">
                                <img class="wn-card-img" src="{{ $item->img }}"
                                     alt="{{ $item->name }}"
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/300x160/FDE8C4/8B6340?text=🍜'">
                                {{-- Badge hot/baru bisa dikustomisasi dari DB --}}
                                @if(isset($item->badge) && $item->badge)
                                    <span class="wn-card-badge">{{ $item->badge }}</span>
                                @endif
                                <span style="position:absolute;top:10px;right:10px">
                                    @if($catName === 'Makanan')
                                        <span class="wn-badge-food">{{ $catName }}</span>
                                    @elseif($catName === 'Minuman')
                                        <span class="wn-badge-drink">{{ $catName }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="wn-card-body">
                                <div class="wn-card-name">{{ $item->name }}</div>
                                <div class="wn-card-desc">{{ $item->description }}</div>
                                <div class="wn-card-footer">
                                    <span class="wn-card-price">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                    <button class="wn-add-btn" onclick="addToCart({{ $item->id }})">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

{{-- ============================================================
     CART FAB (mobile sticky, visible when cart has items)
     ============================================================ --}}
@php $cartItems = session('cart', []); $cartTotal = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cartItems)); @endphp
@if(!empty($cartItems))
    <a href="{{ url('/cart') }}" class="wn-cart-fab d-lg-none">
        <div class="wn-cart-fab-left">
            <div class="wn-cart-count">{{ count($cartItems) }}</div>
            <span class="wn-cart-fab-text">Lihat Keranjang</span>
        </div>
        <span class="wn-cart-fab-price">Rp{{ number_format($cartTotal, 0, ',', '.') }} →</span>
    </a>
@endif

@endif

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
            showToast(data.message || '✓ Item ditambahkan ke keranjang!');
            // Update cart badge counts
            setTimeout(() => location.reload(), 600);
        })
        .catch(() => showToast('Terjadi kesalahan, coba lagi.'));
    }
</script>
@endsection

<style>
    /* Mobile/desktop visibility helpers (no Bootstrap dependency) */
    /* .wn-d-desktop-none { display: block; }
    .wn-d-mobile-none  { display: none; }

    @media (min-width: 1024px) {
        .wn-d-desktop-none { display: none !important; }
        .wn-d-mobile-none  { display: block !important; }
    } */

     .wn-d-desktop-none { display: block; }
    .wn-d-mobile-none  { display: none; }

    /* Desktop */
    @media (min-width: 1024px) {
    .wn-d-desktop-none { display: none !important; }

    .wn-d-mobile-none  {
        display: block !important;

        /* 🔥 Tambahan penting */
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
</style>