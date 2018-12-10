<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NewsRepository;
use App\News;

class NewsController extends Controller
{
    protected $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    public function latest(Request $request)
    {
        $limit = $request->limit;

        $news = News::orderBy('published_at', 'desc')->take($limit)->get();

        return compact('news');
    }


    public function all(Request $request)
    {
        $limit = $request->limit;

        $news = News::orderBy('published_at', 'desc')->paginate($limit);

        return compact('news');
    }
}
