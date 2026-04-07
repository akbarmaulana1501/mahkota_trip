<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombongan extends Model
{
    use HasFactory;
    protected $table = 'rombongans'; // Nama tabel
    protected $fillable = [
        'kode_rombongan',
        'nama_rombongan',
        'id_paket',
        'status_asuransi',
        'id_pembimbing',
        'id_pembimbing2',
        'id_pembimbing3',
        'id_pembimbing4',
        'id_pembimbing5',
        'tgl_keberangkatan',
        'tanggal_kembali',
        'foto_asuransi',
        'jumlah_jamaah'
    ];

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'id_pembimbing');
    }
    public function pembimbing2()
    {
        return $this->belongsTo(Pembimbing::class, 'id_pembimbing2');
    }

    public function pembimbing3()
    {
        return $this->belongsTo(Pembimbing::class, 'id_pembimbing3');
    }

    public function pembimbing4()
    {
        return $this->belongsTo(Pembimbing::class, 'id_pembimbing4');
    }

    public function pembimbing5()
    {
        return $this->belongsTo(Pembimbing::class, 'id_pembimbing5');
    }
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}
