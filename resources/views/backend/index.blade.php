@extends('backend.layouts.dashboard-template')


@section('vite-resource')
@vite(['resources/css/admin-dashboard.css', 'resources/css/side-nav.css'])
@endsection

@section('page-title')
    Dashboard
@endsection

@section('bread-crumb')
    Dashboard
@endsection

@section('content')
<div class="statistics">
    <div class="stats-box">asdasd</div>
    <div class="stats-box">asdasd</div>
    <div class="stats-box">asdasd</div>
    <div class="stats-box">asdasd</div>
</div>
@endsection