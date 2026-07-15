<?php

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
                        <?= anchor(url_to('post.truncate'), 'Limpar tabela', [
                            'class' => 'btn btn-button btn-danger',
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
                    <div id="posts-table"></div>
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

        const table = new window.Tabulator('#posts-table', {
            data: '<?= url_to(PostController::class . '::index') ?>',
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
                    field: 'titulo',
                    // headerFilter: 'input'
                },
                {
                    title: 'Foto',
                    field: 'foto',
                    // headerFilter: 'input'
                },
                {
                    title: 'Conteúdo',
                    field: 'conteudo',
                    formatter: 'html',
                    // headerFilter: 'input'
                },
                {
                    title: 'Resenha',
                    field: 'resenha',
                    formatter: 'html',

                    // headerFilter: 'list',
                    // headerFilterParams: {
                    //     values: ['', 'Admin', 'Editor', 'Viewer']
                    // },
                    width: 120,
                },
                {
                    title: 'Slug',
                    field: 'slug',
                    // headerFilter: 'input'
                },
                {
                    title: 'Ações',
                    field: 'actions',
                    formatter: 'html'
                }

            ],
        });

        // document.getElementById('table-filter').addEventListener('input', (e) => {
        //     const value = e.target.value;
        //     if (value) {
        //         table.setFilter([
        //             [{
        //                     field: 'name',
        //                     type: 'like',
        //                     value: value
        //                 },
        //                 {
        //                     field: 'email',
        //                     type: 'like',
        //                     value: value
        //                 },
        //             ],
        //         ]);
        //     } else {
        //         table.clearFilter();
        //     }
        // });

        // document
        //     .getElementById('export-csv')
        //     .addEventListener('click', () => table.download('csv', 'users.csv'));
        // document
        //     .getElementById('export-json')
        //     .addEventListener('click', () => table.download('json', 'users.json'));
        // document
        //     .getElementById('print-table')
        //     .addEventListener('click', () => table.print(false, true));
    });
</script>

<?= $this->endSection() ?>