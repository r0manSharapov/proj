<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $fillable = [
        'user_id','nome','descricao','saldo_abertura','saldo_atual',
    ];

    protected $casts = [
        'data_ultimo_movimento'=>'datetime',
        'deleted_at'=>'datetime'
    ];
}
