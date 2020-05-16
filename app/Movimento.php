<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $fillable = [
        'conta_id','valor','descricao','saldo_inicial','saldo_final','categoria','tipo','imagem_doc'
    ];

    protected $casts = [
        'data'=>'datetime',
        'deleted_at'=>'datetime'
    ];

}
