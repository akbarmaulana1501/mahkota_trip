<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    use HasFactory;

    protected $table = 'jamaahs';

    protected $fillable = [
        // Step 1
        'paket_id',
        'nama_depan',
        'nama_belakang',
        'jenis_kelamin',
        'tanggal_lahir',
        'email',
        'alamat_lengkap',
        'kontak_darurat_nama',
        'kontak_darurat_hp',
        'nominal',
        'paket',
        'harga_paket',
        'nama_ayah',
        'tempat_lahir',
        'status_pernikahan',
        'pekerjaan',
        'pendidikan',
        // Step 2
        'status_passport',
        'no_ktp',
        'foto_ktp',
        'no_kk',
        'foto_kk',
        'foto_paspor',
        'no_pasport',
        'tgl_terbit',
        'tgl_exp',
        'daerah_terbit',
        'foto_akte',
        'tgl_keberangkatan',

        // Step 3
        'status_vaksin_meningitis',
        'foto_vaksin',

        // Step 4
        'bukti_bayar_dp',
        'status_validasi',
        'status_visa',
        'status_asuransi',
        'status_keberangkatan',
        'status_logistik',
        'id_rombongan'
    ];

    public function pakets()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    // Relasi ke tabel payments (pembayaran mandiri)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id'); // sesuaikan foreign key
    }

    // Relasi ke tabel pembayarans (dibantu admin)
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'user_id'); // sesuaikan foreign key
    }

    public function siskopatu()
    {
        return $this->hasOne(Siskopatu::class, 'id_jamaah', 'id');
    }

    public function pemasukan()
    {
        return $this->hasMany(Pemasukan::class, 'id_jamaah');
    }

    public function investasis()
    {
        return $this->hasMany(Investasi::class);
    }

    public function rombongan()
    {
        return $this->belongsTo(Rombongan::class, 'id_rombongan', 'kode_rombongan');
    }

    public function penyerahan()
    {
        return $this->hasMany(Penyerahan::class);
    }

    public function logistik()
    {
        return $this->belongsTo(Logistik::class);
    }

    public function tiket()
    {
        return $this->hasOne(TiketBerangkat::class, 'id_jamaah', 'id');
    }
}
