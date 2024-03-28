@extends('userend.layouts.index-template')

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/product-listing.css', 'resources/css/user-side-bar.css'])
@endsection

@section('page-title')
    Brand-Products-{{ $categoryName }}
@endsection

@section('side-bar')
    @include('userend.commonComponents.user-sidebar')
@endsection

    @section('content')
    <div class="product-container">
        <div class="category-title">Category: <span>{{ $categoryName }}</span></div>
        <div class="product-list-container">
            @foreach($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/'.$product->image_path) }}" class="product-card-image" alt="...">
                    <div class="product-card-body">
                        <h5 class="card-title">{{ $product->product_title }}</h5>
                        <p class="card-text">Price: {{ $product->product_price }}</p>
                        <p class="card-text">Seller: {{ $product->user->name }}</p>
                        <a href="{{ route('product-display', ['productId' => $product->id]) }}" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
