<?php

namespace App\Services\DataPipeLine;

use App\Services\DataProcess\CrawlerProcess;

class ContentCrawler
{
    private CrawlerProcess $crawler;

    public function __construct(CrawlerProcess $crawler)
    {
        $this->crawler = $crawler;
    }

    public function fetch(string $url): ?string
    {
        $html = $this->crawler->getNewsContent($url);
        return $this->crawler->extractNewsContent($html);
    }
}
