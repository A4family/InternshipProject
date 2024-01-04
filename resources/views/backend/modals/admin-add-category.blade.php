@extends('backend.layouts.dashboard-template')

@section('vite-resource')
@vite(['resources/css/admin-dashboard.css', 'resources/css/side-nav.css', 'resources/css/admin-dashboard-category.css'])
@endsection

@section('page-title')
    Dashboard-Add Category
@endsection

@section('bread-crumb')
    Dashboard/Category/Add
@endsection

@section('content')
<div class="form-container">
    <span>Add a Category</span>
    <form action={{ route('admin-category.store') }} autocomplete="off" method="POST">
        @csrf
        <label for="category_name">Category Name </label><br>
        <input type="text" name="category_name" placeholder="Enter Category Name"><br>

        <select name="parent_id" id="">
            <option value="">-- Select Parent Category --</option>
                @if($datas)
                    @foreach ($datas as $data)
                        <option value={{ $data->id }}>{{ $data->category_name }}</option>
                    @endforeach
                @endif
        </select>

        <input type="submit" name="" id="" value="Create New Category">
        
        @if (session('message'))
        <span class="message">{{ session('message') }}</span>
        @endif

        @if($errors->any())
        @foreach ($errors->all() as $error)
            <span class="message">{{ $error }}</span><br>
        @endforeach                    
        @endif

    </form>
</div>
@endsection

    