<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;
    protected $table = 'pemasukans';
    protected $fillable = [
        'id_jamaah',
        'jumlah',
        'keterangan',
        'angsuran_ke',
        'bukti',
        'status',
        'created_by'
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah');
    }
}
