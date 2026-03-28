@extends('customer.layouts.master')

@section('content')

@php
    $status     = $order->status; // pending | preparing | ready
    $steps      = ['pending', 'settlement', 'cooked'];
    $stepIndex  = array_search($status, $steps);

    $stepInfo = [
        'pending'   => ['icon' => '🕐', 'label' => 'Menunggu Konfirmasi', 'desc' => 'Pesananmu sedang menunggu dikonfirmasi oleh kasir.'],
        'settlement' => ['icon' => '👨‍🍳', 'label' => 'Sedang Dimasak',      'desc' => 'Dapur sedang menyiapkan pesananmu, harap bersabar ya!'],
        'cooked'     => ['icon' => '✅', 'label' => 'Siap Diambil',         'desc' => 'Pesananmu sudah siap! Silakan ambil di meja kasir.'],
    ];
@endphp

{{-- ============================================================
     PAGE HEADER
     ============================================================ --}}
<div class="wn-animate" style="margin-bottom:20px">
    <div class="wn-page-title">Tracking Pesanan</div>
    <div class="wn-page-subtitle">Pantau status pesananmu secara real-time 🍽</div>
</div>

{{-- ============================================================
     ORDER CODE BADGE
     ============================================================ --}}
<div class="wn-card wn-animate" style="margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
    <div>
        <div style="font-size:.75rem;color:var(--text-secondary);margin-bottom:2px">Kode Pesanan</div>
        <div style="font-size:1.1rem;font-weight:800;color:var(--amber);letter-spacing:1px">{{ $order->order_code }}</div>
    </div>
    <div style="text-align:right">
        <div style="font-size:.75rem;color:var(--text-secondary);margin-bottom:2px">Nomor Meja</div>
        <div style="font-size:1rem;font-weight:700;color:var(--text-primary)">Meja {{ $order->table_number }}</div>
    </div>
    <div style="text-align:right">
        <div style="font-size:.75rem;color:var(--text-secondary);margin-bottom:2px">Total Bayar</div>
        <div style="font-size:1rem;font-weight:700;color:var(--text-primary)">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</div>
    </div>
</div>

{{-- ============================================================
     STATUS CARD (big icon + current status)
     ============================================================ --}}
<div class="wn-card wn-animate wn-d1" style="margin-bottom:16px;text-align:center;padding:32px 20px">
    <div id="statusIcon" style="font-size:3.5rem;margin-bottom:12px;animation:wnPulse 2s ease-in-out infinite">
        {{ $stepInfo[$status]['icon'] }}
    </div>
    <div id="statusLabel" style="font-size:1.15rem;font-weight:800;color:var(--text-primary);margin-bottom:6px">
        {{ $stepInfo[$status]['label'] }}
    </div>
    <div id="statusDesc" style="font-size:.85rem;color:var(--text-secondary);max-width:320px;margin:0 auto">
        {{ $stepInfo[$status]['desc'] }}
    </div>

    {{-- AUTO REFRESH INDICATOR --}}
    <div style="margin-top:16px;display:flex;align-items:center;justify-content:center;gap:6px;font-size:.75rem;color:var(--text-secondary)">
        <span id="refreshDot" style="width:7px;height:7px;border-radius:50%;background:#48bb78;display:inline-block;animation:wnBlink 1.2s ease-in-out infinite"></span>
        Otomatis update dalam <span id="countdown" style="font-weight:700;color:var(--amber)">10</span> detik
    </div>
</div>

{{-- ============================================================
     STEPPER
     ============================================================ --}}
<div class="wn-card wn-animate wn-d2" style="margin-bottom:16px">
    <div style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin-bottom:20px">Progress Pesanan</div>

    <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative">

        {{-- connector line --}}
        <div style="position:absolute;top:18px;left:calc(16.6%);right:calc(16.6%);height:3px;background:var(--border);border-radius:4px;z-index:0">
            <div id="progressBar" style="height:100%;border-radius:4px;background:var(--amber);transition:width .6s ease;width:{{ $stepIndex === 0 ? '0%' : ($stepIndex === 1 ? '50%' : '100%') }}"></div>
        </div>

        @foreach($steps as $i => $step)
        @php
            $done    = $i < $stepIndex;
            $current = $i === $stepIndex;
        @endphp
        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;flex:1;position:relative;z-index:1">
            <div style="
                width:36px;height:36px;border-radius:50%;
                display:flex;align-items:center;justify-content:center;
                font-size:1rem;font-weight:700;
                background:{{ $done ? 'var(--amber)' : ($current ? 'var(--amber)' : 'var(--bg-secondary)') }};
                color:{{ ($done || $current) ? '#fff' : 'var(--text-secondary)' }};
                border: 2.5px solid {{ ($done || $current) ? 'var(--amber)' : 'var(--border)' }};
                box-shadow: {{ $current ? '0 0 0 4px var(--amber-pale)' : 'none' }};
                transition: all .4s ease;
            ">
                @if($done) ✓ @else {{ $i + 1 }} @endif
            </div>
            <div style="font-size:.72rem;font-weight:{{ $current ? '700' : '500' }};color:{{ $current ? 'var(--amber)' : ($done ? 'var(--text-primary)' : 'var(--text-secondary)') }};text-align:center;line-height:1.3">
                {{ $stepInfo[$step]['label'] }}
            </div>
        </div>
        @endforeach

    </div>
