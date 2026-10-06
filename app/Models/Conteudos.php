<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conteudos extends Model
{
    //
    protected $fillable = [
        'link',
        'nome',
        'sequencia',
        'descricao',
        'formato',
        'trilhas_id',
    ];

    public function trilha() {
        return $this->belongsTo(Trilhas::class, 'trilhas_id');
    }

}
