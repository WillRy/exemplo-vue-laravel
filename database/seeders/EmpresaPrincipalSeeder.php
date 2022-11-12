<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Usuarios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmpresaPrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = Empresa::create([
            'nome' => 'Administrador',
            'email' => 'administrador@teste.com',
            'principal' => true,
        ]);
        Usuarios::create([
            'nome' => 'Administrador',
            'email' => 'administrador@teste.com',
            'senha' => Hash::make("123456"),
            'empresa_id' => $empresa->id
        ]);
    }
}
