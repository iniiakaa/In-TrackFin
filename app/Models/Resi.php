<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_resi',
        'nama_pengirim',
        'nama_penerima',
        'alamat_tujuan',
        'berat_barang',
        'tarif',
        'status',
        'catatan',
        'user_id',
    ];

    protected $casts = [
        'berat_barang' => 'decimal:2',
        'tarif' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function income()
    {
        return $this->hasOne(Income::class);
    }

    public static function generateNomorResi(): string
    {
        $date = now()->format('Ymd');
        $lastResi = static::where('nomor_resi', 'like', "CJR-{$date}-%")
            ->orderBy('nomor_resi', 'desc')
            ->first();

        if ($lastResi) {
            $lastNumber = (int) substr($lastResi->nomor_resi, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "CJR-{$date}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
