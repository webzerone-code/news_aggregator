<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/openApi', function () {
    //https://newsapi.org/v2/everything?q=bitcoin&apiKey=dd577b6b82764825a0eb0cfe16a5def1
    $apikey = 'dd577b6b82764825a0eb0cfe16a5def1';//env('NEWS_API_KEY');
    $url =  'https://newsapi.org/v2/everything';
    $response = Http::get($url,
//    [
//        //'q' => 'news',
//        'sources' => 'bbc-news,new-york-times,cnn,usa-today,the-wall-street-journal,bloomberg,the-verge,reuters',
//        'from' => '2025-09-26T00:00:00',
//        'to' => '2025-09-26T01:00:00',
//        'sortBy' => 'publishedAt',
//        'language' => 'en',
//        'apiKey' => $apikey,
//    ]
    [
    "apiKey" => "dd577b6b82764825a0eb0cfe16a5def1",
  "sources" => "bbc-news,new-york-times,cnn,usa-today,the-wall-street-journal,bloomberg,the-verge,reuters",
  "sortBy" => "publishedAt",
  "language" => "en",
  "from" => "2025-09-27T04:21:09",
  "to" => "2025-09-28T16:21:09",
  "page" => 1
]);

    if ($response->successful()) {
        //$articles = $response->json()['articles'];
        // You can store them in your DB or process them
        return $response->json();
    } else {
        return $response;//response()->json(['error' => 'Failed to fetch news'], 500);
    }
});
Route::get('/guarder', function () {
    //https://content.guardianapis.com/search?api-key=test
    //https://content.guardianapis.com/search?q=%22mitochondrial%20donation%22&tag=politics/politics&from-date=2014-01-01&api-key=test
    $apikey = '58a54cb3-d2bd-401a-b598-026434dd4aa8';//env('NEWS_API_KEY');
    $url =  'https://content.guardianapis.com/search';
    $response = Http::get($url,[
        //'q' => 'news',
        //'sources' => 'bbc-news,new-york-times,cnn,usa-today,the-wall-street-journal,bloomberg,the-verge,reuters',
        'from-date' => '2025-09-26T00:00:00',
        'to-date' => '2025-09-28T01:00:00',
        'sortBy' => 'publishedAt',
        'lang' => 'en',
        'show-fields' => 'headline,body,bodyText,thumbnail',
        'page-size'=>100,
        'api-key' => $apikey,
    ]);

    if ($response->successful()) {
        //$articles = $response->json()['articles'];
        // You can store them in your DB or process them
        return $response->json();
    } else {
        return $response;//response()->json(['error' => 'Failed to fetch news'], 500);
    }
});
Route::get('/bbc', function () {
    //https://bbc-news-api.vercel.app/news?lang=english
    $url = 'http://feeds.bbci.co.uk/news/rss.xml';
    $response = Http::get($url);
    $xml = simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);
    $news = [];
    foreach ($xml->channel->item as $item) {
        $news[] = [
            'title'       => (string) $item->title,
            'link'        => (string) $item->link,
            'description' => (string) $item->description,
            'category'    => (string) $item->category, // <-- category
            'image'       => isset($item->children('media', true)->thumbnail)
                ? (string) $item->children('media', true)->thumbnail->attributes()->url
                : null,
            'pubDate'     => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
        ];
    }

    return response()->json($news);
});

Route::get('/horizon', function () {
    return redirect('horizon/dashboard');
});
