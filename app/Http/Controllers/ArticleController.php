<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\Articles\CreateRequest;
use App\Http\Requests\Articles\UpdateRequest;
use App\Site;
use App\Traits\ResourceViews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use ResourceViews;

    /**
     * Display a list of all articles for the specified
     * website.
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function index(Site $website)
    {
        $articles = $website->articles()
                                ->with([
                                    'user' => function ($query) {
                                        $query->select('id', 'name');
                                    }
                                ])
                                ->orderBy('title', 'asc')
                                ->paginate(20);
        
        $type = Str::ucfirst(request()->filled('type') ? Str::plural(request('type')) : 'Articles');

        return $this->view('index', 
            compact('website', 'articles', 'type')
        );
    }

    /**
     * Show the form to create an article.
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function create(Site $website)
    {
        return $this->view('create', compact('website'));
    }

    /**
     * Commit a new article to storage.
     * 
     * @param  \App\Http\Requests\Articles\CreateRequest  $request
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, Site $website)
    {
        $article = $website->articles()->create(array_merge(
            $request->only(['title', 'slug', 'content']),
            [
                'user_id' => auth()->id(),
                'type' => $request->type ?? 'page',
                'status' => $request->status ?? 'drafted',
                'parent_id' => $request->parent_id,
            ]
        ));

        $website->updateHomeIfNotExists($article->id);

        return response()->json([
            'redirect_url' => route('articles.show', [$website->id, $article->id])
        ], 201);
    }

    /**
     * Show the view to edit an article.
     * 
     * @param  \App\Site  $website
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Site $website, Article $article)
    {
        $article->load('parent');
        
        return $this->view('edit', compact('website', 'article'));
    }

    /**
     * Update the article in storage.
     * 
     * @param  \App\Http\Requests\Articles\UpdateRequest  $request
     * @param  \App\Site  $website
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Site $website, Article $article)
    {
        $article->update(array_merge(
            $request->only(['title', 'slug', 'content']),
            [
                'status' => $request->status ?? 'drafted',
                'type' => $request->type ?? 'page',
                'parent_id' => $request->parent_id,
            ]
        ));

        return response()->json([], 200);
    }

    /**
     * Search for articles.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Site $website)
    {
        $this->validate($request, [
            'term' => ['required', 'string', 'max:255'],
        ]);

        $articles = $website->articles()
                                ->search($request)
                                ->limit(10)
                                ->get();
        
        return response()->json([
            'articles' => $articles,
        ], 200);
    }

    public function destroy($article)
    {
        $article = Article::findOrFail($article);
        
        $article->update([
            'status' => 'deleted',
        ]);

        return response()->json([
            'article' => $article
        ], 200);
    }
}
