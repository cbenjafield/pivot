<?php

namespace App\Pivot;

use App\Article as AppArticle;

class Article
{
    /**
     * The current website.
     * 
     * @var App\Site $website
     */
    protected $website;

    public function __construct($website)
    {
        $this->website = $website;
    }

    /**
     * Return the website from the request.
     * 
     * @return App\Site
     */
    public function website()
    {
        return $this->website;
    }

    /**
     * Build the article's HTML using Laravel's components.
     * 
     * @param  array  $content
     * @param 
     */
    public function render(AppArticle $article)
    {
        return view('tenants.article', compact('article'))->render();
    }

    /**
     * Render an internal block.
     * 
     * @param  array  $attributes
     * @return string
     */
    public function block(array $attributes = [])
    {
        return (new Block($this->website, $attributes))
                                ->render();
    }

}