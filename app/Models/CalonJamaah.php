<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonJamaah extends Model
{
    use HasFactory;

    protected $table = 'calon_jamaahs';

    protected $fillable = [
        // Step 1
        'nama_jamaah',
        'jenis_kelamin',
        'no_hp',
        'email',
        'tanggal_lahir',
        'paket_diminati',
        'status',
        'alamat_lengkap',
        'referral_code',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_diminati');
    }

    public function marketing()
    {
        return $this->belongsTo(User::class, 'referral_code');
    }
}
