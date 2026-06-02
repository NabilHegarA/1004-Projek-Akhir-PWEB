<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class AutoCompleteBooking extends Command
{
    protected $signature = 'booking:auto-complete';

    protected $description = 'Auto selesai booking jika waktu sudah lewat';

    public function handle()
    {
        $now = Carbon::now();

        $bookings = Booking::where('status', 'confirmed')->get();

        foreach ($bookings as $booking) {

            $bookingTime = Carbon::parse(
                $booking->tanggal_booking . ' ' . $booking->jam_booking
            );

            if ($bookingTime < $now) {
                $booking->update([
                    'status' => 'completed'
                ]);
            }
        }

        $this->info('Auto complete booking selesai dijalankan');
    }
}
