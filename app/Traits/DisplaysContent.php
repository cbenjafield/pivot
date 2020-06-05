<?php

namespace App\Traits;

use App\Pivot\Block;
use Article;
use Illuminate\Support\Collection;

trait DisplaysContent
{
    public function getJsonContent()
    {
        return json_decode($this->content, true);
    }
    
    public function getContent()
    {
        $jsonContent = $this->getJsonContent();
        $content = new Collection;
        $website = request('website');

        foreach($jsonContent as $block) {
            $content->add(new Block($website, $block));
        }

        return $content;
    }

    public function render()
    {
        return Article::render($this);
    }

}