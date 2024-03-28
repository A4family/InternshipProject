<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\CheckoutRepositoryInterface;

class CheckoutRepository implements CheckoutRepositoryInterface
{
    /**
     * Find product to checkout
     * @param string $productId
     * @return mixed
     */
    public function getCheckoutProducts(string $productId)
    {
        return Product::find($productId);
    }
}
