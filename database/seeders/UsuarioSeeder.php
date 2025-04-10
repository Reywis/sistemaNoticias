<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario con datos estáticos
        User::create([
            'name' => 'Admin Sistema',
            'email' => 'admin@noticia.com',
            'password' => Hash::make('123456789'),  // Asegúrate de usar un hash para la contraseña
        ]);


    }
}
