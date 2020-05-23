<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nome','tipo'
    ];

    public function movimentos()
    {
        return $this->hasMany(Movimento::class);
    }
}
