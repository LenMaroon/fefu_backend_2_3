<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function getList()
    {
        $news = News::query()
            ->where('is_published', true)
            ->where('published_at', '<=', 'NOW()')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(5);

        return view('news_list', ['news_list' => $news]);
    }

    public function getDetails(string $slug)
    {
        $news_item = News::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', 'NOW()')
            ->first();

        abort_if($news_item === null, 404);

        return view('news_item', ['news_item' => $news_item]);

    }
}
