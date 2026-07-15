<?php

namespace App\Database\Seeds;

use App\Models\PostModel;
use App\Models\Prod\NoticiaModel;
use CodeIgniter\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        // $noticias       = model(NoticiaModel::class)->findAll();
        $arqdb    = db_connect('arqaparecida');
        $noticias = $arqdb->table('arq_noticia')->get()->getResult();
        $model    = model(PostModel::class);

        $model->builder()->truncate();

        $model->protect(false);

        // $model->setAllowedFields(['created_at', 'updated_at']);

        foreach ($noticias as $noticia) {
            $model->insert([
                'titulo'     => $noticia->not_titulo,
                'foto'       => $noticia->not_img,
                'conteudo'   => $noticia->not_texto,
                'resenha'    => $noticia->not_resumo,
                'slug'       => url_title($noticia->not_titulo, '-', true),
                'created_at' => $noticia->not_postado,
                'updated_at' => $noticia->not_atualizado,
            ]);
        }
    }
}
