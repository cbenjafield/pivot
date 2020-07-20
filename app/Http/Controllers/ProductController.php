<?php

namespace App\Http\Controllers;

use App\Product;
use App\Site;
use App\Traits\ResourceViews;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResourceViews;

    public function index(Site $website)
    {
        $products = $website->products()->get();

        if(request()->wantsJson()) {
            return response()->json([
                'products' => $products,
            ], 200);
        }

        return $this->view('index', compact('website', 'products'));
    }

    public function create(Site $website)
    {
        return $this->view('create', compact('website'));
    }

    public function store(Site $website)
    {
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'duration' => ['sometimes', 'nullable', 'numeric']
        ]);

        $product = $website->products()->create(
            request()->only('name', 'price', 'duration', 'description', 'limit', 'description')
        );

        return redirect("websites/{$website->id}/products")
                            ->with('success', 'Product created.');
    }

    public function show(Site $website, Product $product)
    {
        return $this->view('show', compact('website', 'product'));
    }

    public function update(Site $website, Product $product)
    {
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'duration' => ['sometimes', 'nullable', 'numeric']
        ]);

        $product->update(
            request()->only('name', 'price', 'duration', 'description', 'limit', 'description')
        );

        return back()->with('success', 'Product updated.');
    }
}
