<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(Usuarios::class, 'empresa_id','id');
    }
}
