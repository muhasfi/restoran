@extends('customer.layouts.master')

@section('content')
<div class="container py-5">
    <div class="rk-receipt rk-animate">

        {{-- Success Icon --}}
        <div class="rk-success-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>

        <div style="font-size:1.1rem;font-weight:600;color:var(--text-primary);margin-bottom:.5rem">
            Pesanan Berhasil Dibuat!
        </div>

        {{-- Status Badge --}}
        @if($order->payment_method == 'tunai' && $order->status == 'pending')
            <span class="rk-status-badge rk-status-pending">
                <i class="fas fa-clock me-1"></i> Menunggu Pembayaran
            </span>
        @elseif($order->payment_method == 'qris' && $order->status == 'pending')
            <span class="rk-status-badge rk-status-pending">
                <i class="fas fa-clock me-1"></i> Menunggu Konfirmasi Pembayaran
            </span>
        @else
            <span class="rk-status-badge rk-status-success">
                <i class="fas fa-check-circle me-1"></i> Pembayaran Berhasil
            </span>
        @endif

        {{-- Order Code --}}
        <div style="background:var(--bg-secondary);border-radius:14px;border:1px solid var(--border-color);padding:1rem;margin:1rem 0">
            <div style="font-size:.75rem;color:var(--text-secondary);margin-bottom:.25rem">Kode Bayar</div>
            <div class="rk-order-code">{{ $order->order_code }}</div>
            <div style="font-size:.75rem;color:var(--text-secondary);margin-top:.25rem">
                @if($order->payment_method == 'tunai')
                    Tunjukkan kode ini ke kasir untuk menyelesaikan pembayaran
                @else
                    Simpan kode ini sebagai bukti pesanan Anda
                @endif
            </div>
        </div>

        {{-- Order Items --}}
        <div style="text-align:left;width:100%;margin-bottom:1rem">
            <div style="font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.5px">Detail Pesanan</div>
            @foreach($orderItems as $orderItem)
                <div class="rk-receipt-row">
                    <span>{{ Str::limit($orderItem->item->name, 25) }} ({{ $orderItem->quantity }})</span>
                    <span>Rp{{ number_format($orderItem->price, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        {{-- Totals --}}
        <div style="text-align:left;width:100%;margin-bottom:1rem">
            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:var(--text-secondary);padding:5px 0;border-bottom:1px solid var(--border-color)">
                <span>Subtotal</span>
                <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:var(--text-secondary);padding:5px 0;border-bottom:1px solid var(--border-color)">
                <span>Pajak (10%)</span>
                <span>Rp{{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            <div class="rk-receipt-total">
                <span>Total</span>
                <span style="color:var(--brand)">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Info pesan --}}
        <div style="background:var(--brand-light);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.8rem;color:var(--brand-dark);text-align:center;border:1px solid rgba(230,126,34,.2)">
            @if($order->payment_method == 'tunai')
                <i class="fas fa-info-circle me-1"></i>
                Tunjukkan kode bayar ke kasir. Jangan lupa senyum ya!
            @else
                <i class="fas fa-check-circle me-1"></i>
                Yeay! Pembayaran sukses. Duduk manis, pesanan sedang diproses!
            @endif
        </div>

        <a href="{{ route('menu') }}" class="rk-cta">
            <i class="fas fa-utensils me-2" style="font-size:.8rem"></i> Kembali ke Menu
        </a>
    </div>
</div>
@endsection
