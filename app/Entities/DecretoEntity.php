<?php

namespace App\Entities;

use App\Controllers\DecretoController;
use CodeIgniter\Entity\Entity;
use Override;

/**
 * @property string $docmument
 * @property string $date
 * @property string $title
 */
class DecretoEntity extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];

    public function getFile()
    {
        $document       = $this->attributes['document'];
        return site_url("uploads/docs/{$document}");
    }

    private function getUrl(string $type)
    {
        $id             = $this->attributes['id'];
        // return url_to(DecretoController::class . '::' . $type);

        return site_url("decretos/{$type}/{$id}");
    }

    #[Override]
    public function toArray(bool $onlyChanged = false, bool $cast = true, bool $recursive = false): array
    {
        $urlEdit        = $this->getUrl('date');
        $urlRemove      = $this->getUrl('remove');
        $urlShow        = $this->getUrl('show');

        $actions        = anchor($urlEdit, 'Editar') . ', ' . anchor($urlRemove, 'Excluir' . ', ' . anchor($urlShow, 'Detalhes'));
        $this->attributes['actions'] = $actions;

        return parent::toArray($onlyChanged, $cast, $recursive);
    }
}
