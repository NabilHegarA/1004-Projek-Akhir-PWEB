<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapak;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // ================= CARD =================
        $totalTransaksi = Booking::count();

        $totalPendapatan = Booking::whereIn('status', [
            'pending',
            'confirmed',
            'completed',
            'canceled'
        ])->sum('total_harga');

        $lapakAktif = Lapak::count();

        // ================= FILTER TANGGAL =================
        $query = Booking::with(['user', 'lapak']);

        if ($request->tanggal) {
            $query->whereDate('tanggal_booking', $request->tanggal);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->get();

        return view('admin.dashboardAdmin', compact(
            'totalPendapatan',
            'totalTransaksi',
            'lapakAktif',
            'transaksis'
        ));
    }

    public function transaksi()
    {
        return view('admin.transaksiAdmin');
    }
}
