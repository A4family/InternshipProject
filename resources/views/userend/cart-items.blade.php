@extends('userend.layouts.index-template')

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/cart-items.css'])
@endsection

@section('page-title')
    Brand - Cart Items
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <section class="banner-container">
        <div class="checkout-container">
            <div class="item-container">
                @foreach($cartItems as $cartItem)
                    <div class="cart-item-banner">
                        <div class="cart-item-img"><img src="{{ asset('storage/'.$cartItem->product->image_path) }}" alt=""></div>
                        <div class="cart-item-info">
                            <a href=""><div class="">{{ $cartItem->product->product_title }}</div></a>
                            <div class="">Amount: {{ $cartItem->amount }}</div>
                            <div class="">Quantity: {{ $cartItem->quantity }}</div>
                        </div>
                        <div class="cart-item-util">
                            <form method="post" action="{{ route('change-cart-item-quantity') }}">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $cartItem->id }}" readonly>
                                <input type="hidden" name="price" value="{{ $cartItem->price }}">
                                <label for="item-quantity{{  $cartItem->id }}">Quantity:</label>
                                <input type="number" name="quantity" id="item-quantity{{  $cartItem->id }}" min="1" value="{{ $cartItem->quantity }}" oninput="validity.valid||(value='');">
                                <input type="submit" value="Update Quantity">
                            </form>
                            <form method="POST" action="{{ route('remove-from-cart') }}">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $cartItem->id }}">
                                <input type="submit" value="Remove">
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="utility-container">
                <div class="total-amount-container">
                    Total Amount: <span>Rs. {{ $totalAmount }}</span>
                </div>
                <div class="checkout-button">
                    <button>Proceed to Checkout</button>
                </div>
                <span class="error-message">
                        @if(session('message'))
                        {{ session('message') }}
                    @endif

                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            {{ $error}} <br>
                        @endforeach
                    @endif
                    </span>
            </div>
        </div>
    </section>
@endsection
