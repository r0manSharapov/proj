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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function autorizacoesUsers()
    {
        return $this->belongsToMany(User::class, 'autorizacoes_contas')->withPivot('so_leitura');
    }

    public function movimentos() {
        return $this->hasMany(Movimento::class);
    }


}
