<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trilhas extends Model
{
    protected $fillable = [
        'titulo',
        'description',
        'data_inicio',
        'data_fim',
        'ativo',
        'responsavel_id'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativo' => 'boolean'
    ];

    public function responsavel() {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function tabelaResponsavel() {
        return $this->belongsTo(UsuarioHasTrilhas::class, 'trilhas_id');
    }

}
