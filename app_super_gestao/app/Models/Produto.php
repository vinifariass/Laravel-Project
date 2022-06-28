<?php

namespace App;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
  protected $fillable = ['nome', 'descricao','peso','unidade_id'];
}
