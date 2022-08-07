<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome', 'imagem'];

    public function rules()
    {
        return [
            'nome' => 'required|unique:marcas',
            'imagem' => 'required'
        ];
    }
    public function feedback()
    {
        return [
            'required' => 'O campo ::attribute é obrigatório',
            'nome.unique' => 'O nome da marca já existe'
        ];
    }
}
