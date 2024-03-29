@extends('userend.layouts.index-template')

@section('vite-resource')
    @vite(['resources/css/nav-bar.css', 'resources/css/create-product.css',    'resources/css/user-side-bar.css'])
@endsection

@section('page-title')
    Brand - Create an Ad
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Include Select2 CSS and JS files -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <section>
        <div class="form-container">
            <span>Create an Ad</span>
            <form action="{{ route('product-ad-post') }}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="mb-3">
                  <label for="product_title" class="form-label">Product Title</label>
                  <input type="text" class="form-control" name="product_title" id="exampleFormControlInput1" placeholder="Enter Product Title">
                </div>
                <div class="mb-3">
                  <label for="product_description" class="form-label">Product Description</label>
                  <textarea class="form-control" name="product_description" id="exampleFormControlTextarea1" rows="3" placeholder="Enter Product Description"></textarea>
                </div>
                <div class="mb-3">
                  <label for="product_price" class="form-label">Product Price</label>
                  <input type="number" class="form-control" name="product_price" id="exampleFormControlInput1" placeholder="Enter Product Price">
                </div>
                <div class="mb-3">
                  <label for="formFile" class="form-label">Upload Product Image (Max: 2MB)</label>
                  <input class="form-control" type="file" id="formFile" name="product_image" accept="image/*">
                </div>
                <div class="mb-3">
                  <label for="parentCategory" class="form-label">Select Category</label>
                  <select class="form-select" aria-label="Default select example" name="parent_category" id="parentCategory" onchange="fetchSubCategory()">
                    <option value="" selected>Select Category</option>
                    @foreach ($parentCategory as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3" id="subCategoryDiv">
                  <label for="subCategory" class="form-label">Select Sub Category</label>
                  <select class="form-select" aria-label="Default select example" name="sub_category" id="subCategory">
                    <option value="" selected>Select Sub Category</option>
                  </select>
                </div>
                <div class="mb-3" id="subSubCategoryDiv">
                  <label for="sub_sub_category" class="form-label">Select Sub Sub Category</label>
                  <select class="form-select" aria-label="Default select example" name="sub_sub_category" id="subSubCategory" onchange="tagEnterDiv()">
                    <option value="" selected>Select Sub Sub Category</option>
                  </select>
                </div>

                <div class="mb-3" id="tagDiv">
                  <label for="tags">Enter Tags:</label>
                  <select name="product_tags[]" class="form-select form-select-lg mb-3" id="tags" multiple>

                  </select>
                </div>
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <input class="btn btn-primary" type="submit" value="Create Ad">
                  <span class="error-message">
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
    </section>
    @vite(['resources/js/product-ad.js'])
    <script>
      $(document).ready(function() {
          $('#tags').select2({
              tags: true,
              tokenSeparators: [',', ' '],
          });
      });
  </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
