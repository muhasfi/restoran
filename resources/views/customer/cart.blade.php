@extends('customer.layouts.master')

@section('content')
<div class="container py-4">

    {{-- Alert success --}}
    @if(session('success'))
        <div class="rk-alert-success rk-animate">
            <span><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:#065f46;font-size:1rem">&times;</button>
        </div>
    @endif

    @if(empty($cart))
        {{-- Empty State --}}
        <div class="rk-empty rk-animate" style="padding:4rem 1rem">
            <div style="font-size:3.5rem;margin-bottom:1rem;opacity:.4">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:.5rem">Keranjang Anda kosong</div>
            <div style="font-size:.85rem;color:var(--text-secondary);margin-bottom:1.5rem">Yuk pilih menu yang kamu suka!</div>
            <a href="{{ route('menu') }}" class="rk-cta" style="max-width:200px;margin:0 auto;padding:12px 24px">
                <i class="fas fa-utensils me-2"></i> Lihat Menu
            </a>
        </div>

    @else
        <div class="row g-4">

            {{-- Cart Items --}}
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rk-section-title" style="margin-bottom:0">
                        Keranjang <span style="font-weight:400;color:var(--text-secondary)">({{ count($cart) }} item)</span>
                    </div>
                    <a href="{{ route('cart.clear') }}"
                       onclick="return confirm('Hapus semua item dari keranjang?')"
                       style="font-size:.8rem;color:#e24b4a;text-decoration:none;display:flex;align-items:center;gap:4px">
                        <i class="fas fa-trash-alt" style="font-size:.75rem"></i> Hapus Semua
                    </a>
                </div>

                @foreach($cart as $item)
                    @php $itemTotal = $item['price'] * $item['qty']; @endphp
                    <div class="rk-cart-item rk-animate" id="cart-row-{{ $item['id'] }}">
                        <div class="rk-cart-thumb">
                            <img src="{{ asset('img_item_upload/' . $item['image']) }}"
                                 alt="{{ $item['name'] }}"
                                 onerror="this.onerror=null;this.src='{{ $item['image'] }}'">
                        </div>
                        <div class="rk-ci-info">
                            <div class="rk-ci-name">{{ $item['name'] }}</div>
                            <div class="rk-ci-price">Rp{{ number_format($item['price'], 0, ',', '.') }} / porsi</div>
                        </div>
                        <div class="rk-qty-ctrl">
                            <button class="rk-qty-btn" onclick="updateQuantity('{{ $item['id'] }}', -1)">−</button>
                            <span class="rk-qty-val" id="qty-{{ $item['id'] }}">{{ $item['qty'] }}</span>
                            <button class="rk-qty-btn" onclick="updateQuantity('{{ $item['id'] }}', 1)">+</button>
                        </div>
                        <div class="rk-ci-total" id="total-{{ $item['id'] }}">
                            Rp{{ number_format($itemTotal, 0, ',', '.') }}
                        </div>
                        <button class="rk-remove-btn" onclick="if(confirm('Hapus item ini?')) removeItemFromCart('{{ $item['id'] }}')" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            @php
                $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
                $tax      = $subtotal * 0.1;
                $total    = $subtotal + $tax;
            @endphp
            <div class="col-lg-4">
                <div class="rk-card rk-animate rk-animate-d1" style="position:sticky;top:80px">
                    <div class="rk-section-title">Ringkasan Pesanan</div>
                    <div class="rk-summary mb-3">
                        <div class="rk-summary-row">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="rk-summary-row">
                            <span>Pajak (10%)</span>
                            <span>Rp{{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="rk-summary-total">
                            <span>Total</span>
                            <span style="color:var(--brand)">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout') }}" class="rk-cta">
                        Lanjut ke Pembayaran <i class="fas fa-arrow-right ms-2" style="font-size:.8rem"></i>
                    </a>
                    <a href="{{ route('menu') }}" class="d-block text-center mt-3"
                       style="font-size:.82rem;color:var(--text-secondary);text-decoration:none">
                        <i class="fas fa-arrow-left me-1" style="font-size:.75rem"></i> Tambah menu lain
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    function updateQuantity(itemId, change) {
        const qtyEl = document.getElementById('qty-' + itemId);
        const currentQty = parseInt(qtyEl.textContent);
        const newQty = currentQty + change;

        if (newQty <= 0) {
            if (confirm('Hapus item ini dari keranjang?')) {
                removeItemFromCart(itemId);
            }
            return;
        }

        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ id: itemId, qty: newQty })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.message);
        })
        .catch(() => alert('Terjadi kesalahan. Silakan coba lagi.'));
    }

    function removeItemFromCart(itemId) {
        fetch("{{ route('cart.remove') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ id: itemId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.message);
        })
        .catch(() => alert('Terjadi kesalahan. Silakan coba lagi.'));
    }
</script>
@endsection
