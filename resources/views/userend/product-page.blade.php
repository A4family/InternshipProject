@extends('userend.layouts.index-template')

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/product-page.css'])
@endsection

@section('page-title')
    Brand-{{ $product->product_title }}
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="product-banner">
        <div class="image-container">
            <img src="{{ asset('storage/'.$product->image_path) }}" alt="not found" class="image"/>
        </div>
        <div class="details-container">
            <div>Title: <span>{{ $product->product_title }}</span></div>
            <div>Category: <span>{{ $product->category->category_name }}</span></div>
            <div>Description: <span class="description-span">{{ $product->product_description }}</span></div>
            <div>Seller: <span class="description-span">{{ $product->user->name }}</span></div>
            <div class="price-container">Price: <span>Rs. {{ $product->product_price }}</span> </div>
            <label for="number-of-items">Number of Items: </label>
            <input type="number" id="number-of-items" value="1" min="1" oninput="validity.valid||(value='');">
            @guest
                <div class="button-container">
                    <a href="{{ route('user.login') }}"><button type="submit">Purchase</button></a>
                </div>

                <div class="button-container">
                    <a href="{{ route('user.login') }}"><button type="submit">Add to Cart</button></a>
                </div>
            @else
            <div class="forms-container">
                <form method="get" action="{{ route('checkout-page') }}">
                    @csrf
                    <input type="hidden" name="buyer_id" value="{{ auth()->id() }}">
                    <input type="hidden" id="purchase-number-of-items" value="1" name="quantity">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="button-container">
                        @if(auth()->id()==$product->user_id)
                            <a href="#"><button onclick="cantBuySelfProduct(event)">Purchase</button></a>
                        @else
                            <a href="#"><button type="submit">Purchase</button></a>
                        @endif
                    </div>
                </form>

                <form method="post" action="{{ route('add-to-cart') }}">
                    @csrf
                    <input type="hidden" name="buyer_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="seller_id" value="{{ $product->user_id }}">
                    <input type="hidden" id="cart-number-of-items" value="1" name="quantity">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="price" value="{{ $product->product_price }}">
                    <div class="button-container">
                        @if(auth()->id()==$product->user_id)
                            <a href="#"><button onclick="cantBuySelfProduct(event)">Add to Cart</button></a>
                        @else
                            <a href="#"><button type="submit">Add to Cart</button></a>
                        @endif
                    </div>

                    <br><span class="error-message">
                        @if(session('message'))
                            {{ session('message') }}
                        @endif

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <br> {{ $error }}
                            @endforeach
                        @endif
                    </span>
                </form>
            </div>
            @endguest
        </div>
    </div>

    <div class="comments-container">
        <div class="comment-section-title">Comments</div>

        @foreach ($product->comments as $comment)
            @include('userend.commonComponents.comment', ['comment' => $comment])
        @endforeach

    </div>

    <div class="comment-form">
        <h2>Add Feedback/Queries</h2>
        <form id="commentForm" method="POST" action="{{ route('post-comment') }}" enctype="multipart/form-data">
            @csrf

            <label for="comment">Your Comment:</label>
            <textarea id="comment" name="comment" rows="4"></textarea>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="comment_image" accept="image/*"><br>

            <input type="hidden" value="{{ auth()->id() }}" name="user_id">
            <input type="hidden" value="{{ $product->id }}" name="product_id">
            <input type="hidden" name="parent_id" value={{ null }}>

            <button type="submit">Post Comment</button>

            <br><span class="error-message">
                @if(session('message'))
                    {{ session('message') }}
                @endif

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <br> {{ $error }}
                    @endforeach
                @endif
            </span>
        </form>
    </div>

    <script>
        function toggleComment(commentId){
            $("#reply-comment-" + commentId).toggle();
        }
        $(document).ready(function(){
            $(".reply-comment").hide();
        });

        $('#number-of-items').on('input', function() {
            $('#purchase-number-of-items').val($(this).val());
            $('#cart-number-of-items').val($(this).val());
        });

        function cantBuySelfProduct(event){
            event.preventDefault();
            alert("You can't purchase your own products!!");
        }
    </script>
@endsection
