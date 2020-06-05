@extends('layouts.site')
@section('title', 'Media')

@section('content')
<media-library website="{{ $website->id }}"></media-library>
@endsection