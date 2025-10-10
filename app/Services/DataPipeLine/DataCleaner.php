<?php

namespace App\Services\DataPipeLine;

class DataCleaner
{
    public function buildRecord($data, ?int $category, string $content): array
    {
        return [
            'processed_record' => $data['id'],
            'title'            => $data['title'],
            'category_id'      => $category,
            'image'            => $data['image_url'],
            'original_url'     => $data['url'],
            'content'          => $content,
            'published_at'     => $data['publishedAt'],
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }
}
