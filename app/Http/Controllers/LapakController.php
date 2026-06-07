<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapak;
use App\Models\Booking;

class LapakController extends Controller
{
    // ================= LANDING =================
    public function landing(Request $request)
    {
        $lapaks = $this->filterLapak($request);

        return view('landing.lapak', compact('lapaks'));
    }


    // ================= ADMIN =================
    public function admin(Request $request)
    {
        $lapaks = $this->filterLapak($request);

        return view('admin.pengelolaan', compact('lapaks'));
    }


    // ================= USER =================
    public function user()
    {
        $lapaks = Lapak::all();

        return view('user.lapakUser', compact('lapaks'));
    }

    // ================= FILTER =================
    private function filterLapak(Request $request)
    {
        $query = Lapak::query();

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // FILTER JENIS
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        return $query->get();
    }

    public function liveSearch(Request $request)
    {
        $query = Lapak::query();

        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%")
                ->orWhere('jenis', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $lapaks = $query->get();

        return response()->json($lapaks);
    }

    // ================= CREATE =================
    public function create()
    {
        return view('admin.tambahlapak');
    }


    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'status' => 'required',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $gambar = time() . '.' . $request->gambar->extension();

        $request->gambar->move(
            public_path('uploads'),
            $gambar
        );

        Lapak::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'gambar' => $gambar,
        ]);

        return redirect('/admin/pengelolaan')
            ->with('success', 'Lapak berhasil ditambahkan');
    }


    // ================= EDIT =================
    public function edit($id)
    {
        $lapak = Lapak::findOrFail($id);

        return view('admin.editlapak', compact('lapak'));
    }


    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $lapak = Lapak::findOrFail($id);

        $lapak->nama = $request->nama;
        $lapak->jenis = $request->jenis;
        $lapak->harga = $request->harga;
        $lapak->deskripsi = $request->deskripsi;
        $lapak->status = $request->status;

        if ($request->hasFile('gambar')) {

            $gambar = time() . '.' . $request->gambar->extension();

            $request->gambar->move(
                public_path('uploads'),
                $gambar
            );

            $lapak->gambar = $gambar;
        }

        $lapak->save();

        return redirect('/admin/pengelolaan')
            ->with('success', 'Lapak berhasil diperbarui');
    }
}
