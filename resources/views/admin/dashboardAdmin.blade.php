@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">
@endsection

@section('content')
<section class="content">

    <div class="dashboard-header">
        <h2>Dashboard</h2>
        <p>Ringkasan sistem HookPoint</p>
    </div>

    <div class="content-header">
        <a href="{{ url('/admin/tambahlapak') }}" class="btn-tambah">
            + Tambah Data Lapak
        </a>
    </div>

    <div class="cards">

        <div class="card">
            <h3>Total Pendapatan</h3>

            <h1>
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h1>
        </div>

        <div class="card">
            <h3>Total Transaksi</h3>

            <h1>
                {{ $totalTransaksi }}
            </h1>
        </div>

        <div class="card">
            <h3>Lapak Aktif</h3>

            <h1>
                {{ $lapakAktif }}
            </h1>
        </div>
    </div>

    {{-- ================= TRANSAKSI TERBARU ================= --}}
    <div class="table-card">

        <div class="table-header">
            <h3>Daftar Transaksi</h3>

            <form method="GET">
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input
                    type="date"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                >

                <button type="submit">
                    Filter
                </button>
            </form>
        </div>

        <div class="table-wrapper">
            <table>

                <thead>
                    <tr>
                        <th>User</th>
                        <th>Lapak</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($transaksis as $trx)
                        <tr>

                            <td>{{ $trx->user->name }}</td>

                            <td>{{ $trx->lapak->nama }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($trx->tanggal_booking)->translatedFormat('d M Y') }}
                            </td>

                            <td>{{ $trx->jam_booking }}</td>

                            <td>
                                <span class="status {{ $trx->status }}">
                                    @php
                                        $statusLabel = [
                                            'pending' => 'Menunggu',
                                            'confirmed' => 'Dikonfirmasi',
                                            'rejected' => 'Ditolak',
                                            'canceled' => 'Dibatalkan',
                                            'completed' => 'Selesai',
                                        ];
                                    @endphp

                                    {{ $statusLabel[$trx->status] ?? $trx->status }}
                                </span>
                            </td>

                            <td>
                                Rp {{ number_format($trx->total_harga,0,',','.') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                Tidak ada transaksi
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
</section>
@endsection
