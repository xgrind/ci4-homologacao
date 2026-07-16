<?php

namespace App\Database\Seeds;

use App\Models\DecretoModel;
use CodeIgniter\Database\Seeder;

class DecretoSeeder extends Seeder
{
    public function run()
    {
        $model = model(DecretoModel::class);

        $decretos = $model->getDecretosProd();

        $data = array_map(static fn($decreto) => [
            'title'    => $decreto->dec_titulo,
            'date'     => $decreto->dec_data,
            'document' => $decreto->dec_texto,
        ], $decretos);

        $model->insertBatch($data);
    }
}
