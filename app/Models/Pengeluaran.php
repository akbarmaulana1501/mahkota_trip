<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluarans';
    protected $fillable = [
        'item',
        'kuantiti',
        'satuan',
        'harga_satuan',
        'total_harga',
        'created_by',
        'verified_by',
        'validation_by',
        'verified_at',
        'validation_at',
        'bukti'
    ];
}
