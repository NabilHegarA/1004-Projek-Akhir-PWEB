<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'lapak_id',
        'tanggal_booking',
        'harga_snapshot',
        'total_harga',
        'bukti_tf',
        'status',
        'metode_pembayaran',
        'jumlah_orang',
        'jam_booking'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapak()
    {
        return $this->belongsTo(Lapak::class);
    }
}
