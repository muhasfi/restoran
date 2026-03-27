@extends('customer.layouts.master')

@section('content')

{{-- ============================================================
     PAGE HEADER
     ============================================================ --}}
<div class="wn-animate" style="margin-bottom:20px">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
        <a href="{{ url('/cart') }}" style="color:var(--text-secondary);font-size:.82rem;display:flex;align-items:center;gap:5px;text-decoration:none;transition:color .2s"
           onmouseover="this.style.color='var(--amber)'" onmouseout="this.style.color='var(--text-secondary)'">
            <i class="fas fa-arrow-left" style="font-size:.75rem"></i> Kembali ke Keranjang
        </a>
    </div>
    <div class="wn-page-title">Detail Pesanan</div>
    <div class="wn-page-subtitle">Lengkapi informasi di bawah untuk menyelesaikan pemesanan</div>
</div>

<form id="wn-checkout-form" action="{{ route('checkout.store') }}" method="POST">
@csrf

{{-- ============================================================
     TWO-COLUMN LAYOUT
     ============================================================ --}}
<div class="wn-checkout-grid">

    {{-- ====================================================
         LEFT: Customer Info + Order Detail
         ==================================================== --}}
    <div>

        {{-- Customer Info --}}
        <div class="wn-card wn-animate" style="margin-bottom:16px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
                <div style="width:34px;height:34px;border-radius:10px;background:var(--amber-pale);display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-user" style="color:var(--amber);font-size:.85rem"></i>
                </div>
                <div style="font-size:.95rem;font-weight:600;color:var(--text-primary)">Informasi Pemesan</div>
            </div>

            <div style="display:grid;gap:14px">
                {{-- Nama --}}
                <div>
                    <div style="display:flex;align-items:center;gap:8px;background:var(--bg-secondary);border:1.5px solid var(--border);border-radius:12px;padding:4px 14px;transition:border-color .2s"
                         id="field-nama" onfocus-within="this.style.borderColor='var(--amber)'">
                        <span style="font-size:1.1rem">👤</span>
                        <div style="flex:1">
                            <label class="wn-form-label" style="margin-bottom:1px;font-size:.72rem">Nama</label>
                            <input type="text" name="fullname" class="wn-form-control"
                                   style="background:transparent;border:none;padding:2px 0;font-size:.9rem"
                                   placeholder="Masukkan nama kamu" required
                                   onfocus="this.closest('[id^=field]').style.borderColor='var(--amber)'"
                                   onblur="this.closest('[id^=field]').style.borderColor='var(--border)'" required>
                        </div>
                    </div>
                </div>

                {{-- No HP --}}
                <div>
                    <div style="display:flex;align-items:center;gap:8px;background:var(--bg-secondary);border:1.5px solid var(--border);border-radius:12px;padding:4px 14px;transition:border-color .2s"
                         id="field-hp">
                        <span style="font-size:1.1rem">📱</span>
                        <div style="flex:1">
                            <label class="wn-form-label" style="margin-bottom:1px;font-size:.72rem">Nomor HP</label>
                            <input type="text" name="phone" class="wn-form-control"
                                   style="background:transparent;border:none;padding:2px 0;font-size:.9rem"
                                   placeholder="08xx xxxx xxxx" required
                                   onfocus="this.closest('[id^=field]').style.borderColor='var(--amber)'"
                                   onblur="this.closest('[id^=field]').style.borderColor='var(--border)'" required>
                        </div>
                    </div>
                </div>

                {{-- Nomor Meja --}}
                <div>
                    <div style="display:flex;align-items:center;gap:8px;background:var(--amber-ultra);border:1.5px solid rgba(212,134,43,0.3);border-radius:12px;padding:4px 14px">
                        <span style="font-size:1.1rem">🍽</span>
                        <div style="flex:1">
                            <label class="wn-form-label" style="margin-bottom:1px;font-size:.72rem">Nomor Meja</label>
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <input type="text" class="wn-form-control"
                                       style="background:transparent;border:none;padding:2px 0;font-size:.9rem;color:var(--amber);font-weight:700"
                                       value="{{ $tableNumber ?? 'Tidak ada nomor meja' }}" disabled>
                                <span style="background:var(--amber);color:#fff;font-size:.65rem;font-weight:600;padding:2px 8px;border-radius:10px;white-space:nowrap;flex-shrink:0">Otomatis</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div>
                    <div style="display:flex;align-items:flex-start;gap:8px;background:var(--bg-secondary);border:1.5px solid var(--border);border-radius:12px;padding:4px 14px;transition:border-color .2s"
                         id="field-catatan">
                        <span style="font-size:1.1rem;margin-top:6px">📝</span>
                        <div style="flex:1">
                            <label class="wn-form-label" style="margin-bottom:1px;font-size:.72rem">Catatan (opsional)</label>
                            <textarea name="note" class="wn-form-control" rows="2"
                                      style="background:transparent;border:none;padding:2px 0;font-size:.9rem;resize:none"
                                      placeholder="Misal: tidak pedas, tanpa bawang..."
                                      onfocus="this.closest('[id^=field]').style.borderColor='var(--amber)'"
                                      onblur="this.closest('[id^=field]').style.borderColor='var(--border)'"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Detail --}}
        <div class="wn-card wn-animate wn-d1">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                <div style="width:34px;height:34px;border-radius:10px;background:var(--amber-pale);display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-receipt" style="color:var(--amber);font-size:.85rem"></i>
                </div>
                <div style="font-size:.95rem;font-weight:600;color:var(--text-primary)">Detail Pesanan</div>
            </div>

            @php $subTotal = 0; @endphp
            @foreach(session('cart') as $item)
                @php $itemTotal = $item['price'] * $item['qty']; $subTotal += $itemTotal; @endphp
                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
                    <div style="width:52px;height:52px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--amber-pale)">
                        <img src="{{ asset('img_item_upload/'. $item['image']) }}"
                             style="width:100%;height:100%;object-fit:cover"
                             alt="{{ $item['name'] }}"
                             onerror="this.onerror=null;this.src='{{ $item['image'] }}'">
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:.875rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item['name'] }}</div>
                        <div style="font-size:.75rem;color:var(--text-secondary);margin-top:2px">
                            {{ $item['qty'] }} × Rp{{ number_format($item['price'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div style="font-size:.9rem;font-weight:700;color:var(--amber);flex-shrink:0">
                        Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ====================================================
         RIGHT: Summary + Payment Method
         ==================================================== --}}
    @php
        $tax     = round(($subTotal) * 0.11);
        $total   = $subTotal + $tax;
    @endphp
    <div>
        <div class="wn-card wn-animate wn-d2" style="position:sticky;top:88px">

            {{-- Summary --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                <div style="width:34px;height:34px;border-radius:10px;background:var(--amber-pale);display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-calculator" style="color:var(--amber);font-size:.85rem"></i>
                </div>
                <div style="font-size:.95rem;font-weight:600;color:var(--text-primary)">Ringkasan</div>
            </div>

            <div class="wn-summary" style="margin-bottom:20px">
                <div class="wn-summary-row"><span>Subtotal</span><span>Rp{{ number_format($subTotal, 0, ',', '.') }}</span></div>
                <div class="wn-summary-row"><span>PPN (11%)</span><span>Rp{{ number_format($tax, 0, ',', '.') }}</span></div>
                <hr class="wn-summary-divider">
                <div class="wn-summary-total">
                    <span>Total Bayar</span>
                    <span class="wn-summary-total-price">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Payment Method --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <div style="width:34px;height:34px;border-radius:10px;background:var(--amber-pale);display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-wallet" style="color:var(--amber);font-size:.85rem"></i>
                </div>
                <div style="font-size:.95rem;font-weight:600;color:var(--text-primary)">Metode Pembayaran</div>
            </div>

            {{-- Midtrans option --}}
            <div class="wn-pay-opt" data-value="qris" onclick="wnSelectPayment(this)">
                <div class="wn-pay-radio"><div class="wn-pay-radio-dot"></div></div>
                <div class="wn-pay-icon midtrans">💳</div>
                <div>
                    <div class="wn-pay-name">Midtrans</div>
                    <div class="wn-pay-desc">Transfer, QRIS, e-wallet, kartu kredit</div>
                </div>
                <input type="radio" name="payment_method" value="qris" style="display:none">
            </div>

            {{-- Tunai option --}}
            <div class="wn-pay-opt" data-value="tunai" onclick="wnSelectPayment(this)">
                <div class="wn-pay-radio"><div class="wn-pay-radio-dot"></div></div>
                <div class="wn-pay-icon tunai">💵</div>
                <div>
                    <div class="wn-pay-name">Tunai</div>
                    <div class="wn-pay-desc">Bayar langsung ke kasir</div>
                </div>
                <input type="radio" name="payment_method" value="tunai" style="display:none">
            </div>

            <div style="height:16px"></div>

            <button type="button" id="wn-pay-button" class="wn-cta">
                🛎 Pesan Sekarang — Rp{{ number_format($total, 0, ',', '.') }}
            </button>
        </div>
    </div>

</div>
</form>

<style>
    .wn-checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    @media (min-width: 768px) {
        .wn-checkout-grid { grid-template-columns: 1fr 360px; gap: 24px; }
    }
</style>
@endsection

@section('script')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    function wnSelectPayment(el) {
        document.querySelectorAll('.wn-pay-opt').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        const radio = el.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('wn-pay-button');
        const form      = document.getElementById('wn-checkout-form');

        payButton.addEventListener('click', function () {
            let selectedRadio = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedRadio) {
                showToast('⚠ Pilih metode pembayaran terlebih dahulu!');
                return;
            }

            const paymentMethod = selectedRadio.value;

            if (paymentMethod === 'tunai') {
                form.submit();
            } else {
                // Midtrans flow
                const formData = new FormData(form);
                fetch('{{ route("checkout.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: () => window.location.href = '/checkout/success/' + data.order_code,
                            onPending: () => showToast('Menunggu pembayaran...'),
                            onError:   () => showToast('Pembayaran gagal. Coba lagi.')
                        });
                    } else {
                        showToast('Terjadi kesalahan, silakan coba lagi.');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan, silakan coba lagi.'));
            }
        });
    });
</script>
@endsection