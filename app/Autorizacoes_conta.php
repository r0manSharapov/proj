<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizacoes_conta extends Model
{
    //Override primary key -> chave primária composta
    protected $primaryKey=['user_id','conta_id'];


}
