<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report {{ $month }} {{ $year }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #fff;
            padding: 30px 40px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .header-left h1 {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 0.5px;
        }
        .header-left p {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
            font-size: 12px;
            color: #555;
        }
        .header-right .badge-period {
            display: inline-block;
            background: #2c3e50;
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        /* ── Summary Cards ── */
        .summary {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }
        .summary-card {
            flex: 1;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 14px 18px;
            background: #f8f9fa;
        }
        .summary-card .label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .summary-card .value {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }
        .summary-card.highlight {
            background: #2c3e50;
            border-color: #2c3e50;
        }
        .summary-card.highlight .label,
        .summary-card.highlight .value {
            color: #fff;
        }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 12px;
        }
        thead tr {
            background: #2c3e50;
            color: #fff;
        }
        thead th {
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }
        tbody tr:nth-child(even) {
            background: #f5f6f7;
        }
        tbody tr:hover {
            background: #eaf0fb;
        }
        tbody td {
            padding: 9px 12px;
            border-bottom: 1px solid #e8e8e8;
            vertical-align: middle;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ── Footer ── */
        .footer {
            border-top: 2px solid #e0e0e0;
            padding-top: 14px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #888;
        }
        .total-row {
            background: #ecf0f1 !important;
            font-weight: 700;
        }
        .total-row td {
            border-top: 2px solid #bdc3c7;
            color: #2c3e50;
        }

        /* ── Print Button (hanya muncul di layar) ── */
        .action-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }
        .btn-print {
            background: #2c3e50;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-print:hover { background: #1a252f; }
        .btn-back {
            background: #fff;
            color: #2c3e50;
            border: 1px solid #2c3e50;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-back:hover { background: #f0f0f0; }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        @media print {
            .action-bar { display: none !important; }
            body { padding: 10px 20px; }
            thead tr { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .summary-card.highlight { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    {{-- Action Bar (tidak ikut terprint) --}}
    <div class="action-bar">
        <a href="{{ route('report') }}" class="btn-back">
            &#8592; Kembali
        </a>
        <button class="btn-print" onclick="window.print()">
            &#128438; Cetak / Unduh PDF
        </button>
    </div>

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <h1>Laporan Penjualan</h1>
            <p>{{ config('app.name', 'Aplikasi Kasir') }}</p>
        </div>
        <div class="header-right">
            <div class="badge-period">{{ $month }} {{ $year }}</div>
            <div>Dicetak: {{ now()->format('d-m-Y H:i') }}</div>
        </div>
    </div>

    @php
        $total        = $reports->sum('grand_total');
        $totalOrders  = $reports->count();
        $avgPerOrder  = $totalOrders > 0 ? $total / $totalOrders : 0;

        // Rekap per metode pembayaran
        $byPayment = $reports->groupBy('payment_method')
                             ->map(fn($g) => $g->sum('grand_total'));
    @endphp

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Pesanan</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="summary-card highlight">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp{{ number_format($total, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Rata-rata / Pesanan</div>
            <div class="value">Rp{{ number_format($avgPerOrder, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Table --}}
    @if ($reports->isEmpty())
        <div class="empty-state">
            <p>Tidak ada data untuk periode ini.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kode Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>No. Meja</th>
                    <th>Metode Pembayaran</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $report->order_code }}</td>
                    <td>{{ $report->customer_name }}</td>
                    <td class="text-center">{{ $report->table_number }}</td>
                    <td>{{ $report->payment_method }}</td>
                    <td>{{ $report->note ?? '-' }}</td>
                    <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                    <td class="text-right">Rp{{ number_format($report->grand_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                {{-- Total Row --}}
                <tr class="total-row">
                    <td colspan="7" class="text-right">TOTAL</td>
                    <td class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Rekap per Metode Pembayaran --}}
        @if ($byPayment->count() > 1)
        <table style="width: 300px; margin-left: auto; margin-bottom: 24px;">
            <thead>
                <tr>
                    <th colspan="2">Rekap Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($byPayment as $method => $amount)
                <tr>
                    <td>{{ $method }}</td>
                    <td class="text-right">Rp{{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    @endif

    {{-- Footer --}}
    <div class="footer">
        <span>Periode: {{ $month }} {{ $year }}</span>
        <span>Total {{ $totalOrders }} transaksi &bull; Dicetak {{ now()->format('d-m-Y H:i') }}</span>
    </div>

</body>
</html>