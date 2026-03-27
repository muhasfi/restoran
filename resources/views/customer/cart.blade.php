@extends('customer.layouts.master')

@section('content')

{{-- ============================================================
     PAGE HEADER
     ============================================================ --}}
<div class="wn-animate" style="margin-bottom:20px">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
        <a href="{{ route('menu') }}" style="color:var(--text-secondary);font-size:.82rem;display:flex;align-items:center;gap:5px;text-decoration:none;transition:color .2s"
           onmouseover="this.style.color='var(--amber)'" onmouseout="this.style.color='var(--text-secondary)'">
            <i class="fas fa-arrow-left" style="font-size:.75rem"></i> Kembali ke Menu
        </a>
    </div>
    <div class="wn-page-title">Keranjang Saya</div>
    @php
        $cartCount = count($cart ?? []);
        $tableNum  = session('table_number');
    @endphp
    {{-- <div class="wn-page-subtitle">
        {{ $cartCount }} item
        @if($tableNum) · <i class="fas fa-utensils" style="font-size:.75rem;color:var(--amber)"></i> Meja {{ $tableNum }} @endif
    </div> --}}
</div>
<div id="wn-alert" class="wn-alert-overlay">
  <div class="wn-alert-box">
    
    <div class="wn-alert-icon">⚠️</div>

    <div class="wn-alert-title" id="wn-alert-title">
      Hapus item?
    </div>

    <div class="wn-alert-text" id="wn-alert-text">
      Item akan dihapus dari keranjang.
    </div>

    <div class="wn-alert-actions">
      <button class="wn-btn-cancel" onclick="closeAlert()">Batal</button>
      <button class="wn-btn-danger" id="wn-alert-confirm">Hapus</button>
    </div>

  </div>
</div>

{{-- ============================================================
     ALERT
     ============================================================ --}}
@if(session('success'))
    <div class="wn-alert-success wn-animate">
        <span><i class="fas fa-check-circle" style="margin-right:8px"></i>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:var(--green);font-size:1rem;line-height:1">&times;</button>
    </div>
@endif

@if(empty($cart))
    {{-- ======== EMPTY STATE ======== --}}
    <div class="wn-empty wn-animate" style="padding:5rem 1rem">
        <div class="wn-empty-icon">🛒</div>
        <div style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:8px">Keranjang kamu kosong</div>
        <div style="font-size:.85rem;color:var(--text-secondary);margin-bottom:24px">Yuk pilih menu favorit dulu!</div>
        <a href="{{ route('menu') }}" class="wn-cta" style="max-width:200px;margin:0 auto;display:block">
            <i class="fas fa-utensils" style="margin-right:8px;font-size:.8rem"></i> Lihat Menu
        </a>
    </div>

@else
    {{-- ======== CART LAYOUT ======== --}}
