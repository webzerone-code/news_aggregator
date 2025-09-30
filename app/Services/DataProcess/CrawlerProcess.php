<?php

namespace App\Services\DataProcess;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerProcess
{
    public function getNewsContent(string $url):?string
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->body(); // full HTML content
            }
        } catch (\Throwable $e) {
            \Log::error("Error fetching URL {$url}: " . $e->getMessage());
        }

        return null;
    }
    public function extractNewsContent(string $html):?string
    {
        $crawler = new Crawler($html);

        // Example: select main article by <article> tag
        $content = $crawler->filter('article')->text();

        return $content;
    }
}
