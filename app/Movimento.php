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
        'conta_id','valor','data','descricao','saldo_inicial','saldo_final','categoria_id','tipo','imagem_doc'
    ];

    protected $cats=[
        'deleted_at'=>'date',

    ];

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }


}
