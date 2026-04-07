<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketBerangkat extends Model
{
    use HasFactory;
    protected $table = 'tiket_berangkats'; // Nama tabel
    protected $fillable = [
        'id_jamaah',
        'maskapai',
        'bandara',
        'jenis',
        'tgl_berangkat',
        'waktu_berangkat',
        'waktu_sampai',
        'kode',
        'created_by'
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah');
    }
}
