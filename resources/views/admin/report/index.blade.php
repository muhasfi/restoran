@extends('admin.layouts.master')
@section('title', 'Daftar Report')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 report-md-1 report-last">
                <h3>Daftar Report</h3>
                <p class="text-subtitle text-muted">Informasi Report yang Masuk</p>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="month" class="form-select">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach(range(1,12) as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0,0,0,$m,1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="year" class="form-select">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach(range(date('Y'), 2020) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('report') }}" class="btn btn-secondary">Reset</a>
                            <a href="{{ route('reports.export', request()->only('month', 'year')) }}" class="btn btn-success" target="_blank">
                                <i class="bi bi-printer"></i> Print
                            </a>
                        </div>
                    </div>
                </form>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Total</th>
                            <th>No. Meja</th>
                            <th>Metode Pembayaran</th>
                            <th>Catatan</th>
                            <th>Dibuat Pada</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->order_code }}</td>
                            <td>{{ $report->customer_name }}</td>
                            <td>{{ 'Rp'. number_format($report->grand_total, 0, ',', '.') }}</td>
                            <td>{{ $report->table_number }}</td>
                            <td>{{ $report->payment_method }}</td>
                            <td>{{ $report->note ?? '-' }}</td>
                            <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="btn btn-primary btn-sm">
                                    <a href="{{ route('reports.show', $report->id) }}" class="text-white">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </span>
                            </td>
                            <td>
                                
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection