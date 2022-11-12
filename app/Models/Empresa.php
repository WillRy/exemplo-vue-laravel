<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nome',
        'email'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'empresa_id', 'id');
    }

    public function buscarEmpresas(
        ?string $pesquisa = "",
        ?string $sortName = "id",
        ?string $sortOrder = "desc"
    )
    {
        return Empresa::withCount('usuarios')
            ->when(!empty($pesquisa), function ($query) use ($pesquisa) {
                $query->where("nome", "like", "%$pesquisa%");
            })
            ->orderBy($sortName, $sortOrder)
            ->paginate(15);
    }

    public function criarEmpresa(array $dados): \stdClass
    {
        $retorno = new \stdClass();
        DB::transaction(function () use ($dados, $retorno) {

            $retorno->empresa = Empresa::create($dados);

            $idEmpresa = DB::getPdo()->lastInsertId();

            $dados['empresa_id'] = $idEmpresa;

            $dados["senha"] = Hash::make(Str::random(12));

            $retorno->empresa = Usuarios::create($dados);

        });

        return $retorno;
    }

    public function editar($id, array $dados)
    {
        $empresa = Empresa::where("id", $id)->first();
        $empresa->fill($dados);
        $empresa->save($dados);
        return $empresa;
    }
}
