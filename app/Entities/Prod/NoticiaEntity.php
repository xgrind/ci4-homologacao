<?php

namespace App\Entities\Prod;

use CodeIgniter\Entity\Entity;

class NoticiaEntity extends Entity
{
    protected $datamap = [
        'id' => 'not_id',
        'categoria_id' => 'not_categoria',
        'titulo' => 'not_titulo',
        'created_at' => 'not_postado',
        'updated_at' => 'not_atualizado',
        'deleted_at' => 'not_excluido_em',
        'imagem' => 'not_img',
        'texto' => 'not_texto',
        'resumo' => 'not_resumo',
        'show' => 'not_show',
        'views' => 'not_views'
    ];
    protected $dates   = ['not_postado', 'not_atualizado', 'not_excluido'];
    protected $casts   = [];
}