<div id="cart-wrapper">
    <div id="cart-grid">

        {{-- ====== CART ITEMS ====== --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;overflow:hidden;">
                <div id="cart-count-label" style="font-size:.875rem;font-weight:600;color:var(--text-secondary)">
                    {{ count($cart) }} item dalam keranjang
                </div>
                <a href="#"
                    onclick="event.preventDefault(); showAlert(
                        'Kosongkan keranjang?',
                        'Semua item akan dihapus dari keranjang.',
                        () => window.location.href='{{ route('cart.clear') }}'
                    )"
                    style="font-size:.78rem;color:var(--red);text-decoration:none;display:flex;align-items:center;gap:5px;transition:opacity .2s"
                    onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
                        <i class="fas fa-trash-alt"></i> Hapus Semua
                </a>
            </div>

            @foreach($cart as $item)
                @php $itemTotal = $item['price'] * $item['qty']; @endphp
                <div class="wn-cart-item wn-animate" id="cart-row-{{ $item['id'] }}">
                    <div class="wn-cart-thumb">
                        <img src="{{ asset('img_item_upload/' . $item['image']) }}"
                             alt="{{ $item['name'] }}"
                             onerror="this.onerror=null;this.src='{{ $item['image'] }}'">
                    </div>
                    <div class="wn-ci-info">
                        <div class="wn-ci-name">{{ $item['name'] }}</div>
                        <div class="wn-ci-price">Rp{{ number_format($item['price'], 0, ',', '.') }} / porsi</div>
                    </div>
                    <div class="wn-qty-ctrl">
                        <button class="wn-qty-btn" onclick="updateQuantity('{{ $item['id'] }}', -1)">−</button>
                        <span class="wn-qty-val" id="qty-{{ $item['id'] }}">{{ $item['qty'] }}</span>
                        <button class="wn-qty-btn" onclick="updateQuantity('{{ $item['id'] }}', 1)">+</button>
                    </div>
                    <div class="wn-ci-total" id="total-{{ $item['id'] }}">
                        Rp{{ number_format($itemTotal, 0, ',', '.') }}
                    </div>
                    <button class="wn-remove-btn"
                        onclick="showAlert(
                            'Hapus item?',
                            'Item ini akan dihapus dari keranjang.',
                            () => removeItemFromCart('{{ $item['id'] }}')
                        )"
                        title="Hapus">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach

            {{-- Back to menu link --}}
            <a href="{{ route('menu') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.82rem;color:var(--text-secondary);text-decoration:none;margin-top:4px;transition:color .2s"
               onmouseover="this.style.color='var(--amber)'" onmouseout="this.style.color='var(--text-secondary)'">
                <i class="fas fa-plus-circle" style="color:var(--amber)"></i> Tambah menu lain
            </a>
        </div>

        {{-- ====== ORDER SUMMARY ====== --}}
        @php
            $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
            $tax      = round(($subtotal) * 0.11);
            $total    = $subtotal + $tax;
        @endphp
        <div>
            <div class="wn-card wn-animate wn-d1" style="position:sticky;top:88px;margin-right:10px;">

                {{-- Card header --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
                    <div style="width:32px;height:32px;border-radius:8px;background:var(--amber-pale);display:flex;align-items:center;justify-content:center">
                        <i class="fas fa-receipt" style="color:var(--amber);font-size:.8rem"></i>
                    </div>
                    <div style="font-size:.95rem;font-weight:600;color:var(--text-primary)">Ringkasan Pesanan</div>
                </div>

                {{-- Summary rows --}}
                <div class="wn-summary">
                    <div class="wn-summary-row">
                        <span>Subtotal ({{ count($cart) }} item)</span>
                        <span id="subtotal">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="wn-summary-row">
                        <span>PPN (11%)</span>
                        <span id="tax">Rp{{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <hr class="wn-summary-divider">
                    <div class="wn-summary-total">
                        <span>Total Bayar</span>
                        <span class="wn-summary-total-price" id="grand-total">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout') }}" class="wn-cta" style="margin-bottom:10px">
                    Lanjut Checkout <i class="fas fa-arrow-right" style="margin-left:8px;font-size:.8rem"></i>
                </a>

                {{-- Table info --}}
                @if($tableNum)
                <div style="display:flex;align-items:center;gap:8px;background:var(--amber-pale);border:1px solid rgba(212,134,43,0.25);border-radius:12px;padding:10px 14px;margin-top:8px">
                    <i class="fas fa-utensils" style="color:var(--amber);font-size:.85rem"></i>
                    <div>
                        <div style="font-size:.72rem;color:var(--text-secondary)">Pesanan untuk</div>
                        <div style="font-size:.85rem;font-weight:700;color:var(--amber)">Meja {{ $tableNum }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endif
<div id="empty-state" style="display:none; padding:5rem 1rem" class="wn-empty wn-animate">
    <div class="wn-empty-icon">🛒</div>
    <div style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:8px">Keranjang kamu kosong</div>
    <div style="font-size:.85rem;color:var(--text-secondary);margin-bottom:24px">Yuk pilih menu favorit dulu!</div>
    <a href="{{ route('menu') }}" class="wn-cta" style="max-width:200px;margin:0 auto;display:block">
        <i class="fas fa-utensils" style="margin-right:8px;font-size:.8rem"></i> Lihat Menu
    </a>
</div>

@endsection

@section('script')
<script>
    function updateQuantity(itemId, change) {
        const qtyEl = document.getElementById('qty-' + itemId);
        const currentQty = parseInt(qtyEl.textContent);
        const newQty = currentQty + change;

        if (newQty <= 0) {
            showAlert(
                'Hapus item?',
                'Item ini akan dihapus dari keranjang.',
                () => removeItemFromCart(itemId)
            );
            return;
        }

        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: itemId, qty: newQty })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert('Gagal update');
                return;
            }

            // ✅ update qty
            qtyEl.textContent = newQty;

            // ✅ ambil harga dari teks (tanpa ubah HTML kamu)
            const priceText = document.querySelector(`#cart-row-${itemId} .wn-ci-price`).textContent;
            const price = parseInt(priceText.replace(/\D/g, ''));

            // ✅ update total per item
            const newTotal = price * newQty;
            document.getElementById('total-' + itemId).textContent = formatRupiah(newTotal);

            // ✅ update summary
            updateSummary();
        })
        .catch(() => alert('Terjadi kesalahan.'));
    }

    let alertConfirmCallback = null;

        function showAlert(title, text, onConfirm) {
        document.getElementById('wn-alert-title').textContent = title;
        document.getElementById('wn-alert-text').textContent = text;

        alertConfirmCallback = onConfirm;

        document.getElementById('wn-alert').classList.add('active');
        }

        function closeAlert() {
        document.getElementById('wn-alert').classList.remove('active');
        }

        document.getElementById('wn-alert-confirm').onclick = function () {
        if (alertConfirmCallback) alertConfirmCallback();
        closeAlert();
        };


    function removeItemFromCart(itemId) {
        fetch("{{ route('cart.remove') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: itemId })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert('Gagal hapus item');
                return;
            }

            // ✅ hapus item dari tampilan
            const row = document.getElementById('cart-row-' + itemId);
            if (row) row.remove();

            // ✅ update summary
            updateSummary();
        })
        .catch(() => alert('Terjadi kesalahan.'));
    }


    // ✅ hitung ulang tanpa backend
    function updateSummary() {
        const items = document.querySelectorAll('.wn-cart-item');

        // ✅ Cek apakah cart kosong
        if (items.length === 0) {
            document.getElementById('cart-wrapper').style.display = 'none';
            document.getElementById('empty-state').style.display = 'block';
            return;
        }

        document.getElementById('cart-count-label').textContent = items.length + ' item dalam keranjang';

        // ✅ Update subtotal di ringkasan juga
        const summaryCount = document.querySelector('#subtotal')?.closest('.wn-summary-row')?.querySelector('span:first-child');
        if (summaryCount) summaryCount.textContent = `Subtotal (${items.length} item)`;


        let subtotal = 0;
        items.forEach(item => {
            const priceText = item.querySelector('.wn-ci-price').textContent;
            const price = parseInt(priceText.replace(/\D/g, ''));
            const qty = parseInt(item.querySelector('.wn-qty-val').textContent);
            subtotal += price * qty;
        });

        const tax = Math.round(subtotal * 0.11);
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('tax').textContent = formatRupiah(tax);
        document.getElementById('grand-total').textContent = formatRupiah(total);
    }


    // helper rupiah
    function formatRupiah(angka) {
        return 'Rp' + angka.toLocaleString('id-ID');
    }
</script>

<style>
    #cart-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 768px) {
        #cart-grid {
            grid-template-columns: 1fr 360px;
        }
    }

    @media (max-width: 767px) {
        .wn-card.wn-animate.wn-d1 {
            position: static !important;
        }
    }
    @media (max-width: 767px) {
        .wn-card.wn-animate.wn-d1 {
            position: static !important;
        }
        
        /* Kurangi padding konten di mobile */
        .wn-main > div {
            padding: 16px !important;
        }
    }
    @media (max-width: 767px) {
        .wn-cart-item {
            margin-left: -9px;
        }
    }
</style>
@endsection

