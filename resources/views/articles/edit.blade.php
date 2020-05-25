@extends('layouts.article')
@section('title', "Update Article — {$article->title}")

@section('content')
<edit-article-form :article="{{ $article }}" action="{{ route('articles.update', [$website->id, $article->id]) }}"></edit-article-form>
@endsection