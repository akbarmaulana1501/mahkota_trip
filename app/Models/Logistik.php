<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistik extends Model
{
    use HasFactory;
    
    protected $table = 'logistiks';

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'bukti_penyerahan'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
