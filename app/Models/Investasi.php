<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investasi extends Model
{
    use HasFactory;

    protected $table = 'investasis';

    protected $fillable = [
        // Step 1
        'jamaah_id',
        'tanggal',
        'jumlah',
        'keterangan'
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }
}
