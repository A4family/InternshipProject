<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $mainParent = $category->whereNull('parent_id')->paginate(10);
        return view('backend.admin-category', compact('mainParent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $data = $category->whereNull('parent_id')
        ->orWhereHas('parent', fn ($query) => $query->whereNull('parent_id'))
        ->paginate(10);
        return view('backend.modals.admin-add-category', ['datas' => $data]);
    }

    /**
     * 
     * 
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try{
            Category::create([
                'category_name' => $request->category_name,
                'parent_id' => $request->parent_id,
            ]);
            return redirect()->back()->with('message', 'Category Inserted.');
        }catch(\Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $editableData = Category::select('id', 'category_name','parent_id')->findOrFail($id);
            $data = Category::whereNull('parent_id')
            ->orWhereHas('parent', fn ($query) => $query->whereNull('parent_id'))
            ->paginate(10);
            return view('backend.modals.admin-edit-category', ['editableData' => $editableData],
                                                            ['datas' => $data]);
        }catch(\Exception $e){

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request)
    {
        try{
            Category::where('id', $request->category_id)->update([
                'category_name' => $request->category_name,
                'parent_id' => $request->parent_id,
            ]);
            return redirect()->back()->with('message', 'Edit Success!');


        }catch(\Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Category::find($id)->delete();
            return redirect()->back()->with('message', 'Category Deleted');
        }catch(\Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }

    }
}
