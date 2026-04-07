<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets'; // Nama tabel
    protected $fillable = ['nama_paket','jenis_paket','tgl_berangkat','kuota','hotel_mekkah','lokasi_mekkah','hotel_madinah','lokasi_madinah','harga_paket','deskripsi'];

    public function jamaah()
    {
        return $this->hasMany(Jamaah::class, 'paket_id');
    }
}
