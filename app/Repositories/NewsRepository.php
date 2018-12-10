<?php

namespace App\Repositories;

use App\News;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Repositories\Contracts\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    public function fetchNews($from)
    {
        $client = new Client();

        $apiKey = env('NEWSAPI_KEY');
        $sources = "the-times-of-india";
        $language = "en";
        $pageSize = 100;

        $url = "https://newsapi.org/v2/everything?sources=$sources&language=$language&apiKey=$apiKey&pageSize=$pageSize&from=$from";
        $result = $client->get($url);
        $articles = json_decode($result->getBody(), true)['articles'];

        $data = collect($articles)
            ->filter(function ($article) {
                return !is_null($article['description']) && !is_null($article['content']);
            })
            ->map(function ($article) {
                return [
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'content' => $article['content'],
                    'source_url' => $article['url'],
                    'image_url' => $article['urlToImage'],
                    'published_at' => Carbon::createFromTimeString($article['publishedAt']),
                ];
            })
            ->toArray();

        return $data;
    }
}