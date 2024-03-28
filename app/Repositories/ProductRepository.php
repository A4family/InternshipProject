<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * FInd particular product
     * @param string $productId
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
     * @throws \Exception
     */
    public function show(string $productId): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        try {
            return Product::with('category')->findOrFail($productId);
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            throw $e;
        }
    }


    /**
     * Fetch product of particular category
     * @param string $categoryId
     * @return array
     * @throws \Exception
     */
    public function categoryProductList(string $categoryId): array
    {
        try {
            $categoryIds = $this->getAllChildrenCategory($categoryId);

            $categoryIds[] = $categoryId;

            $products = Product::whereHas('category', function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            })->paginate(10);

            //$products = Product::where('category_id', $categoryId)->paginate(10);

            $categoryName = Category::findOrFail($categoryId)->category_name;

            return [
                'categoryName' => $categoryName,
                'products' => $products,
            ];
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            throw $e;
        }
    }


    /**
     * fetch all child category
     * @param $parentId
     * @return array
     */
    public function getAllChildrenCategory($parentId)
    {
        $childrenIds = Category::where('parent_id', $parentId)->pluck('id')->toArray();

        $allChildrenIds = $childrenIds;

        foreach ($childrenIds as $childId) {
            $allChildrenIds = array_merge($allChildrenIds, $this->getAllChildrenCategory($childId));
        }

        return $allChildrenIds;
    }
}
