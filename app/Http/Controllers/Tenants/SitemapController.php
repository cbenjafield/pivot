<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    
    public function index()
    {

    }

    public function xml()
    {
        $articles = request('website')
                            ->articles()
                            ->page()
                            ->orderBy('url', 'asc')
                            ->get();

        $sitemap = Sitemap::create();

        foreach($articles as $article) {
            $sitemap->add(Url::create("/{$article->url}")
                                    ->setLastModificationDate($article->updated_at)
                                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                    ->setPriority(0.1));
        }

        return $sitemap->toResponse(request());
    }

}
