<?php

namespace AutoPublish\Domain;

use AutoPublish\Infrastructure\Logging\Logger;

class HtmlImporter
{
    public function createDraftFromHtml(string $html): int
    {
        try {
            Logger::info('Procesando HTML');

            $processedHtml = $this->processImages($html);

            $postId = wp_insert_post([
                'post_title'   => 'Borrador importado',
                'post_content' => $processedHtml,
                'post_status'  => 'draft',
            ]);

            if (is_wp_error($postId)) {
                throw new \Exception($postId->get_error_message());
            }

            return $postId;

        } catch (\Exception $e) {
            Logger::error('Error creando draft', [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    private function processImages(string $html): string
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (!$src) continue;

            $newUrl = $this->downloadAndUploadImage($src);

            if ($newUrl) {
                $img->setAttribute('src', $newUrl);
            }
        }

        return $dom->saveHTML();
    }

    private function downloadAndUploadImage(string $url): ?string
    {
        Logger::info('Descargando imagen', ['url' => $url]);

        $response = wp_remote_get($url);

        if (is_wp_error($response)) return null;

        $imageData = wp_remote_retrieve_body($response);
        if (!$imageData) return null;

        $fileName = basename(parse_url($url, PHP_URL_PATH)) ?: 'image.jpg';

        $upload = wp_upload_bits($fileName, null, $imageData);

        if (!empty($upload['error'])) return null;

        $fileType = wp_check_filetype($upload['file'], null);

        $attachment = [
            'post_mime_type' => $fileType['type'],
            'post_title'     => sanitize_file_name($fileName),
            'post_status'    => 'inherit'
        ];

        $attachId = wp_insert_attachment($attachment, $upload['file']);

        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachData = wp_generate_attachment_metadata($attachId, $upload['file']);
        wp_update_attachment_metadata($attachId, $attachData);

        return wp_get_attachment_url($attachId);
    }
}