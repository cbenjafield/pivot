@extends('layouts.site')
@section('title', "Add Menu — {$website->tld}")
@section('main-class', 'flex-1 relative z-0 overflow-y-auto pb-6 focus:outline-none')
@section('content-class', 'px-0')

@section('content')
<menu-builder site-id="{{ $website->id }}"></menu-builder>
@endsection