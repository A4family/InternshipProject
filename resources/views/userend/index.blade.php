@extends('userend.layouts.index-template')

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/home-index.css', 'resources/css/user-side-bar.css'])
@endsection

@section('page-title')
    Brand - Home
@endsection

@section('side-bar')
    @include('userend.commonComponents.user-sidebar')
@endsection

@section('content')

@endsection