</div>

{{-- ============================================================
     ORDER ITEMS
     ============================================================ --}}
<div class="wn-card wn-animate wn-d3" style="margin-bottom:16px">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
        <div style="width:34px;height:34px;border-radius:10px;background:var(--amber-pale);display:flex;align-items:center;justify-content:center">
            <i class="fas fa-receipt" style="color:var(--amber);font-size:.85rem"></i>
        </div>
        <div style="font-size:.95rem;font-weight:600;color:var(--text-primary)">Pesananmu</div>
    </div>

    @foreach($orderItems as $orderItem)
    <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
        <div style="width:48px;height:48px;border-radius:10px;overflow:hidden;flex-shrink:0;background:var(--amber-pale)">
            <img src="{{ $orderItem->item->img }}"
                 style="width:100%;height:100%;object-fit:cover"
                 alt="{{ $orderItem->item->name }}"
                 onerror="this.onerror=null;this.src='https://via.placeholder.com/48x48/FDE8C4/8B6340?text=🍜'">
        </div>
        <div style="flex:1;min-width:0">
            <div style="font-size:.875rem;font-weight:600;color:var(--text-primary)">{{ $orderItem->item->name }}</div>
            <div style="font-size:.75rem;color:var(--text-secondary);margin-top:2px">
                {{ $orderItem->quantity }} × Rp{{ number_format($orderItem->total_price, 0, ',', '.') }}
            </div>
        </div>
        <div style="font-size:.9rem;font-weight:700;color:var(--amber);flex-shrink:0">
            Rp{{ number_format($orderItem->total_price, 0, ',', '.') }}
        </div>
    </div>
    @endforeach
    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0 0">
        <div style="font-size:.9rem;font-weight:700;color:var(--text-primary)">Total Bayar</div>
        <div style="font-size:1.05rem;font-weight:800;color:var(--amber)">
            Rp{{ number_format($order->grand_total, 0, ',', '.') }}
        </div>
    </div>
</div>

{{-- ============================================================
     DONE STATE — tampil hanya jika ready
     ============================================================ --}}
@if($status === 'cooked')
<div class="wn-card wn-animate" style="background:linear-gradient(135deg,#f6ffed,#fffbe6);border:1.5px solid #b7eb8f;text-align:center;padding:24px">
    <div style="font-size:2.5rem;margin-bottom:8px">🎉</div>
    <div style="font-size:1rem;font-weight:700;color:#389e0d;margin-bottom:4px">Pesananmu Siap!</div>
    <div style="font-size:.83rem;color:#52c41a">Silakan ambil pesananmu di kasir ya!</div>
</div>
@endif

@endsection

@section('script')
<script>
    /* ============================================================
       AUTO REFRESH COUNTDOWN
       ============================================================ */
    @if($status !== 'cooked')
    let timeLeft = 10;
    const countdownEl = document.getElementById('countdown');

    const timer = setInterval(() => {
        timeLeft--;
        if (countdownEl) countdownEl.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(timer);
            location.reload();
        }
    }, 1000);
    @else
    // Sudah ready — sembunyikan indicator refresh
    document.addEventListener('DOMContentLoaded', () => {
        const dot = document.getElementById('refreshDot');
        const cd  = document.getElementById('countdown');
        if (dot && dot.parentElement) {
            dot.parentElement.innerHTML =
                '<span style="color:#52c41a;font-weight:600">✓ Pesanan sudah siap diambil</span>';
        }
    });
    @endif
</script>

<style>
@keyframes wnPulse {
    0%,100% { transform: scale(1); }
    50%      { transform: scale(1.08); }
}
@keyframes wnBlink {
    0%,100% { opacity: 1; }
    50%      { opacity: .3; }
}
</style>
@endsection