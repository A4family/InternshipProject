@extends('userend.layouts.index-template')

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/home-index.css', 'resources/css/user-side-bar.css'])
@endsection

@section('page-title')
    Brand-Products-{{ $categoryName }}
@endsection

@section('content')
    {{ $categoryName }}
@endsection