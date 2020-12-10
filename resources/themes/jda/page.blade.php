@extends(Theme::layout('site'))

@section('content')

@include(Theme::partial('page-header'))

{!! $article->render() !!}

@endsection