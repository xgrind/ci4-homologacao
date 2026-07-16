<?php

use App\Controllers\DecretoController;
use App\Entities\DecretoEntity;

/** @var DecretoEntity $decreto */
?>
<?= $this->extend('default') ?>
<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Editar Post</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Posts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
                            <div class="card-title">Editar Post</div>
                        </div>
                        <?= form_open(url_to(DecretoController::class . '::update', $decreto->id)) ?>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <?= form_label('Título', 'titulo', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_input([
                                        'name'  => 'title',
                                        'id'    => 'title',
                                        'class' => 'form-control',
                                    ], old('titulo', esc($decreto->title))) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= form_label('Data', 'date', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_input([
                                        'name'  => 'title',
                                        'id'    => 'title',
                                        'class' => 'form-control',
                                    ], old('date', esc($decreto->date))) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= form_label('Documento', 'documento', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_upload([
                                        'name'  => 'documento',
                                        'id'    => 'documento',
                                        'class' => 'form-control',
                                    ], old('documento', '')) ?>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>