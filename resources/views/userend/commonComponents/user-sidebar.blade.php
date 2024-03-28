<div class="side-bar">
    <span class="sidebar-heading">Categories</span>
    <div class="category-container">
        @foreach($mainCategory as $category)
            <div class="parent-category-container">
                <a href="{{ route('product-listing', ['categoryId' => $category->id]) }}">
                    <div class="grandchild-anchor"><span>{{ $category->category_name }}</span></div>
                </a>
                @foreach($category->children as $child)
                    <div class="sub-category-container">
                        <a href="{{ route('product-listing', ['categoryId' => $child->id]) }}">
                            <div class="grandchild-anchor"><span>{{ $child->category_name }}</span></div>
                        </a>
                        @foreach($child->children as $grandchild)
                            <div class="grandchild-anchor">
                                <a href="{{ route('product-listing', ['categoryId' => $grandchild->id]) }}">
                                    <div class="sub-sub-category-container">
                                        <span>{{ $grandchild->category_name }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
