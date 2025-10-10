<?php

namespace App\Services\DataPipeLine;


class DataPipeline
{
    private RawDataFetcher $fetcher;
    private CategoryParser $parser;
    private ContentCrawler $crawler;
    private DataCleaner $cleaner;
    private NewsPersister $persister;

    public function __construct(RawDataFetcher $fetcher, CategoryParser $parser, ContentCrawler $crawler, DataCleaner $cleaner, NewsPersister $persister)
    {
        $this->persister = $persister;
        $this->cleaner = $cleaner;
        $this->crawler = $crawler;
        $this->parser = $parser;
        $this->fetcher = $fetcher;
    }

    public function handle(): void
    {
        $processedIDs = [];
        $cleanedData = [];

        $this->fetcher->fetchUnprocessed(function ($rawData) use (&$processedIDs, &$cleanedData) {
            foreach ($rawData as $data) {
                $category = $this->parser->parse($data['title']);

                $requireCrawler = config("FetchingDataConfig.{$data->provider}.data-crawler");
                $content = $requireCrawler
                    ? $this->crawler->fetch($data['url'])
                    : $data['content'];

                if (!empty($content)) {
                    $cleanedData[] = $this->cleaner->buildRecord($data, $category, $content);
                }

                $processedIDs[] = $data['id'];
            }
        });

        $this->persister->persist($processedIDs, $cleanedData);
    }
}
