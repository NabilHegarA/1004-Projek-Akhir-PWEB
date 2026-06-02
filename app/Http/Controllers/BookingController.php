<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapak;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // HALAMAN BOOKING
    public function create($id)
    {
        $lapak = Lapak::findOrFail($id);

        if($lapak->status == 'unavailable'){
            return redirect()
                ->route('lapak.user')
                ->with('error', 'Lapak sedang tidak tersedia');
        }

        return view('user.booking', compact('lapak'));
    }

    // SIMPAN BOOKING
    public function store(Request $request, $id)
    {
        $lapak = Lapak::findOrFail($id);

        if($lapak->status == 'unavailable'){
            return back()->with(
                'error',
                'Lapak sedang tidak tersedia'
            );
        }

        if ($request->tanggal_booking < date('Y-m-d')) {
            return back()->withErrors([
                'tanggal_booking' => 'Tanggal tidak valid'
            ])->withInput();
        }

        // VALIDASI FULL
        $request->validate([
            'tanggal_booking' => 'required|date',
            'bukti_tf' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'metode_pembayaran' => 'required|in:BRI,BCA,Mandiri',
            'jumlah_orang' => 'required|in:1,2,3',
            'jam_booking' => 'required|in:08:00,11:00,14:00'
        ]);

        $lapak = Lapak::findOrFail($id);
        $total_harga = $lapak->harga * (int) $request->jumlah_orang;

        // CEK DOUBLE BOOKING (tanggal + jam)
        $cekBooking = Booking::where('lapak_id', $id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('jam_booking', $request->jam_booking)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($cekBooking) {
            return back()->withErrors([
                'jam_booking' => 'Jam ini sudah dibooking'
            ])->withInput();
        }

        // UPLOAD FILE
        $file = $request->file('bukti_tf');
        $namaFile = time() . '.' . $file->extension();
        $file->move(public_path('bukti_tf'), $namaFile);

        // SIMPAN BOOKING
        Booking::create([
            'user_id' => auth()->id(),
            'lapak_id' => $id,
            'tanggal_booking' => $request->tanggal_booking,
            'harga_snapshot' => $lapak->harga,
            'total_harga' => $total_harga,
            'bukti_tf' => $namaFile,
            'status' => 'pending',

            // NEW DATA
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_orang' => $request->jumlah_orang,
            'jam_booking' => $request->jam_booking
        ]);

        return redirect()
            ->route('lapak.user')
            ->with('success', 'Booking berhasil disimpan');
    }

    // TRANSAKSI USER
    public function transaksiUser(Request $request)
    {
        $query = Booking::with('lapak')
            ->where('user_id', auth()->id());

        // FILTER STATUS DARI DASHBOARD
        if ($request->status) {

            if ($request->status === 'all') {
                // tidak difilter
            }
            elseif ($request->status === 'finished') {
                // gabungan selesai
                $query->whereIn('status', ['completed', 'canceled', 'rejected']);
            }
            else {
                $query->where('status', $request->status);
            }
        }

        $bookings = $query->latest()->get();

        $pending = $bookings->where('status', 'pending');
        $confirmed = $bookings->where('status', 'confirmed');
        $finished = $bookings->whereIn('status', ['completed', 'canceled', 'rejected']);

        return view('user.transaksiUser', compact(
            'pending',
            'confirmed',
            'finished'
        ));
    }

    // TRANSAKSI ADMIN
    public function transaksiAdmin(Request $request)
    {
        $query = Booking::with(['lapak', 'user']);

        // SEARCH
        if ($request->search) {

            $query->whereHas('lapak', function ($q) use ($request) {

                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER JENIS
        if ($request->jenis) {

            $query->whereHas('lapak', function ($q) use ($request) {

                $q->where('jenis', $request->jenis);
            });
        }

        $bookings = $query
            ->latest()
            ->get();

        $pending = $bookings->where('status', 'pending');

        $confirmed = $bookings->where('status', 'confirmed');

        $finished = $bookings->whereIn('status', [
            'completed',
            'rejected',
            'canceled'
        ]);

        return view(
            'admin.transaksiAdmin',
            compact(
                'pending',
                'confirmed',
                'finished'
            )
        );
    }

    // KONFIRMASI
    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'confirmed';

        $booking->save();

        return back();
    }

    //TOLAK
    public function reject(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';
        $booking->rejection_reason = $request->rejection_reason;
        $booking->save();

        return back();
    }

    // SELESAI
    public function completeBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();
        return back();
    }

    //BATALKAN
    public function cancelBooking($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Booking tidak bisa dibatalkan'
            ]);
        }

        $booking->status = 'canceled';
        $booking->save();

        return back()->with('success', 'Booking berhasil dibatalkan');
    }

    public function liveSearch(Request $request)
    {
        $search = $request->search;
        $jenis = $request->jenis;
        $tanggal = $request->tanggal;
        $jam = $request->jam;

        $query = Booking::with(['lapak', 'user']);

        // USER ONLY FILTER
        if (auth()->user()->role == 'user') {
            $query->where('user_id', auth()->id());
        }

        // 🔍 SEARCH MULTI FIELD
        if ($search) {
            $query->where(function ($q) use ($search) {

                $q->whereHas('lapak', function ($lapak) use ($search) {
                    $lapak->where('nama', 'like', "%{$search}%")
                        ->orWhere('jenis', 'like', "%{$search}%");
                })

                ->orWhere('status', 'like', "%{$search}%");

                // ADMIN ONLY
                if (auth()->user()->role == 'admin') {
                    $q->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%");
                    });
                }

            });
        }

        // 🎯 FILTER JENIS KOLAM
        if ($jenis) {
            $query->whereHas('lapak', function ($q) use ($jenis) {
                $q->where('jenis', $jenis);
            });
        }

        // 📅 FILTER TANGGAL
        if ($tanggal) {
            $query->whereDate('tanggal_booking', $tanggal);
        }

        // ⏰ FILTER JAM
        if ($jam) {
            $query->where('jam_booking', $jam);
        }

        $bookings = $query->latest()->get();

        return response()->json($bookings);
    }

    public function getAvailableJam(Request $request, $lapakId)
    {
        $tanggal = $request->tanggal;

        $jamTerpakai = Booking::where('lapak_id', $lapakId)
            ->where('tanggal_booking', $tanggal)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('jam_booking')
            ->toArray();

        return response()->json($jamTerpakai);
    }
}
