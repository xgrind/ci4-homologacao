<?php

use App\Controllers\DecretoController;
use App\Controllers\PostController;

?>
<?= $this->extend('default') ?>
<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Data Tables</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?= anchor(url_to(DecretoController::class . '::new'), 'Cadastrar', [
                            'class' => 'btn btn-button btn-primary'
                        ]) ?>
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 16rem">
                            <span class="input-group-text">
                                <i class="bi bi-search" aria-hidden="true"></i>
                            </span>
                            <input
                                id="table-filter"
                                type="search"
                                class="form-control"
                                placeholder="Filter rows&hellip;"
                                aria-label="Filter rows" />
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="decretos-table"></div>
                </div>
                <div class="card-footer text-secondary small">
                    Powered by
                    <a href="https://tabulator.info/" target="_blank" rel="noopener">Tabulator</a>
                    &mdash; vanilla JS, no jQuery required.
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>

<?= $this->section('tabulator') ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const table = new window.Tabulator('#decretos-table', {
            data: '<?= url_to(DecretoController::class . '::index') ?>',
            layout: 'fitColumns',
            pagination: true,
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            movableColumns: true,
            columns: [{
                    title: '#',
                    field: 'id',
                    width: 60,
                    headerSort: true
                },
                {
                    title: 'Titulo',
                    field: 'title',
                    // headerFilter: 'input'
                },
                {
                    title: 'Documento',
                    field: 'document',
                    // headerFilter: 'input'
                },
                {
                    title: 'Data',
                    field: 'date',
                    formatter: 'html',
                    // headerFilter: 'input'
                },

                {
                    title: 'Ações',
                    field: 'actions',
                    formatter: 'html'
                }

            ],
        });


    });
</script>

<?= $this->endSection() ?>