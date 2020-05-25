<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autorizacoes_conta extends Model
{
    //Override primary key -> chave primária composta
    protected $primaryKey=['user_id','conta_id'];
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 'conta_id', 'so_leitura'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function conta(){
        return $this->belongsTo(User::class);
    }
}
