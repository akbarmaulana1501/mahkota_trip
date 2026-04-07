<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPenyerahan extends Model
{
    use HasFactory;

    protected $table = 'bukti_penyerahans';

    protected $fillable = [
        'jamaah_id',
        'bukti_penyerahan'
    ];
}
