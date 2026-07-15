<?php

namespace App\Entities;

use App\Controllers\PostController;
use CodeIgniter\Entity\Entity;
use Override;

/**
 * @property string $conteudo
 * @property string $foto
 * @property string $resenha
 * @property string $slug
 * @property string $titulo
 */
class PostEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    private function url(string $method): string
    {
        return url_to(PostController::class . "::{$method}", $this->attributes['id']);
    }

    public function actions()
    {
        $urlEdit        = anchor($this->url('edit'), 'Editar', [
            'class' => 'btn btn-primary'
        ]);
        $urlRemove      = anchor($this->url('remove'), 'Excluir', [
            'class' => 'btn btn-danger'
        ]);

        $urlShow        = anchor($this->url('show'), 'Mostrar', [
            'class' => 'btn btn-secondary'
        ]);



        return "<p>{$urlEdit} {$urlRemove} {$urlShow}</p>";


        // return "<p>{$urlEdit}</p><p>{$urlRemove}</p>";
    }

    public function getContent(): string
    {
        helper('text');

        return word_limiter($this->attributes['conteudo'], 10);
    }

    #[Override]
    public function toArray(bool $onlyChanged = false, bool $cast = true, bool $recursive = false): array
    {
        if (!$this->attributes['foto']) {
            $this->attributes['foto'] = 'Não tem';
        }

        $this->attributes['conteudo'] = $this->getContent();
        $this->attributes['actions'] = $this->actions();

        return parent::toArray($onlyChanged, $cast, $recursive);
    }
}
