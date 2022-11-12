<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {
        return Inertia::render("Usuarios/Index");
    }

    public function listar(Request $request)
    {
        try {
            $empresas = (new Usuarios())->buscarUsuarios(
                $request->input("pesquisa"),
                $request->input("empresa_id"),
                $request->input("sortName", "id"),
                $request->input("sortOrder", "desc"),
            );

            return $this->successAPI($empresas);
        } catch (\Exception $e) {
            return $this->errorAPI($e->getMessage());
        }
    }

    public function cadastrar(Request $request)
    {
        $dados = $request->validate([
            "nome" => "required|max:255",
            "email" => "required|email|max:255|unique:usuarios,email",
            "senha" => "required|min:6|max:12",
            "empresa_id" => "required|exists:empresas,id",
            "admissao" => "nullable|date",
        ], [
            'empresa_id.required' => 'O campo Empresa é requerido',
            'empresa_id.exists' => 'O campo Empresa é requerido',
            'admissao.date' => 'O campo Admissão deve ser uma data',
        ]);

        try {
            (new Usuarios())->criarUsuario($dados);
            return $this->successInertia("Usuário criado com sucesso!");
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function editar(Request $request, $id)
    {
        $dados = $request->validate([
            "nome" => "required|max:255",
            "email" => "required|email|max:255|unique:usuarios,email,$id",
            "senha" => "nullable|min:6|max:12",
            "admissao" => "nullable|date",
        ], [
            'admissao.date' => 'O campo Admissão deve ser uma data',
        ]);

        try {
            (new Usuarios())->editar($id, $dados);
            return $this->successInertia("Usuário editado com sucesso!");
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function excluir(Request $request, $id)
    {
        try {
            $usuario = Usuarios::find($id);

            if (empty($usuario)) {
                throw new \Exception("Usuário não encontrado");
            }

            $empresa = Empresa::withCount('usuarios')->find($usuario->empresa_id);

            if ($empresa->usuarios_count <= 1) {
                throw new \Exception("Não é possível excluir o único usuário da empresa");
            }

            Usuarios::destroy($id);

            return $this->successInertia("Usuário excluído com sucesso!");

        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function detalhes(Request $request, $id)
    {
        try {

            $usuario = Usuarios::with("empresa")->where("id", $id)->first();

            if (empty($usuario)) {
                throw new \Exception('Usuário não encontrada');
            }

            return $this->successAPI($usuario);
        } catch (\Exception $e) {
            return $this->errorAPI($e->getMessage());
        }
    }
}
