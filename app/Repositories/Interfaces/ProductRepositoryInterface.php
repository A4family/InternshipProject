<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface{
    public function show(string $productId);

    public function categoryProductList(string $categoryId);

    public function getAllChildrenCategory($parentId);
}
