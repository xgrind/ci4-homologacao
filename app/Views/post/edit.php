<?php

use App\Controllers\PostController;
use App\Entities\PostEntity;

/** @var PostEntity $post */
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
                        <?= form_open(url_to(PostController::class . '::update', $post->id), ['id' => 'post-form']) ?>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <?= form_label('Título', 'titulo', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_input([
                                        'name'  => 'titulo',
                                        'id'    => 'titulo',
                                        'class' => 'form-control',
                                    ], old('titulo', esc($post->titulo))) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= form_label('Foto', 'foto', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_upload([
                                        'name'  => 'foto',
                                        'id'    => 'foto',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <?= form_label('Resenha', 'resenha', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_textarea([
                                        'name'  => 'resenha',
                                        'id'    => 'resenha',
                                        'class' => 'form-control',
                                    ], old('resenha', $post->resenha)) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= form_label('Conteúdo', 'conteudo', [
                                        'class' => 'form-label',
                                    ]) ?>
                                    <?= form_textarea([
                                        'name'  => 'conteudo',
                                        'id'    => 'conteudo',
                                        'class' => 'form-control',
                                    ], old('conteudo', $post->conteudo)) ?>
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