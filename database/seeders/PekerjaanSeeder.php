<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            'PNS',
            'TNI',
            'POLRI',
            'Karyawan Swasta',
            'Wiraswasta',
            'Pedagang',
            'Petani',
            'Nelayan',
            'Buruh',
            'Guru',
            'Dosen',
            'Dokter',
            'Perawat',
            'Apoteker',
            'Pengacara',
            'Notaris',
            'Ibu Rumah Tangga',
            'Pelajar / Mahasiswa',
            'Pensiunan',
            'Lainnya',
        ];

        foreach ($data as $nama) {
            Pekerjaan::create([
                'nama_pekerjaan'=>$nama
            ]);
        }
    }
}
