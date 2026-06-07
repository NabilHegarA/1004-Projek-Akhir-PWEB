<?php

namespace App\Http\Controllers;
use App\Models\Booking;

class UserController extends Controller
{

    public function dashboard()
    {
        $userId = auth()->id();

        $bookings = Booking::where('user_id', $userId)->get();

        return view('user.dashboardUser', [
            'total'      => $bookings->count(),
            'pending'    => $bookings->where('status', 'pending')->count(),
            'confirmed'  => $bookings->where('status', 'confirmed')->count(),
            'rejected'   => $bookings->where('status', 'rejected')->count(),
            'canceled'   => $bookings->where('status', 'canceled')->count(),
            'completed'  => $bookings->where('status', 'completed')->count(),
        ]);
    }
}
