<?php

namespace AutoPublish\Admin;

use AutoPublish\Domain\HtmlImporter;
use AutoPublish\Infrastructure\Logging\Logger;

class UploadPageController
{
    private HtmlImporter $importer;

    public function __construct(HtmlImporter $importer)
    {
        $this->importer = $importer;
    }

    public function render(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpload();
        }

        include AUTOPUBLISH_PATH . 'views/upload-page.php';
    }

    private function handleUpload(): void
    {
        try {
           Logger::info('Upload carpeta iniciado');

            if (!isset($_FILES['files'])) {
                throw new \Exception('No files uploaded');
            }

            $files = $_FILES['files'];

            $uploadedFiles = [];

            foreach ($files['name'] as $index => $name) {
                $tmpPath = $files['tmp_name'][$index];

                if (!$tmpPath) continue;

                $uploadedFiles[] = [
                    'name' => $name,
                    'tmp_path' => $tmpPath
                ];
            }

            // Buscar el HTML
            $htmlFile = null;

            foreach ($uploadedFiles as $file) {
                if (str_ends_with($file['name'], '.html')) {
                    $htmlFile = $file;
                    break;
                }
            }

            if (!$htmlFile) {
                throw new \Exception('No HTML file found in upload');
            }

            $html = file_get_contents($htmlFile['tmp_path']);

            $postId = $this->importer->createDraftFromHtml($html);
            Logger::info('Post creado', ['postId' => $postId]);

            echo '<div class="notice notice-success"><p>Post creado (ID: ' . $postId . ')</p></div>';
        } catch (\Exception $e) {
            Logger::error('Error upload carpeta', [
                'error' => $e->getMessage()
            ]);

            echo '<div class="notice notice-error"><p>Error: ' . $e->getMessage() . '</p></div>';
        }
    }
}
