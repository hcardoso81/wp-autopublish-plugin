<?php

namespace AutoPublish\Admin;

use AutoPublish\Domain\HtmlImporter;
use AutoPublish\Domain\GoogleDocFetcher;
use AutoPublish\Infrastructure\Logging\Logger;

class UploadPageController
{
    private HtmlImporter $importer;
    private GoogleDocFetcher $fetcher;

    public function __construct(HtmlImporter $importer, GoogleDocFetcher $fetcher)
    {
        $this->importer = $importer;
        $this->fetcher = $fetcher;
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
        Logger::info('Import desde URL iniciado');

        if (empty($_POST['doc_url'])) {
            throw new \Exception('URL requerida');
        }

        $url = $_POST['doc_url'];

        // ✅ ahora sí corresponde
        $html = $this->fetcher->fetchHtml($url);

        $postId = $this->importer->createDraftFromHtml($html);

        echo '<div class="notice notice-success">
            <p>Post creado (ID: ' . $postId . ')</p>
        </div>';

    } catch (\Exception $e) {
        Logger::error('Error importando doc', [
            'error' => $e->getMessage()
        ]);

        echo '<div class="notice notice-error">
            <p>Error: ' . $e->getMessage() . '</p>
        </div>';
    }
}
}
