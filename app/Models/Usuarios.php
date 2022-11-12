<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Usuarios extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "usuarios";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
        'hash_rec_senha',
        'empresa_id',
        'admissao'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'hash_rec_senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function buscarUsuarios(
        ?string $pesquisa = "",
        ?int    $empresa_id = null,
        ?string $sortName = "id",
        ?string $sortOrder = "desc"
    )
    {
        return Usuarios::query()
            ->with("empresa")
            ->when(!empty($pesquisa), function ($query) use ($pesquisa) {
                $query->where("nome", "like", "%$pesquisa%");
                $query->orWhere("email", "like", "%$pesquisa%");
            })
            ->when(!empty($empresa_id), function ($query) use ($empresa_id) {
                $query->where("empresa_id", "=", $empresa_id);
            })
            ->orderBy($sortName, $sortOrder)
            ->paginate();
    }

    public function criarUsuario(array $dados): Usuarios
    {
        $dados["senha"] = Hash::make($dados['senha']);

        if (!empty($dados['admissao'])) $dados['admissao'] = date('Y-m-d H:i:s', strtotime($dados['admissao']));
        return Usuarios::create($dados);
    }

    public function editar($id, array $dados)
    {
        $usuario = Usuarios::where("id", $id)->first();

        if (!empty($dados["senha"])) {
            $dados["senha"] = Hash::make($dados['senha']);
        } else {
            unset($dados['senha']);
        }

        if (!empty($dados['admissao'])) $dados['admissao'] = date('Y-m-d H:i:s', strtotime($dados['admissao']));

        $usuario->fill($dados);
        $usuario->save($dados);
        return $usuario;
    }
}
