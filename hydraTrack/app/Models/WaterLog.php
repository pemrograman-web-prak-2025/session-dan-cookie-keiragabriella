<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterLog extends Model
{
    use HasFactory;
    
    // Kolom yang dapat diisi secara massal (mass assignable).
    // user_id dan amount_ml adalah kolom yang kita tambahkan di migrasi.
    protected $fillable = [
        'user_id',
        'amount_ml',
    ];

    /**
     * Definisikan relasi ke Model User (Auth).
     * Satu Catatan Air (WaterLog) dimiliki oleh satu User.
     */
    public function user()
    {
        // Hubungan Many-to-One
        return $this->belongsTo(User::class);
    }
}