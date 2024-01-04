<tr>
    <td>{{ $category->id }}</td>
    <td style="text-align: left">
        {{ str_repeat('-', $category->level) }} {{ $category->category_name }}</td>
    <td><a href={{ route('admin-category.edit', ['admin_category' => $category->id]) }}><button>Edit</button></a></td>
    <td><button onclick="confirmDelete({{ $category->id }})">Delete</button></td></tr>



@if ($category->children->isNotEmpty())
    @foreach ($category->children as $child)
        @include('commonComponents.admin-category', ['category' => $child])
    @endforeach    
@endif


