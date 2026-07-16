<?php

namespace App\Commands;

use App\Models\DecretoModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ImportDecretos extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'decreto:import-images';
    protected $description = 'Downloads all images from decretos.document HTML, converts to PDF, and updates the database.';

    public function run(array $params)
    {
        $model = model(DecretoModel::class);

        $decretos = $model->where('document !=', '')->findAll();

        if (empty($decretos)) {
            CLI::write('Nenhum decreto para processar.', 'yellow');
            return;
        }

        CLI::write('Processando ' . count($decretos) . ' decretos...', 'green');

        $outputDir = FCPATH . 'uploads/docs';
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $success = 0;
        $errors  = 0;

        foreach ($decretos as $decreto) {
            CLI::write("  [{$decreto->id}] {$decreto->title}... ", 'white');

            $urls = $this->extractImageUrls($decreto->document);

            if (empty($urls)) {
                CLI::write('Nenhuma imagem encontrada.', 'yellow');
                continue;
            }

            $tempDir = sys_get_temp_dir() . '/decreto_' . $decreto->id;
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $images      = [];
            $downloadOk  = true;

            foreach ($urls as $i => $url) {
                if (!preg_match('#^https?://#i', $url)) {
                    $url = 'https://' . $url;
                }

                $ext  = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
                $ext  = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? $ext : 'jpg';
                $dest = $tempDir . "/img_{$i}.{$ext}";

                CLI::write("    Downloading: {$url}", 'blue');

                $ctx = stream_context_create([
                    'http' => [
                        'timeout'       => 30,
                        'user_agent'    => 'Mozilla/5.0 (compatible; CI4)',
                        'follow_location' => true,
                    ],
                    'ssl' => [
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    ],
                ]);

                $imgData = @file_get_contents($url, false, $ctx);

                if ($imgData === false) {
                    CLI::write('    Falha no download.', 'red');
                    $downloadOk = false;
                    break;
                }

                file_put_contents($dest, $imgData);
                $images[] = $dest;
            }

            if (!$downloadOk) {
                CLI::write('  SKIP - download falhou.', 'red');
                $this->cleanup($tempDir);
                $errors++;
                continue;
            }

            $slug    = $this->slugify($decreto->title);
            $pdfFile = $outputDir . "/{$slug}.pdf";

            CLI::write("    Convertendo para PDF: {$slug}.pdf", 'blue');

            $cmd = 'convert ' . implode(' ', array_map('escapeshellarg', $images))
                 . ' ' . escapeshellarg($pdfFile) . ' 2>&1';
            exec($cmd, $output, $exitCode);

            $this->cleanup($tempDir);

            if ($exitCode !== 0) {
                CLI::write('    Erro na conversão: ' . implode("\n", $output), 'red');
                $errors++;
                continue;
            }

            $pdfFilename = $slug . '.pdf';
            $model->protect(false)->update($decreto->id, ['document' => $pdfFilename]);

            CLI::write('  OK', 'green');
            $success++;
        }

        CLI::write("Concluído! {$success} sucesso, {$errors} erros.", 'green');
    }

    private function extractImageUrls(string $html): array
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
        return array_values(array_filter(array_map('trim', $matches[1])));
    }

    private function slugify(string $title): string
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return substr($slug, 0, 100) ?: 'decreto';
    }

    private function cleanup(string $dir): void
    {
        if (is_dir($dir)) {
            array_map('unlink', glob($dir . '/*'));
            rmdir($dir);
        }
    }
}
