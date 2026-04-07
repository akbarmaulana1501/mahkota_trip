<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siskopatu extends Model
{
    use HasFactory;
    protected $table = 'siskopatus'; // Nama tabel
    protected $fillable = [
        // Identitas dasar
        'id_jamaah',
        'title',
        'nama_lengkap',
        'nama_ayah',

        // Identitas
        'jenis_identitas',
        'no_identitas',

        // Paspor
        'nama_paspor',
        'no_paspor',
        'tgl_paspor',
        'kota_paspor',

        // Data lahir
        'tempat_lahir',
        'tanggal_lahir',

        // Alamat
        'alamat_lengkap',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',

        // Kontak
        'no_telepon',
        'no_hp',

        // Data pribadi
        'kewarganegaraan',
        'status_pernikahan',
        'pendidikan',

        // Pekerjaan
        'pekerjaan',
        'pekerjaan_lainnya',

        // Visa
        'provider_visa',
        'no_visa',
        'tgl_berlaku_visa',
        'tgl_akhir_visa',

        // Asuransi
        'asuransi',
        'no_polis',
        'tgl_input_polis',
        'tgl_awal_polis',
        'tgl_akhir_polis',

        // BPJS
        'no_bpjs',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tgl_paspor' => 'date',
        'tanggal_lahir' => 'date',
        'tgl_berlaku_visa' => 'date',
        'tgl_akhir_visa' => 'date',
        'tgl_input_polis' => 'date',
        'tgl_awal_polis' => 'date',
        'tgl_akhir_polis' => 'date',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }
}
