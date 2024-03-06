<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
//use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\Foundation\Application|Application|Factory|View
     * @throws \Exception
     */
    public function index(): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        try {
            $user = auth()->user();
            $products = Product::with('category')->where('user_id', $user->id)->paginate(10);
            return view('userend.my-products', compact('products'));
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Excepion Details: '. $e);
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param Category $category
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws \Exception
     */
    public function create(Category $category): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $parentCategory = $category->whereNull('parent_id')->paginate(10);
            return view('userend.create-product', compact('parentCategory'));
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . json_encode($e->getTrace(), JSON_PRETTY_PRINT));
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function store(CreateProductRequest $request): RedirectResponse
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
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            DB::rollBack();
            throw $e;
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
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws \Exception
     */
    public function edit(Product $product, string $productId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $productDetails = $product->with('tags')->find($productId);
            $subSubCategory = $productDetails->category;
            $subCategory = $productDetails->parentCategory;
            $parentCategory = $productDetails->grandParentCategory;
            return view('userend.edit-product', compact('productDetails', 'subSubCategory', 'subCategory', 'parentCategory'));
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     * @param CreateProductRequest $request
     * @param string $productId
     * @return RedirectResponse
     */
    public function update(CreateProductRequest $request, string $productId): RedirectResponse
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

                return redirect(route('my-product-ads'))->with('message', 'Product Updated!');
            }
            return redirect(route('my-products-ads'))->with('message', "Product doesn't exist!");
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . json_encode($e->getTrace(), JSON_PRETTY_PRINT));
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $productId
     * @return RedirectResponse
     */
    public function destroy(string $productId): RedirectResponse
    {
        try {
            $product = Product::find($productId);
            Storage::disk('public')->delete($product->image_path);
            $product->delete();
            return redirect()->back()->with('message', 'Product Deleted');
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . json_encode($e->getTrace(), JSON_PRETTY_PRINT));
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
