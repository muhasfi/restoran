@extends('customer.layouts.master')

@section('content')
<div class="container py-4">

    <div class="rk-section-title rk-animate">Detail Pembayaran</div>

    <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">

            {{-- LEFT: Form & Order Detail --}}
            <div class="col-lg-7 rk-animate">

                {{-- Customer Info --}}
                <div class="rk-card mb-3">
                    <div style="font-size:.875rem;font-weight:600;color:var(--text-primary);margin-bottom:1rem;display:flex;align-items:center;gap:8px">
                        <span style="width:28px;height:28px;border-radius:50%;background:var(--brand-light);display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-user" style="font-size:.7rem;color:var(--brand)"></i>
                        </span>
                        Informasi Pemesan
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="rk-form-label">Nama Lengkap <span style="color:var(--brand)">*</span></label>
                            <input type="text" name="fullname" class="rk-form-control"
                                   placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="rk-form-label">Nomor WhatsApp <span style="color:var(--brand)">*</span></label>
                            <input type="text" name="phone" class="rk-form-control"
                                   placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="rk-form-label">Nomor Meja</label>
                            <input type="text" class="rk-form-control"
                                   value="{{ $tableNumber ?? 'Tidak ada nomor meja' }}"
                                   style="color:var(--brand);font-weight:600" disabled>
                        </div>
                        <div class="col-12">
                            <label class="rk-form-label">Catatan (opsional)</label>
                            <textarea name="note" class="rk-form-control" rows="3"
                                      placeholder="Contoh: pedas level 2, tanpa bawang..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Order Detail --}}
                <div class="rk-card">
                    <div style="font-size:.875rem;font-weight:600;color:var(--text-primary);margin-bottom:1rem;display:flex;align-items:center;gap:8px">
                        <span style="width:28px;height:28px;border-radius:50%;background:var(--brand-light);display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-receipt" style="font-size:.7rem;color:var(--brand)"></i>
                        </span>
                        Detail Pesanan
                    </div>

                    @php $subTotal = 0; @endphp
                    @foreach(session('cart') as $item)
                        @php $itemTotal = $item['price'] * $item['qty']; $subTotal += $itemTotal; @endphp
                        <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border-color)">
                            <div style="width:48px;height:48px;border-radius:10px;overflow:hidden;flex-shrink:0;background:var(--bg-secondary)">
                                <img src="{{ asset('img_item_upload/'. $item['image']) }}"
                                     style="width:100%;height:100%;object-fit:cover"
                                     alt="{{ $item['name'] }}"
                                     onerror="this.onerror=null;this.src='{{ $item['image'] }}'">
                            </div>
                            <div style="flex:1;min-width:0">
                                <div style="font-size:.875rem;font-weight:500;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item['name'] }}</div>
                                <div style="font-size:.75rem;color:var(--text-secondary);margin-top:2px">{{ $item['qty'] }} × Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div style="font-size:.875rem;font-weight:600;color:var(--brand);flex-shrink:0">
                                Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Summary & Payment --}}
            @php $tax = $subTotal * 0.1; $total = $subTotal + $tax; @endphp
            <div class="col-lg-5 rk-animate rk-animate-d1">
                <div class="rk-card" style="position:sticky;top:80px">

                    {{-- Summary --}}
                    <div style="font-size:.875rem;font-weight:600;color:var(--text-primary);margin-bottom:1rem;display:flex;align-items:center;gap:8px">
                        <span style="width:28px;height:28px;border-radius:50%;background:var(--brand-light);display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-calculator" style="font-size:.7rem;color:var(--brand)"></i>
                        </span>
                        Ringkasan Pesanan
                    </div>
                    <div class="rk-summary mb-4">
                        <div class="rk-summary-row">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($subTotal, 0, ',', '.') }}</span>
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

                    {{-- Payment Method --}}
                    <div style="font-size:.875rem;font-weight:600;color:var(--text-primary);margin-bottom:.75rem;display:flex;align-items:center;gap:8px">
                        <span style="width:28px;height:28px;border-radius:50%;background:var(--brand-light);display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-wallet" style="font-size:.7rem;color:var(--brand)"></i>
                        </span>
                        Metode Pembayaran
                    </div>

                    <div class="rk-pay-opt" data-value="qris" onclick="selectPayment(this)">
                        <div class="rk-pay-radio"><div class="rk-pay-radio-inner"></div></div>
                        <div class="rk-pay-icon qris">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="1.5">
                                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="17" width="4" height="4" rx=".5"/>
                                <path d="M14 14h3M21 14v.01M17 17v.01M21 17v.01M21 21v.01"/>
                            </svg>
                        </div>
                        <div>
                            <div class="rk-pay-lbl">QRIS</div>
                            <div class="rk-pay-sub">Scan & bayar langsung</div>
                        </div>
                        <input type="radio" name="payment_method" value="qris" style="display:none">
                    </div>

                    <div class="rk-pay-opt" data-value="tunai" onclick="selectPayment(this)">
                        <div class="rk-pay-radio"><div class="rk-pay-radio-inner"></div></div>
                        <div class="rk-pay-icon tunai">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="1.5">
                                <rect x="2" y="6" width="20" height="12" rx="2"/>
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M6 12h.01M18 12h.01"/>
                            </svg>
                        </div>
                        <div>
                            <div class="rk-pay-lbl">Tunai</div>
                            <div class="rk-pay-sub">Bayar langsung ke kasir</div>
                        </div>
                        <input type="radio" name="payment_method" value="tunai" style="display:none">
                    </div>

                    <div style="height:.75rem"></div>
                    <button type="button" id="pay-button" class="rk-cta">
                        <i class="fas fa-lock me-2" style="font-size:.8rem"></i> Konfirmasi Pesanan
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection

@section('script')
<script>
    function selectPayment(el) {
        document.querySelectorAll('.rk-pay-opt').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        const radio = el.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const payButton = document.getElementById("pay-button");
        const form = document.querySelector("form");

        payButton.addEventListener("click", function () {
            let paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                alert("Pilih metode pembayaran terlebih dahulu!");
                return;
            }

            paymentMethod = paymentMethod.value;

            if (paymentMethod === "tunai") {
                form.submit();
            } else {
                const formData = new FormData(form);
                fetch("{{ route('checkout.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: () => window.location.href = "/checkout/success/" + data.order_code,
                            onPending: () => alert("Menunggu pembayaran"),
                            onError: () => alert("Pembayaran gagal")
                        });
                    } else {
                        alert("Terjadi kesalahan, silakan coba lagi.");
                    }
                })
                .catch(() => alert("Terjadi kesalahan, silakan coba lagi."));
            }
        });
    });
</script>
@endsection
