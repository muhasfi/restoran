@extends('customer.layouts.master')

@section('content')

<div style="display:flex;justify-content:center;padding:8px 0 32px" class="wn-animate">

    {{-- ============================================================
         RECEIPT CARD
         ============================================================ --}}
    <div class="wn-receipt" id="wn-receipt-card" style="width:100%;max-width:480px">

        {{-- RECEIPT HEADER --}}
        <div class="wn-receipt-header">
            <div class="wn-success-circle">✓</div>
            <div class="wn-receipt-logo">Warung Nusantara</div>
            <div class="wn-receipt-order-id">Order #{{ $order->order_code }}</div>
            <div style="margin-top:8px">
                @if($order->payment_method == 'tunai' && $order->status == 'pending')
                    <span style="background:rgba(254,243,199,0.15);border:1px solid rgba(254,243,199,0.3);color:#FCD34D;font-size:.75rem;font-weight:600;padding:4px 14px;border-radius:20px">
                        <i class="fas fa-clock" style="margin-right:4px"></i> Menunggu Pembayaran
                    </span>
                @elseif($order->payment_method == 'qris' && $order->status == 'pending')
                    <span style="background:rgba(254,243,199,0.15);border:1px solid rgba(254,243,199,0.3);color:#FCD34D;font-size:.75rem;font-weight:600;padding:4px 14px;border-radius:20px">
                        <i class="fas fa-clock" style="margin-right:4px"></i> Menunggu Konfirmasi
                    </span>
                @else
                    <span style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);color:#34D399;font-size:.75rem;font-weight:600;padding:4px 14px;border-radius:20px">
                        <i class="fas fa-check-circle" style="margin-right:4px"></i> Pembayaran Berhasil
                    </span>
                @endif
            </div>
        </div>

        {{-- RECEIPT BODY --}}
        <div class="wn-receipt-body">

            {{-- Order code highlight --}}
            <div style="background:var(--bg-secondary);border-radius:14px;border:1px solid var(--border);padding:14px 16px;margin-bottom:16px;text-align:center">
                <div style="font-size:.72rem;color:var(--text-secondary);margin-bottom:4px">Kode Pesanan</div>
                <div class="wn-order-code">{{ $order->order_code }}</div>
                <div style="font-size:.72rem;color:var(--text-secondary);margin-top:4px">
                    @if($order->payment_method == 'tunai')
                        Tunjukkan kode ini ke kasir
                    @else
                        Simpan sebagai bukti pesanan
                    @endif
                </div>
            </div>

            {{-- Customer info --}}
            <div class="wn-receipt-info"><span class="wn-receipt-info-label">Nama</span><span class="wn-receipt-info-val">{{ $order->customer_name }}</span></div>
            <div class="wn-receipt-info"><span class="wn-receipt-info-label">No. HP</span><span class="wn-receipt-info-val">{{ $order->customer_phone }}</span></div>
            <div class="wn-receipt-info"><span class="wn-receipt-info-label">Meja</span><span class="wn-receipt-info-val" style="color:var(--amber);font-weight:700">Meja {{ $order->table_number }}</span></div>
            <div class="wn-receipt-info" style="border-bottom:none"><span class="wn-receipt-info-label">Waktu Pesan</span><span class="wn-receipt-info-val">{{ $order->created_at->format('d M Y, H:i') }}</span></div>

            <hr class="wn-receipt-divider">

            {{-- Order items --}}
            <div style="margin-bottom:10px">
                @foreach($orderItems as $orderItem)
                    <div class="wn-receipt-item">
                        <div>
                            <div class="wn-receipt-item-name">{{ $orderItem->item->name ?? '-' }}</div>
                            <div class="wn-receipt-item-qty">{{ $orderItem->quantity }}x · Rp{{ number_format($orderItem->price / $orderItem->quantity, 0, ',', '.') }}</div>
                        </div>
                        <div style="font-weight:600;color:var(--text-primary)">Rp{{ number_format($orderItem->price, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Fee breakdown --}}
            <div style="font-size:.75rem;color:var(--text-muted);margin-bottom:8px;display:flex;gap:12px;justify-content:flex-end">
                <span>PPN: Rp{{ number_format($order->tax ?? 0, 0, ',', '.') }}</span>
            </div>

            <hr class="wn-receipt-divider">

            <div class="wn-receipt-total-row">
                <span>Total Bayar</span>
                <span class="wn-receipt-total-price">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
            </div>

            {{-- Payment method badge --}}
            <div class="wn-receipt-pay-method">
                <span style="font-size:1.4rem">{{ $order->payment_method === 'tunai' ? '💵' : '💳' }}</span>
                <div>
                    <div class="wn-receipt-pay-text">
                        {{ $order->payment_method === 'tunai' ? 'Bayar Tunai ke Kasir' : 'Dibayar via Midtrans' }}
                    </div>
                    <div class="wn-receipt-pay-sub">
                        @if($order->payment_method === 'tunai')
                            Tunjukkan kode pesanan ke kasir
                        @else
                            QRIS · {{ $order->status === 'paid' ? 'Berhasil' : 'Menunggu Konfirmasi' }}
                        @endif
                    </div>
                </div>
                <span style="margin-left:auto;font-size:1.2rem">
                    {{ $order->status === 'paid' ? '✅' : '⏳' }}
                </span>
            </div>
        </div>

        {{-- RECEIPT FOOTER --}}
        <div class="wn-receipt-footer">
            <div class="wn-receipt-thank">Terima kasih, {{ $order->fullname }}! 🙏</div>
            <div class="wn-receipt-note">Pesananmu akan tiba dalam ± 15–20 menit</div>
        </div>
    </div>

</div>

{{-- Action buttons (outside receipt for clean download) --}}
<div style="display:flex;gap:12px;flex-wrap:wrap;max-width:480px;margin:0 auto 32px" class="wn-animate wn-d2">
    <button onclick="downloadReceipt()" class="wn-cta" style="flex:1;min-width:160px">
        <i class="fas fa-download" style="margin-right:8px;font-size:.8rem"></i> Simpan Struk
    </button>
    <a href="{{ route('menu') }}" class="wn-cta" style="flex:1;min-width:160px">
        <i class="fas fa-utensils" style="margin-right:8px;font-size:.8rem"></i> Pesan Lagi
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
function downloadReceipt() {
    const el = document.getElementById('wn-receipt-card');
    const originalBg = el.style.background;
    el.style.background = '#fff';

    html2canvas(el, { scale: 2, useCORS: true, backgroundColor: '#ffffff' }).then(canvas => {
        el.style.background = originalBg;
        const link = document.createElement('a');
        link.download = 'struk-{{ $order->order_code }}.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }).catch(() => {
        el.style.background = originalBg;
        showToast('Gagal mengunduh struk, coba lagi.');
    });
}
</script>
@endsection