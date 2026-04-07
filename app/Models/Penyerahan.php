<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyerahan extends Model
{
    use HasFactory;

    protected $table = 'penyerahans';

    protected $fillable = [
        'jamaah_id',
        'tanggal_penyerahan',
        'bukti_penyerahan',
        'user_id',
        'status'
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function distribusiLogistik()
    {
        return $this->hasMany(DistribusiLogistik::class);
    }
}
