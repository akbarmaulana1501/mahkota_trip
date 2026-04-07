<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbings'; // Nama tabel
    protected $fillable = ['nama_lengkap', 'no_hp', 'email', 'alamat'];
}
