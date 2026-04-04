<?php

namespace AutoPublish\Domain;

use AutoPublish\Infrastructure\Logging\Logger;

class HtmlImporter
{
    public function createDraftFromHtml(string $html): int
    {
        try {
            Logger::info('Creando draft', [
                'length' => strlen($html)
            ]);

            $postId = wp_insert_post([
                'post_title'   => 'Borrador importado',
                'post_content' => $html,
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
}