<?php

use App\Entities\DecretoEntity;

/** @var DecretoEntity $decreto
 * @var string $pdf
 */
?>
<?= $this->extend('default') ?>
<?= $this->section('content') ?>

<style>
details.decreto-ano {
    margin-bottom: 0.75rem;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
    background: #fff;
}

details.decreto-ano[open] {
    background: #f8f9fa;
}

details.decreto-ano summary {
    cursor: pointer;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0;
}

details.decreto-ano summary::marker {
    color: #0d6efd;
}

.ano-count {
    font-size: 0.75rem;
}

ul.decreto-lista {
    list-style: none;
    padding: 0.5rem 0 0 1.5rem;
    margin: 0;
}

ul.decreto-lista li {
    padding: 0.3rem 0;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

ul.decreto-lista li:last-child {
    border-bottom: none;
}

.decreto-data {
    color: #6c757d;
    font-size: 0.875rem;
}
</style>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Decretos e Provisões</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Decretos</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Decretos e Provisões</div>
                        </div>

                        <div class="card-body">
<?php
$grouped = [];
foreach ($decretos as $decreto) {
    $year = date('Y', strtotime($decreto->date));
    $grouped[$year][] = $decreto;
}
?>

<?php foreach ($grouped as $year => $anoDecretos): ?>
<details class="decreto-ano">
    <summary>
        <span class="ano-titulo"><?= $year ?></span>
        <span class="ano-count badge text-bg-secondary"><?= count($anoDecretos) ?></span>
    </summary>
    <ul class="decreto-lista">
    <?php foreach ($anoDecretos as $decreto): ?>
        <li>
            <a href="<?= site_url("decretos/show/{$decreto->id}") ?>">
                <?= esc($decreto->title) ?>
            </a>
            <span class="decreto-data"><?= $decreto->date ?></span>
            <?php if ($decreto->document): ?>
            <a href="<?= site_url("uploads/docs/{$decreto->document}") ?>"
               class="btn btn-sm btn-outline-secondary"
               target="_blank" title="Abrir PDF">
                <i class="bi bi-filetype-pdf"></i>
            </a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
</details>
<?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
