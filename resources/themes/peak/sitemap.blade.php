@extends(Theme::layout('site'))
@section('title', 'Sitemap')

@section('content')
<div class="page-header py-32 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Sitemap</h1>
    </div>
</div>
<div class="py-10 page-content">
    <div class="container mx-auto">
        <div class="sm:grid sm:grid-cols-2 sm:gap-10">
            
            <div>
                <h2 class="text-2xl text-gray-900 font-semibold">Pages</h2>
                <div class="mt-6">
                    {!! $pages !!}
                </div>
            </div>

            <div>
                <h2 class="text-2xl text-gray-900 font-semibold">Posts</h2>
                <div class="mt-6">
                    {!! $posts !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection