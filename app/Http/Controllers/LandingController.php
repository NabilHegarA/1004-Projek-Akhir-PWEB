<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapak;

class LandingController extends Controller
{
    public function index()
    {
        $lapaks = Lapak::all();

        $rekapLapak = $lapaks->groupBy('jenis')->map(function ($item, $jenis) {
            return [
                'jenis' => $jenis,
                'total' => $item->count(),
                'available' => $item->where('status', 'available')->count(),
            ];
        });

        return view('landing.landing-page', compact('lapaks', 'rekapLapak'));
    }
}
