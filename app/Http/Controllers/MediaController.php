<?php

namespace App\Http\Controllers;

use App\Site;
use App\Traits\ResourceViews;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use ResourceViews;

    protected function getResourceName()
    {
        return 'media';
    }

    public function index(Site $website)
    {
        return $this->view('index', compact('website'));
    }

    public function store(Site $website)
    {
        $this->validate(request(), [
            'file' => ['required', 'file'],
        ]);

        $media = $website->upload(request()->file('file'));

        return response()->json([
            'file' => $media
        ], 201);
    }

    public function all(Site $website)
    {
        $media = $website->media()
                            ->latest()
                            ->paginate(50);
        
        return response()->json($media, 200);
    }
}
