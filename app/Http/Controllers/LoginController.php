<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login()
    {
        return Inertia::render("Auth/Login");
    }

    public function logar(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required',
            'senha' => 'required'
        ]);

        try {

            $usuario = Usuarios::where('email', $dados['email'])->first();

            if (empty($usuario)) {
                throw new \Exception("Usuário ou senha inválidos!");
            }


            if (!Hash::check($dados['senha'], $usuario->senha)) {
                throw new \Exception("Usuário ou senha inválidos!");
            }

            Auth::guard("usuarios")->login($usuario);


            return $this->successInertia("Bem vindo!", [], 'dashboard');
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function cadastro()
    {
        return Inertia::render("Auth/Cadastro");
    }

    public function cadastrar(Request $request)
    {

        $dados = $request->validate([
            'nome' => 'required',
            'email' => 'required|unique:usuarios,email',
            'senha' => 'required|min:6'
        ]);

        try {
            DB::transaction(function () use ($dados) {

                $empresa = Empresa::create($dados);

                $dados['senha'] = Hash::make($dados['senha']);

                $empresa->usuarios()->create($dados);

                $usuario = Usuarios::find(DB::getPdo()->lastInsertId());

                Auth::guard("usuarios")->setUser($usuario);

            });


            return $this->successInertia("Bem vindo!", [], 'dashboard');
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function logout()
    {
        Auth::guard('usuarios')->logout();
        return $this->successInertia(null, [], 'login');
    }
}
