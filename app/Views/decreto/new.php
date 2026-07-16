<?php

use App\Controllers\DecretoController;
use App\Entities\DecretoEntity;


?>
<?= $this->extend('default') ?>
<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Cadastro de decreto</h1>
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
                            <div class="card-title">
                                <?= anchor(url_to(DecretoController::class . '::index'), 'Listar', [
                                    'class' => 'btn btn-secondary'
                                ]) ?>
                            </div>
                        </div>
                        <?= form_open_multipart(url_to(DecretoController::class . '::create')) ?>
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
                                    ], old('titulo', '')) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= form_label('Data', 'date', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_input([
                                        'name'  => 'date',
                                        'id'    => 'date',
                                        'class' => 'form-control',
                                    ], old('date', ''), '', 'date') ?>
                                </div>
                                <div class="col-md-3">
                                    <?= form_label('Documento', 'document', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_upload([
                                        'name'  => 'document',
                                        'id'    => 'document',
                                        'class' => 'form-control',
                                    ], old('document', '')) ?>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Inserir</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>