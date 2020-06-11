@extends('layouts.article')
@section('title', "Update Article — {$article->title}")

@section('content')
<edit-article-form :article="{{ $article }}" action="{{ route('articles.update', [$website->id, $article->id]) }}"></edit-article-form>
@endsection

@section('global-components')
<image-chooser ref="imageChooser"></image-chooser>
<add-element ref="addElement"></add-element>
@endsection

@section('scripts')
<script>
window.articleId = {{ $article->id }};
window.siteId = {{ $article->site_id }};
</script>
@endsection
