@extends('userend.layouts.index-template')

@section('page-title')
    Brand-Product Checkout
@endsection

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/cart-items.css'])
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <section class="banner-container">
        @if($checkoutProduct)
        <div class="checkout-container">
            <div class="item-container">
                    <div class="cart-item-banner">
                        <div class="cart-item-img"><img src="{{ asset('storage/'. $checkoutProduct->image_path) }}" alt=""></div>
                        <div class="cart-item-info">
                            <a href="{{ route('product-display', $checkoutProduct->id) }}"><div class="">{{ $checkoutProduct->product_title }}</div></a>
                            <div class="">Quantity: {{ $quantity }}</div>
                            <div class="">Price: {{ $checkoutProduct->product_price }}</div>
                            <div class="">Amount: Rs. {{ $totalAmount = $quantity * $checkoutProduct->product_price}}</div>
                        </div>
                        <div class="cart-item-util">

                        </div>
                    </div>
            </div>
            <form method="POST" action="{{ route('product-order-placement') }}">
                @csrf
                <input type="hidden" name="buyer_id" value="{{ auth()->id() }}">
                <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                <input type="hidden" name="status" value="pending">
                <input type="hidden" name="product_id" value="{{ $checkoutProduct->id }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                <input type="hidden" name="price" value="{{ $checkoutProduct->product_price }}">
            <div class="utility-container">
                <div class="total-amount-container">
                    Total Amount: <span>Rs. {{ $totalAmount }}</span>
                </div>
                <div class="checkout-button">
                        <button type="submit">Place Order</button>
                </div>
                <span class="error-message">
                    @if(session('message'))
                        {{ session('message') }}
                    @endif

                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            {{ $error }} <br>
                        @endforeach
                    @endif
                    </span>
            </div>
            </form>
        </div>
        @endif
    </section>
@endsection
