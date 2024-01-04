@extends('backend.layouts.dashboard-template')

@section('vite-resource')
@vite(['resources/css/admin-dashboard.css', 'resources/css/side-nav.css', 'resources/css/admin-dashboard-category.css'])
@endsection

@section('page-title')
    Dashboard-Category
@endsection

@section('bread-crumb')
    Dashboard/Category
@endsection

@section('content')
    <div class="add-button-container">
        <a href={{ route('admin-category.create') }}><button>Add Category</button></a>
    </div>
    <div class="display-data-container">
        <span>Categories</span>


        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th colspan="3">Utilities</th>
                </tr>
                
                @foreach ($mainParent as $parentCategory)
                    @include('commonComponents.admin-category', ['category' => $parentCategory])
                @endforeach

            </table>
            
        </div>

        {{ $mainParent->links() }}
    </div>
    <script>
            function confirmDelete(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            window.location.href = '/admin-category/' + categoryId + '/destroy';
        }
    }
    </script>
@endsection