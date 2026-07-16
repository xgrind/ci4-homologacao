<?php

use App\Entities\DecretoEntity;

/** @var DecretoEntity $decreto
 * @var string $pdf
 */
?>
<?= $this->extend('default') ?>
<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Form Elements</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Forms</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Elements</li>
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
                    <div class="callout callout-info">
                        For detailed documentation visit
                        <a
                            href="https://getbootstrap.com/docs/5.3/forms/overview/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="callout-link">Bootstrap Forms</a>.
                    </div>
                </div>

                <!-- Quick Example -->
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Quick Example</div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <p><?= $decreto->title ?></p>
                                <p><?= $decreto->date ?></p>
                                <p><?= $decreto->document ?></p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>