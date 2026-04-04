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
            Logger::info('Upload iniciado');

            if (!isset($_FILES['html_file'])) {
                throw new \Exception('No file uploaded');
            }

            $html = file_get_contents($_FILES['html_file']['tmp_name']);

            $postId = $this->importer->createDraftFromHtml($html);

            Logger::info('Post creado', ['postId' => $postId]);

            echo '<div class="notice notice-success"><p>Post creado (ID: ' . $postId . ')</p></div>';

        } catch (\Exception $e) {
            Logger::error('Error en upload', [
                'message' => $e->getMessage()
            ]);

            echo '<div class="notice notice-error"><p>Error: ' . $e->getMessage() . '</p></div>';
        }
    }
}