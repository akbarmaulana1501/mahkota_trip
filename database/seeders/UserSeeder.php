<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => "admin",
            'email'=> "admin@gmail.com",
            'alamat'=> "jl.satu",
            'password' => Hash::make('123456'),
            'no_hp'=>"085678967765",
            'role'=>"admin"
        ]);

        User::create([
            'username' => "admin2",
            'email'=> "admin2@gmail.com",
            'alamat'=> "jl.dua",
            'password' => Hash::make('123456'),
            'no_hp'=>"085678967765",
            'role'=>"admin"
        ]);

        User::create([
            'username' => "marketing",
            'email'=> "marketing@gmail.com",
            'alamat'=> "jl.dua",
            'password' => Hash::make('123456'),
            'no_hp'=>"085678967765",
            'role'=>"marketing"
        ]);

        User::create([
            'username' => "logistik",
            'email'=> "logistik@gmail.com",
            'alamat'=> "jl.dua",
            'password' => Hash::make('123456'),
            'no_hp'=>"085678967765",
            'role'=>"logistik"
        ]);
        
    }
}

