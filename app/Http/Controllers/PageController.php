<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Page;
use App\User;

class PageController extends Controller
{
    protected $limit = 1;

    public function index()
    {
        $pages = Page::with('author', 'comments')
                    ->latestFirst()
                    ->published()
                    ->filter(request()->only(['term', 'year', 'month']))
                    ->simplePaginate($this->limit);

        return view("page.index", compact('pages'));
    }

    public function author(User $author)
    {
        $authorName = $author->name;

        $pages = $author->pages()
                          ->with('comments')
                          ->latestFirst()
                          ->published()
                          ->simplePaginate($this->limit);

         return view("page.index", compact('pages', 'authorName'));
    }

    public function show(Page $page)
    {
        $page->increment('view_count');

        $pageComments = $page->comments()->simplePaginate(3);

        return view("page.show", compact('page', 'pageComments'));
    }
}
