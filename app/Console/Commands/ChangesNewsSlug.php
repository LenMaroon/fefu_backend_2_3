<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Redirect;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChangesNewsSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change_news_slug {old_slug} {new_slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $oldSlug = $this->argument('old_slug');
        $newSlug = $this->argument('new_slug');

        if ($oldSlug === $newSlug)
        {
            $this->error('The slugs are equal');
            return 1;
        }

        $redirect = Redirect::query()
            -> where('old_slug', route('news_item', ['slug' => $oldSlug], false))['path']
            -> where('new_slug', route('news_item', ['slug' => $newSlug], false))['path']
            ->first();
        if ($redirect !== null)
        {
            $this->error('The same request for redirect had already been made');
            return 1;
        }

        $news = News::where('slug', $oldSlug)->first();
        if ($news === null)
        {
            $this->error("'The news wasn't found'");
            return 1;
        }

        DB::transaction(function() use ($news, $newSlug) {
            Redirect::where('old_slug', route('news_item', ['slug' => $newSlug], false))['path']->delete();
            $news->slug = $newSlug;
            $news->save();
        });

        return 0;

    }
}
