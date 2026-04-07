<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiLogistik extends Model
{
    use HasFactory;

    protected $table = 'distribusi_logistiks';

    protected $fillable = [
        'penyerahan_id',
        'logistik_id',
    ];


    public function penyerahan()
    {
        return $this->belongsTo(Penyerahan::class);
    }

    public function logistik()
    {
        return $this->belongsTo(Logistik::class);
    }
}
