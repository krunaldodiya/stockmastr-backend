<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use Log;
use App\Repositories\NewsRepository;
use App\News;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from newsapi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(NewsRepository $newsRepo, News $newsModel)
    {
        $yesterday = Carbon::now()->subHours(24);

        $lastNews = $newsModel->orderBy('published_at', 'desc')->first();

        $from = $lastNews ? Carbon::parse($lastNews->published_at)->addSeconds(1) : $yesterday;

        $news = $newsRepo->fetchNews($from);

        $newsModel->insert($news);
    }
}
