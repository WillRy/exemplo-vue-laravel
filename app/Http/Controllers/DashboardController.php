<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuarios;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render("Dashboard");
    }

    public function indicativos()
    {
        try {
            $indicativos = new \stdClass();

            $indicativos->qtd_empresas = Empresa::count();
            $indicativos->qtd_usuarios = Usuarios::count();

            return $this->successAPI($indicativos);
        } catch (\Exception $e) {
            return $this->errorAPI($e->getMessage());
        }
    }
}
