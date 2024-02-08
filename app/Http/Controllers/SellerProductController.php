<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = auth()->user();
        $products = Product::with('category')->where('user_id', $user->id)->paginate(10);
        return view('userend.my-products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Category $category
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(Category $category): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $parentCategory = $category->whereNull('parent_id')->paginate(10);
        $childCategories = $category->whereIn('parent_id', $parentCategory->pluck('id'))->get();
        $grandchildCategories = $category->whereIn('parent_id', $childCategories->pluck('id'))->get();
        return view('userend.create-product', compact('parentCategory', 'childCategories', 'grandchildCategories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        try{
            $request['slug'] = Str::slug($request->input('product_title'));
            $imageName = 'solo' . time() . 'leveling' .'.'. $request->product_image->extension();

            if($imagePath = $request->file('product_image')->storeAs('images', $imageName, 'public')){
                $productAd=Product::create([
                    'user_id' => $request->input('user_id'),
                    'product_title' => $request->input('product_title'),
                    'product_description' => $request->input('product_description'),
                    'product_price' => $request->input('product_price'),
                    'image_path' => $imagePath,
                    'slug' => $request['slug'],
                    'category_id' => $request->sub_sub_category,
                ]);


                $tagIds = [];
                foreach ($request->input('product_tags') as $tagName){
                    $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $productAd->tags()->sync($tagIds);
                return redirect()->back()->with('message', 'Product Add Success.');

            }
            return redirect()->back()->with('message', 'Product Add Failed.');

        }catch(\Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Product $productAd
     * @param string $productId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(Product $product, string $productId): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
//        $mainParent = Category::whereNull('parent_id')->paginate(10);
        $productDetails = $product->with('tags')->find($productId);
        $subSubCategory = $productDetails->category;
        $subCategory = $productDetails->parentCategory;
        $parentCategory = $productDetails->grandParentCategory;
        return view('userend.edit-product', compact('productDetails', 'subSubCategory', 'subCategory', 'parentCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param CreateProductRequest $request
     * @param string $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateProductRequest $request, string $productId): \Illuminate\Http\RedirectResponse
    {
        try {
            $product = Product::findOrFail($productId);
            $imagePath = $product->image_path;

            if ($product){
                if ($request->hasFile('product_image')){
                    if ($product->product_image){
                        Storage::delete($product->product_image);
                    }
                    $imageName = 'solo' . time() . 'leveling' .'.'. $request->product_image->extension();
                    $imagePath = $request->file('product_image')->storeAs('images', $imageName, 'public');
                }

                $product->update([
                    'product_title' => $request->product_title,
                    'product_description' => $request->product_description,
                    'product_price' => $request->product_price,
                    'category_id' => $request->sub_sub_category,
                    'image_path' => $imagePath
                ]);

                $tagIds = [];
                foreach ($request->input('product_tags') as $tagName){
                    $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $product->tags()->sync($tagIds);

                return redirect()->back()->with('message', 'Product Updated!');
            }
            return redirect(route('my-products-ads'))->with('message', "Product doesn't exist!");
        }catch (\Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $productId): \Illuminate\Http\RedirectResponse
    {
        try {
            $product = Product::find($productId);
            Storage::disk('public')->delete($product->image_path);
            $product->delete();
            return redirect()->back()->with('message', 'Product Deleted');
        }catch (\Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}