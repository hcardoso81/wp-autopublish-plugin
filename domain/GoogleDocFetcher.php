<?php

namespace AutoPublish\Domain;

use AutoPublish\Infrastructure\Logging\Logger;

class GoogleDocFetcher
{
    public function fetchHtml(string $url): string
    {
        if (!preg_match('/\/document\/d\/([a-zA-Z0-9-_]+)/', $url, $matches)) {
            throw new \Exception('URL de Google Docs inválida');
        }

        $docId = $matches[1];

        $exportUrl = "https://docs.google.com/document/d/{$docId}/export?format=html";

        Logger::info('Fetching doc', ['url' => $exportUrl]);

        $response = wp_remote_get($exportUrl);

        if (is_wp_error($response)) {
            throw new \Exception('Error al obtener documento');
        }

        $html = wp_remote_retrieve_body($response);

        if (!$html) {
            throw new \Exception('Documento vacío');
        }

        return $html;
    }
}