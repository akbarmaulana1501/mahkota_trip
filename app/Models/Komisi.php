<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    use HasFactory;

    protected $table = 'komisis';

    protected $fillable = [
        'jamaah_id',
        'marketing_id',
        'nominal_komisi',
        'keterangan',
        'status',
        'tgl_cair'
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'jamaah_id');
    }

    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id', 'referral_code');
    }
}
