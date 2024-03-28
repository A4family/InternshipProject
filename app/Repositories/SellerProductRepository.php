<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\SellerProductRepositoryInterface;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class SellerProductRepository implements SellerProductRepositoryInterface
{
    /**
     * Fetch all self product
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $user = auth()->user();
        $products = Product::with('category')->where('user_id', $user->id)->paginate(10);
        return $products;
    }

    public function getById($id){

    }


    /**
     * Store new product to sell
     * @param array $data
     * @return array|string[]
     * @throws \Exception
     */
    public function store(array $data): array
    {
        try {
            DB::beginTransaction();
            $data['slug'] = Str::slug($data['product_title']);
            $imageName = 'solo' . time() . 'leveling' . '.' . $data['product_image']->extension();

            if ($imagePath = $data['product_image']->storeAs('images', $imageName, 'public')) {
                $productAd = Product::create([
                    'user_id' => $data['user_id'],
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_price' => $data['product_price'],
                    'image_path' => $imagePath,
                    'slug' => $data['slug'],
                    'category_id' => $data['sub_sub_category'],
                ]);

                $tagIds = [];
                foreach ($data['product_tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $productAd->tags()->sync($tagIds);
                DB::commit();

                return ['status' => 200, 'message' => 'Product Insert Success.'];
            }

            return ['message' => 'Product Add Failed'];
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * update existing product
     * @param $productId
     * @param array $data
     * @return array|string[]
     * @throws \Exception
     */
    public function update($productId, array $data): array
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($productId);
            $imagePath = $product->image_path;

            if ($product) {
                if (isset($data['product_image'])) {
                    if ($product->product_image) {
                        Storage::delete($product->product_image);
                    }
                    $imageName = 'solo' . time() . 'leveling' . '.' . $data['product_image']->extension();
                    $imagePath = $data['product_image']->storeAs('images', $imageName, 'public');
                }

                $product->update([
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_price' => $data['product_price'],
                    'category_id' => $data['sub_sub_category'],
                    'image_path' => $imagePath,
                ]);

                $tagIds = [];
                foreach ($data['product_tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $product->tags()->sync($tagIds);
                DB::commit();

                return ['status' => 200, 'message' => 'Product Update Success.'];
            }

            return ['message' => 'Product Update Failed'];
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove existing product
     * @param $productId
     * @return array
     * @throws \Exception
     */
    public function delete($productId): array
    {
        try {
            DB::beginTransaction();
            $product = Product::find($productId);
            Storage::disk('public')->delete($product->image_path);
            $product->delete();
            DB::commit();
            return ['status' => 200, 'message' => 'Product Deleted.'];
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            DB::rollBack();
            throw $e;
        }
    }
}
