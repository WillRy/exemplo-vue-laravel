<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpresaController extends Controller
{

    public function index()
    {
        return Inertia::render("Empresas/Index");
    }

    public function listar(Request $request)
    {

        try {
            $empresas = (new Empresa())->buscarEmpresas(
                $request->input("pesquisa"),
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
            "email" => "required|email|max:255|unique:empresas,email"
        ]);

        try {
            (new Empresa())->criarEmpresa($dados);
            return $this->successInertia("Empresa criada com sucesso!");
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function editar(Request $request, $id)
    {
        $dados = $request->validate([
            "nome" => "required|max:255",
            "email" => "required|email|max:255|unique:empresas,email,$id"
        ]);

        try {
            (new Empresa())->editar($id, $dados);
            return $this->successInertia("Empresa editada com sucesso!");
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function excluir(Request $request, $id)
    {
        try {
            $empresa = Empresa::find($id);
            if (empty($empresa->principal)) {
                Empresa::destroy($empresa->id);
                return $this->successInertia("Empresa excluída com sucesso!");
            }

            throw new \Exception("Empresa principal não pode ser excluída");

        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function detalhes(Request $request, $id)
    {

        try {
            $empresa = Empresa::where("id", $id)->first();

            if (empty($empresa)) {
                throw new \Exception('Empresa não encontrada');
            }

            return $this->successAPI($empresa);
        } catch (\Exception $e) {
            return $this->errorAPI($e->getMessage());
        }
    }
}
