<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maskapai extends Model
{
    use HasFactory;

    protected $table = 'maskapais'; // Nama tabel
    protected $fillable = ['nama_maskapai','kode_maskapai'];
}
