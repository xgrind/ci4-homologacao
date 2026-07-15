<?php

namespace App\Publishers;

use CodeIgniter\Publisher\Publisher;

class TemplatePublisher extends Publisher
{
    protected $source      = VENDORPATH . 'almasaeed2010/adminlte/dist';
    protected $destination = FCPATH;

    public function publish(): bool
    {
        return $this->addPaths([
            'css',
            'js',
            'assets',
        ])->merge(true);
    }
}
