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

    //revisar
    public function getLinkAttribute($value) {

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/',
            $value,
            $matches
        );

        if (isset($matches[1]))
            return 'https://www.youtube.com/embed/' . $matches[1];



        return $value;
    }

    public function trilha() {
        return $this->belongsTo(Trilhas::class, 'trilhas_id');
    }

}
