<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\SitemapTag;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    
    public function index()
    {

    }

    public function xml()
    {
        $lastPage = request('website')
                            ->articles()
                            ->page()
                            ->published()
                            ->orderBy('updated_at', 'desc')
                            ->first();
        
        $lastPost = request('website')
                            ->articles()
                            ->post()
                            ->published()
                            ->orderBy('updated_at', 'desc')
                            ->first();

        $sitemapIndex = SitemapIndex::create()
                                ->add(
                                    SitemapTag::create('/xml-sitemap/pages')
                                                ->setLastModificationDate($lastPage->updated_at ?? Carbon::now())
                                )
                                ->add(
                                    SitemapTag::create('/xml-sitemap/posts')
                                                ->setLastModificationDate($lastPost->updated_at ?? Carbon::now())
                                );
        
        return $sitemapIndex->toResponse(request());
    }

    public function xmlPages()
    {
        $articles = request('website')
                            ->articles()
                            ->page()
                            ->published()
                            ->orderBy('url', 'asc')
                            ->get();

        $sitemap = $this->makeXmlSitemap($articles);

        return $sitemap->toResponse(request());
    }

    public function xmlPosts()
    {
        $articles = request('website')
                                ->articles()
                                ->post()
                                ->published()
                                ->orderBy('url', 'asc')
                                ->get();
        
        $sitemap = $this->makeXmlSitemap($articles);

        return $sitemap->toResponse(request());
    }

    protected function makeXmlSitemap($articles)
    {
        $sitemap = Sitemap::create();

        foreach($articles as $article) {
            $sitemap->add(Url::create("/{$article->url}")
                                    ->setLastModificationDate($article->updated_at)
                                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                    ->setPriority(0.1));
        }

        return $sitemap;
    }

}
